<?php

namespace App\Http\Controllers;

use App\Models\GradeLabProduksi;
use App\Models\GudangProdukJadi;
use App\Models\ProduksiBarang;
use App\Models\LabProduksi;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GudangProdukJadiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('gudang_produksi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function data()
    {
        $gudangProdukjadi = GudangProdukJadi::leftJoin('grade_lab_produksi', 'grade_lab_produksi.id_gradelab', '=', 'gudang_produk.id_gradelab')
            ->select('gudang_produk.*', 'gudang_produk.id_gradelab')
            ->orderBy('gudang_produk.id_gradelab', 'ASC')
            ->where('gudang_produk.id_gradelab')
            ->get();


            return datatables()
            ->of($gudangProdukjadi)
            ->addIndexColumn()

            ->addColumn('aksi', function ($gudangProdukjadi) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`' . route('grade-lab-produksi.update', $gudangProdukjadi->id_gradelab) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`' . route('grade-lab-produksi.destroy', $gudangProdukjadi->id_gradelab) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
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
    public function store(Request $request)
    {
        try {
            $gradelabproduksi = GradeLabProduksi::where('id_produksi', $request->id_produksi)->get();

            foreach ($gradelabproduksi as $value) {
                $gudangproduksi = GudangProdukJadi::where('id_gradelab', $value->id_gradelab)->first();
                if (is_null($gudangproduksi)) {
                    GudangProdukJadi::create(['id_gradelab' => $value->id_gradelab]);
                }
            }
            // GudangProdukJadi::create($request->only('id_produksi'));

            $response = route('grade-lab-produksi.index', $request->id_produksi);
            return jsonResponse($response, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
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
