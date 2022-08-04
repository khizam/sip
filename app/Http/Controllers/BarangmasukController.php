<?php

namespace App\Http\Controllers;

use App\Events\BarangmasukLabEvent;
use App\Models\Bahan;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Barangmasuk;
use App\Models\Satuan;
use App\Models\Lab;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BarangmasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('barangmasuk_index');
        $bahan = Bahan::all()->pluck('nama_bahan', 'id_satuan', 'id_bahan');
        $kategori = Kategori::all()->pluck('nama_kategori', 'id_kategori');
        $supplier = Supplier::all()->pluck('nama_supplier', 'id_supplier');
        $satuan = Satuan::all()->pluck('satuan', 'id_satuan');

        return view('barangmasuk.index', compact('bahan', 'kategori', 'supplier'));
    }

    public function data()
    {
        if (Gate::denies('barangmasuk_index')) {
            return jsonResponse("Anda tidak dapat Mengakses Halaman atau Tindakan ini", 403);
        }
        $barangmasuk = Barangmasuk::join('bahan', 'bahan.id_bahan', '=', 'barangmasuk.id_bahan')
        ->leftJoin('kategori', 'kategori.id_kategori', '=', 'barangmasuk.id_kategori')
        ->leftJoin('supplier', 'supplier.id_supplier', '=', 'barangmasuk.id_supplier')
        // ->leftJoin('satuan', 'satuan.id_satuan', '=', 'barangmasuk.id_satuan')
        ->join('lab', 'lab.id_barangmasuk', '=', 'barangmasuk.id_barangmasuk')
        ->select('barangmasuk.*', 'nama_bahan', 'id_satuan', 'nama_kategori', 'nama_supplier', 'lab.status', 'satuan')
        ->orderBy('kode_barangmasuk', 'asc')
        ->get();


        return datatables()
            ->of($barangmasuk)
            ->addIndexColumn()
            ->addColumn('kode_barangmasuk', function ($barangmasuk) {
                return '<span class="label label-success">' . $barangmasuk->kode_barangmasuk . '</span>';
            })
            ->addColumn('jumlah_bahan', function ($barangmasuk) {
                return format_uang($barangmasuk->jumlah_bahan);
            })
            ->addColumn('aksi', function ($barangmasuk) {
                return '
            <div class="">
                <button onclick="editForm(`' . route('barangmasuk.update', $barangmasuk->id_barangmasuk) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                <button onclick="deleteData(`' . route('barangmasuk.destroy', $barangmasuk->id_barangmasuk) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                <button onclick="alert(`belum ada fungsi :(`)" class="btn btn-xs btn-primary btn-flat">Lab <i class="fa fa-flask"></i></button>
            </div>
            ';
            })
            ->rawColumns(['aksi', 'kode_barangmasuk'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public static function convertdate()
    // {
    //     date_default_timezone_set('Asia/jakarta');
    //     $date = date('dmy');
    //     return $date;
    // }

    // public static function autonumber($barangmasuk, $primary, $prefix) {
    //     $q=DB::table($barangmasuk)->select(DB::raw('Max(RIGHT('.$primary.',5)) as kd_max'));
    //     $prx=$prefix.Dateindo::convertdate();
    //     if($q->count()>0)
    //     {
    //         foreach($q->get() as $k)
    //         {
    //             $tmp = ((int)$k->kd_max)+1;
    //             $kd = $prx.sprintf("%06s", $tmp);
    //         }
    // }
    // else
    // {
    //     $kd = $prx."000001";
    // }
    // return $kd;
    // }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->authorize('barangmasuk_create');
            DB::beginTransaction();
            $barangmasuk = Barangmasuk::latest()->first() ?? new Barangmasuk();
            $kode_barangmasuk = (int) $barangmasuk->kode_barangmasuk + 1;

            $barangmasuk = new barangmasuk();
            $barangmasuk->kode_barangmasuk = tambah_nol_didepan($kode_barangmasuk, 6);
            // $request['kode_barangmasuk'] = 'P'. tambah_nol_didepan((int)$barangmasuk->id_barangmasuk +1, 6);
            $lab = Lab::latest()->first() ?? new Lab();
            $kode_lab = (int) $lab->kode_lab + 1;

            $barangmasuk->id_bahan = $request->id_bahan;
            $barangmasuk->id_kategori = $request->id_kategori;
            $barangmasuk->id_supplier = $request->id_supplier;
            $barangmasuk->jumlah_bahan = $request->jumlah_bahan;
            $barangmasuk->save();

            $insertLab = null;
            if ($barangmasuk) {
                $insertLab = Lab::create([
                    'kode_lab' => tambah_nol_didepan($kode_lab, 6),
<<<<<<< HEAD
                    'id_barangmasuk'=> $barangmasuk->id_barangmasuk,
                    'satuan' => $barangmasuk->id_satuan,
=======
                    'id_barangmasuk' => $barangmasuk->id_barangmasuk,
                    'satuan' => 'kg',
>>>>>>> ee9bef46c77d626374e09c9a8e84a368c01adcac
                    'bahan_layak' => 0,
                    'bahan_tidak_layak' => 0,
                ]);
            }

            DB::commit();
            event(new BarangmasukLabEvent($insertLab));
            return response()->json('Data berhasil disimpan', 200);
        } catch (AuthorizationException $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_FORBIDDEN);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error("tambah barang masuk" . $th);
            return response()->json('gagal disimpan' . $th->getMessage(), 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $this->authorize('barangmasuk_edit');
            $barangmasuk = Barangmasuk::find($id);
            if ($barangmasuk == null) {
                throw new NotFoundHttpException('barang masuk tidak ditemukan');
            }
        } catch (AuthorizationException $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_FORBIDDEN);
        } catch (NotFoundHttpException $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $this->authorize('barangmasuk_edit');
            $barangmasuk = Barangmasuk::find($id);
            if ($barangmasuk == null) {
                throw new NotFoundHttpException('barang masuk tidak ditemukan');
            }
            $barangmasuk->update($request->all());
        } catch (AuthorizationException $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_FORBIDDEN);
        } catch (NotFoundHttpException $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->authorize('barangmasuk_delete');
            $barangmasuk = Barangmasuk::find($id);
            if ($barangmasuk == null) {
                throw new NotFoundHttpException('barang masuk tidak ditemukan');
            }
            $barangmasuk->delete();
        } catch (AuthorizationException $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_FORBIDDEN);
        } catch (NotFoundHttpException $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
