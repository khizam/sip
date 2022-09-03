<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDetailParameterRequest;
use App\Models\ParameterLab;
use App\Models\Parameter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
            ->select('lab.id_lab', 'lab.id_barangmasuk', 'id_parameterlab', 'parameter.id_parameter', 'parameter.nama_parameter', 'parameter.nomor_parameter')
            ->orderBy('parameter_lab.id_parameterlab', 'asc')
            ->where('parameter_lab.id_lab', $id_lab);

        return datatables()
            ->of($parameterLab)
            ->addIndexColumn()

            ->addColumn('aksi', function ($parameterLab) {
                $html = '<div class="">
                    <button onclick="deleteData(`' . route('detailParameter.destroy', $parameterLab->id_parameterlab) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                    </div>';
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
            DB::beginTransaction(); // mulai
            foreach ($request->id_parameter as $value) {
                $data = [
                    'id_lab' => $request->id_lab,
                    'id_parameter' => $value,
                ];
                // dump($data);
                ParameterLab::create($data);
            }
            // die();
            DB::commit(); // melakukan
            // dd('debuging sampe sini');
            return redirect()
                ->route('detailParameter.index', $request->id_lab)
                ->with('success', 'berhasil diproses');
        } catch (\Throwable $th) {
            DB::rollback(); // mengembalikan
            Log::error("tambah request detail produksi" . $th);
            return redirect()
                ->route('detailParameter.index', $request->id_lab)
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
        $parameterLab = ParameterLab::find($id);
        $parameterLab->delete();

        return response()->json('', Response::HTTP_NO_CONTENT);
    }
}
