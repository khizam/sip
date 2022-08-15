<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGradeLabProduksiRequest;
use App\Models\GradeLabProduksi;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Grade;
use App\Models\DetailProduksi;
use Illuminate\Http\Response;
use App\Models\ProduksiBarang;
use App\Models\LabProduksi;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GradeLabProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_produksi = null)
    {
        $grade = Grade::all(['nama_grade', 'id_grade']);
        $data = [
            'grade' => $grade
        ];
        if ($id_produksi != null) {
            $produksibarang = ProduksiBarang::leftJoin('produk', 'produk.id_produk', '=', 'produksi_barang.id_produk')
                ->select(['produk.nama_produk'])
                ->first();
            $data += [
                'produksibarang' => $produksibarang,
            ];
        }

        if ($id_produksi != null) {
            $labproduksi = LabProduksi::leftJoin('produksi_barang', 'produksi_barang.id_produksi', '=', 'lab_produksi.id_produksi')
                ->select(['produksi_barang.jumlah_hasil_produksi'])
                ->first();
            $data += [
                'labproduksi' => $labproduksi,
            ];
        }

        return view('grade_lab_produksi.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function data($id_produksi)
    {
        $gradelabproduksi = GradeLabProduksi::leftJoin('lab_produksi', 'lab_produksi.id_produksi', '=', 'grade_lab_produksi.id_produksi')
            ->leftJoin('grade', 'grade.id_grade', '=', 'grade_lab_produksi.id_grade')
            ->select('grade_lab_produksi.*', 'grade.nama_grade', 'lab_produksi.id_produksi')
            ->orderBy('grade_lab_produksi.id_gradelab', 'ASC')
            ->where('grade_lab_produksi.id_produksi', $id_produksi)
            ->get();

        return datatables()
            ->of($gradelabproduksi)
            ->addIndexColumn()

            ->addColumn('aksi', function ($gradelabproduksi) {
                return '
            <div class="">
                <button onclick="editForm(`' . route('grade-lab-produksi.update', $gradelabproduksi->id_grade) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                <button onclick="deleteData(`' . route('grade-lab-produksi.destroy', $gradelabproduksi->id_grade) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
            </div>
            ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGradeLabProduksiRequest $request)
    {
        try {
            $inputReqJumlahProduk = $request->jumlah_produk;
            DB::beginTransaction();
            $grade = GradeLabProduksi::select(DB::raw('SUM(jumlah_produk) as total_jumlah_produk'))->where('id_produksi', $request->id_produksi)->first();
            $labProduksi = LabProduksi::where('id_produksi', $request->id_produksi)->first(['jumlah_produksi']);
            $jumlahHasilProduksi = $labProduksi->jumlah_produksi;
            $totalGradeProduksi = $grade->total_jumlah_produk + $inputReqJumlahProduk;
            if ($totalGradeProduksi > $jumlahHasilProduksi) {
                throw new HttpException(500, 'Maaf, grade tidak lebih dari ' . $jumlahHasilProduksi);
            }
            if ($inputReqJumlahProduk > $jumlahHasilProduksi) {
                throw new HttpException(500, 'Maaf, input tidak lebih dari ' . $jumlahHasilProduksi);
            }
            $stok = [
                'stok' => $inputReqJumlahProduk,
            ];
            $requestData = array_merge($request->validated(), $stok);
            GradeLabProduksi::create($requestData);
            DB::commit();
            return redirect()
                ->route('grade-lab-produksi.index', $request->id_produksi)
                ->with('success', 'berhasil diproses');
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error("tambah request detail produksi" . $th);
            return redirect()
                ->route('grade-lab-produksi.index', $request->id_produksi)
                ->with('errors-throw', $th->getMessage());
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
            $gradelabproduksi = GradeLabProduksi::with('grade')->find($id);
            if ($gradelabproduksi == null) {
                throw new NotFoundHttpException('grade tidak ditemukan');
            }
            return jsonResponse($gradelabproduksi);
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
    public function update(Request $request, $gradelabproduksi)
    {
        try {
            $gradelabproduksi->update($request->validated());
            return jsonResponse($gradelabproduksi);
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
    public function destroy($gradelabproduksi)
    {
        try {
            $gradelabproduksi->delete();
            return jsonResponse('', Response::HTTP_NO_CONTENT);
        } catch (AuthorizationException $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_FORBIDDEN);
        } catch (NotFoundHttpException $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
