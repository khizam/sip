<?php

namespace App\Http\Controllers;


use App\Models\Lab;
use App\Models\Gudang;
use App\Models\Enums\StatusGudangEnum;
// use App\Models\Gudang;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('gudang.index');
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

    public function data()
    {
        $gudang = Gudang::with('status_gudang')
        ->join('lab','lab.id_lab','=','gudang.id_lab')
        ->join('barangmasuk', 'barangmasuk.id_barangmasuk','=','lab.id_barangmasuk')
        ->join('bahan', 'bahan.id_bahan', '=', 'barangmasuk.id_bahan')
        ->get();

        return datatables()
        ->of($gudang)
        ->addIndexColumn()

        ->addColumn('id_gudang', function ($gudang) {
            return '<span class="label label-success">'. $gudang->id_gudang .'</span>';
        })

        ->addColumn('bahan_layak', function ($lab) {
            return format_uang($lab->bahan_layak);
        })
        
        // ->addColumn('aksi', function ($lab) {
        //     return '
        //     <div class="">
        //         <button onclick="editLabForm(`'. route('lab.editLab', $lab->id_lab) .'` , `'.route('lab.updateLab', $lab->id_lab).'`)" class="btn btn-xs btn-primary btn-flat"><i class="fa fa-plus"></i></button>
        //         <button onclick="editForm(`'. route('lab.edit', $lab->id_lab) .'` , `'.route('lab.update', $lab->id_lab).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
        //         <button onclick="check(`'. route('lab.edit', $lab->id_lab) .'` , `'.route('lab.checkStatus', $lab->id_lab).'`)" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-check"></i></button>
        //     </div>
        //     ';
        // })
        // 'aksi', 
        ->rawColumns(['id_gudang', 'bahan_layak'])
        ->make(true);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json('Data berhasil disimpan', 200);
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
