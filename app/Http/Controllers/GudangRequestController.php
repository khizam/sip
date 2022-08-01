<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bahan;
use App\Models\DetailProduksi;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GudangRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bahan = Bahan::all(['nama_bahan', 'id_bahan']);
        return view('gudang_request.index');
    }

    public function data()
    {
        $detailproduksi = DetailProduksi::leftJoin('permintaan_bahan', 'permintaan_bahan.id_detail_produksi', '=', 'detail_produksi.id_detail')
        ->leftJoin('bahan', 'bahan.id_bahan', '=', 'detail_produksi.id_bahan')
        ->select('detail_produksi.*', 'bahan.nama_bahan', 'permintaan_bahan.*')
        ->orderBy('id_detail', 'asc')
        // ->where('id_produksi')
        ->get();

        return datatables()
            ->of($detailproduksi)
            ->addIndexColumn()

            ->addColumn('jumlah', function ($detailproduksi) {
                return format_uang($detailproduksi->jumlah);
            })

            ->addColumn('aksi', function ($detailproduksi) {
                $html = '<div class="">';
                if (is_null($detailproduksi->id_request)) {
                    $html .= '<button onclick="editDetailForm(`' . route('detailProduksi.show', $detailproduksi->id_detail) . '` , `' . route('detailProduksi.update', $detailproduksi->id_detail) . '`)" class="btn btn-xs btn-primary btn-flat"><i class="fa fa-pencil"></i></button>';
                }
                $html .= '<button onclick="deleteData(`' . route('detailProduksi.destroy', $detailproduksi->id_detail) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                    </div>';
                return $html;
            })
            ->rawColumns(['aksi'])
            ->make(true);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
