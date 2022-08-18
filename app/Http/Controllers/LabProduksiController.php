<?php

namespace App\Http\Controllers;

use App\Models\LabProduksi;
use App\Models\ProduksiBarang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class LabProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('lab_produksi.index');
    }

    public function data()
    {
        $labProduksi = LabProduksi::leftJoin('produksi_barang', 'produksi_barang.id_produksi', '=', 'lab_produksi.id_produksi')
            ->leftJoin('produk', 'produk.id_produk', '=', 'produksi_barang.id_produk')
            ->leftJoin('status_produksi', 'status_produksi.id_status', '=', 'produksi_barang.id_status')
            ->orderBy('lab_produksi.created_at', 'DESC')
            ->select(['id_labproduksi', 'produk.nama_produk', 'status_produksi.status', 'lab_produksi.jumlah_produksi', 'lab_produksi.created_at', 'produksi_barang.jumlah', 'produksi_barang.id_produksi']);

        return datatables()
            ->of($labProduksi)
            ->addIndexColumn()

            ->addColumn('kode_lab', function ($labProduksi) {
                return '<span class="label label-success">' . $labProduksi->kode_lab . '</span>';
            })
            ->addColumn('lost', function ($labProduksi) {
                return is_null($labProduksi->lost) ? '0' : $labProduksi->lost;
            })
            ->addColumn('aksi', function ($labProduksi) {
                $html = '<div class="">
                     <a href=' . route('grade-lab-produksi.index', $labProduksi->id_produksi) . ' class="btn btn-xs btn-primary btn-flat">grade produk</a>
                    </div>';

                return $html;
            })
            ->rawColumns(['aksi', 'kode_lab'])
            ->make(true);
    }

    public function selesaiLost(Request $request, $id_produksi)
    {
        try {
            DB::beginTransaction();
            $labProduksi = LabProduksi::find($id_produksi);
            $Lost = $request->lost;
            if ($Lost > $labProduksi->jumlah_produksi) {
                throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, "jumlah Lost tidak lebih dari" . $labProduksi->jumlah_produksi);
            }
            if ($labProduksi->count() == 0) {
                throw new NotFoundHttpException("Permintaan Lost Tidak ditemukan");
            }
            $labProduksi->update([
                'lost' => $Lost,
            ]);
            DB::commit();
            return jsonResponse($labProduksi);
        } catch (NotFoundHttpException $th) {
                DB::rollback();
                return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
                DB::rollback();
                return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $labProduksi = LabProduksi::latest()->first() ?? new LabProduksi();
        // $labProduksi = (int) $labProduksi->kode_lab + 1;

        // $labProduksi = new LabProduksi();

    }

    public function halGrade($grade_lab)
    {
        return view('grade_lab_produksi.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $labProduksi = LabProduksi::find($id);

        return response()->json($labProduksi);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $labProduksi = LabProduksi::find($id);
        $labProduksi->jumlah_produksi = $request->jumlah_produksi;
        $labProduksi->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $labProduksi = LabProduksi::find($id);
        $labProduksi->delete();

        return response(null, 204);
    }
}
