<?php

namespace App\Http\Controllers;

use App\Events\BarangmasukLabEvent;
use App\Models\Bahan;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Barangmasuk;
use App\Models\Satuan;
use App\Models\Lab;
use App\Models\Kemasan;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
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
        $bahan = Bahan::with('satuan')->get(['nama_bahan', 'id_satuan', 'id_bahan']);
        $kategori = Kategori::all(['nama_kategori', 'id_kategori']);
        $supplier = Supplier::all(['nama_supplier', 'id_supplier']);
        $satuans = Satuan::all(['satuan', 'id_satuan']);
        $kemasan = Kemasan::all(['jenis_kemasan', 'id_kemasan']);


        return view('barangmasuk.index', compact('bahan', 'kategori', 'supplier', 'satuans', 'kemasan'));
    }

    public function data()
    {
        if (Gate::denies('barangmasuk_index')) {
            return jsonResponse("Anda tidak dapat Mengakses Halaman atau Tindakan ini", 403);
        }
        $barangmasuk = Barangmasuk::join('bahan', 'bahan.id_bahan', '=', 'barangmasuk.id_bahan')
            ->leftJoin('kategori', 'kategori.id_kategori', '=', 'barangmasuk.id_kategori')
            // ->leftJoin('satuan', 'satuan.id_satuan', '=', 'barangmasuk.id_satuan')
            ->leftJoin('users', 'users.id', '=', 'barangmasuk.user_id')
            ->leftJoin('supplier', 'supplier.id_supplier', '=', 'barangmasuk.id_supplier')
            ->leftJoin('kemasan', 'kemasan.id_kemasan', '=', 'barangmasuk.id_kemasan')
            // ->leftJoin('satuan', 'satuan.id_satuan', '=', 'barangmasuk.id_satuan')
            ->join('lab', 'lab.id_barangmasuk', '=', 'barangmasuk.id_barangmasuk')
            ->select('barangmasuk.*', 'bahan.nama_bahan', 'kategori.nama_kategori', 'supplier.nama_supplier', 'lab.status', 'kemasan.jenis_kemasan', 'users.name')
            ->orderBy('kode_barangmasuk', 'asc');

        return datatables()
            ->of($barangmasuk)
            ->addIndexColumn()
            ->addColumn('kode_barangmasuk', function ($barangmasuk) {
                return '<span class="label label-success">' . $barangmasuk->kode_barangmasuk . '</span>';
            })
            ->addColumn('jumlah_bahan', function ($barangmasuk) {
                return format_uang($barangmasuk->jumlah_bahan);
            })
           ->addColumn('created_at', function ($barangmasuk) {
                 return date('d-m-Y H:i:s', strtotime($barangmasuk->created_at));
            })
            ->addColumn('aksi', function ($barangmasuk) {
                return '
            <div class="">
                <button onclick="editForm(`' . route('barangmasuk.update', $barangmasuk->id_barangmasuk) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                <button onclick="deleteData(`' . route('barangmasuk.destroy', $barangmasuk->id_barangmasuk) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
            </div>
            ';
            })
            ->rawColumns(['aksi', 'kode_barangmasuk'])
            ->make(true);
    }

    // <button onclick="alert(`belum ada fungsi :(`)" class="btn btn-xs btn-primary btn-flat">Lab <i class="fa fa-flask"></i></button>
    // $maxNumber = DB::table('labpdaftar')->max('id');
    // $prefix = "PA";
    // $register = $prefix . str_pad($maxNumber + 1, 5, '0', STR_PAD_LEFT);

    public function store(Request $request)
    {
        try {
            $this->authorize('barangmasuk_create');
            DB::beginTransaction();
            $barangmasuk = Barangmasuk::latest()->first() ?? new Barangmasuk();


            $barangmasuk->kode_barangmasuk = kodeOtomatis('BR');
            //ates2

            $lab = Lab::latest()->first() ?? new Lab();
            $kode_lab = (int) $lab->kode_lab + 1;

            $barangmasuk->id_bahan = $request->id_bahan;
            $barangmasuk->id_kategori = $request->id_kategori;
            $barangmasuk->id_supplier = $request->id_supplier;
            $barangmasuk->id_kemasan = $request->id_kemasan;
            $barangmasuk->nomor_po = $request->nomor_po;
            $barangmasuk->pengirim = $request->pengirim;
            $barangmasuk->penerima = $request->penerima;
            $barangmasuk->berat_kotor = $request->berat_kotor;
            $barangmasuk->tara = $request->tara;
            $barangmasuk->netto = $request->netto;
            $barangmasuk->reject = $request->reject;
            $barangmasuk->kendaraan = $request->kendaraan;
            $barangmasuk->jumlah_bahan = $request->jumlah_bahan;
            $barangmasuk->user_id = Auth::id();
            $barangmasuk->save();

            $insertLab = null;
            if ($barangmasuk) {
                $insertLab = Lab::create([
                    'kode_lab' => kodeAuto('LB'), ($kode_lab),
                    'id_barangmasuk' => $barangmasuk->id_barangmasuk,
                    'satuan' => $barangmasuk->id_satuan,
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
            return response()->json($barangmasuk);
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
            $barangmasuk->id_bahan = $request->id_bahan;
            $barangmasuk->id_kategori = $request->id_kategori;
            $barangmasuk->id_supplier = $request->id_supplier;
            $barangmasuk->id_kemasan = $request->id_kemasan;
            $barangmasuk->nomor_po = $request->nomor_po;
            $barangmasuk->pengirim = $request->pengirim;
            $barangmasuk->penerima = $request->penerima;
            $barangmasuk->berat_kotor = $request->berat_kotor;
            $barangmasuk->tara = $request->tara;
            $barangmasuk->netto = $request->netto;
            $barangmasuk->reject = $request->reject;
            $barangmasuk->kendaraan = $request->kendaraan;
            $barangmasuk->jumlah_bahan = $request->jumlah_bahan;
            $barangmasuk->save();
            return jsonResponse('Data berhasil disimpan', 200);
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
