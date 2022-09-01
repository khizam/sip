<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDetailParameterRequest;
use App\Models\ParameterLab;
use App\Models\Parameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ParameterLabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($id_lab = null)
    {
        $parameter = Parameter::all(['nama_parameter', 'id_parameter']);
        $data = [
            'parameter' => $parameter
        ];
        return view('parameterlab.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data($id_lab)
    {
        $parameterLab = ParameterLab::leftJoin('lab', 'lab.id_lab', '=', 'parameter_lab.id_lab')
            ->leftJoin('parameter', 'parameter.id_parameter', '=', 'parameter_lab.id_parameter')
            ->select('lab.id_lab', 'lab.id_barangmasuk', 'parameter.id_parameter', 'parameter.nama_parameter')
            ->orderBy('parameter_lab.id_parameterlab', 'asc')
            ->where('parameter_lab.id_lab', $id_lab);

        return datatables()
            ->of($parameterLab)
            ->addIndexColumn()

        ->addColumn('aksi', function ($detailproduksi) {
            $html = '<div class="">';
                $html .= '<button onclick="editDetailForm(`' . route('detailProduksi.show', $detailproduksi->id_detail) . '` , `' . route('detailProduksi.update', $detailproduksi->id_detail) . '`)" class="btn btn-xs btn-primary btn-flat"><i class="fa fa-pencil"></i></button>
                <button onclick="deleteData(`' . route('detailProduksi.destroy', $detailproduksi->id_detail) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>';
                $html .= '<button onclick="deleteData(`' . route('detailProduksi.destroy', $detailproduksi->id_detail) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>';

                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['aksi'])
            ->make(true);
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
    public function store(StoreDetailParameterRequest $request)
    {
        try {
            DB::beginTransaction();
            ParameterLab::create($request->validated());
            DB::commit();
            return redirect()
                ->route('parameterlab.index', $request->id_lab)
                ->with('success', 'berhasil diproses');
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error("tambah request detail produksi" . $th);
            return redirect()
                ->route('parameterlab.index', $request->id_lab)
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
