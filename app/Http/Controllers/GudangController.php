<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;


class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('gudang_index')) {
            return jsonResponse("Anda tidak dapat Mengakses Halaman atau Tindakan ini", 403);
        }
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
        if (Gate::denies('gudang_index')) {
            return jsonResponse("Anda tidak dapat Mengakses Halaman atau Tindakan ini", 403);
        }
        $gudang = Gudang::join('bahan', 'bahan.id_bahan', '=', 'gudang.id_bahan');

        return datatables()
            ->of($gudang)
            ->addIndexColumn()

            ->addColumn('id_gudang', function ($gudang) {
                return '<span class="label label-success">' . $gudang->id_gudang . '</span>';
            })

            ->addColumn('bahan_layak', function ($lab) {
                return format_uang($lab->bahan_layak);
            })

            ->addColumn('aksi', function ($gudang) {
                return '';
                //     return '
                // <div class="">
                //     <button onclick="deleteData(`' . route('gudang.destroy', $gudang->id_gudang) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                //     <button onclick="editStok(`' . route('gudang.edit', $gudang->id_gudang) . '`, `' . route('gudang.update', $gudang->id_gudang) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                // </div>
                // ';
            })

            ->rawColumns(['aksi', 'id_gudang', 'bahan_layak'])
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

    public function editGudang($id): JsonResponse
    {
        try {
            $gudang = Gudang::with('lab')->find($id);
            if ($gudang == null) {
                throw new NotFoundHttpException("stok tidak ditemukan");
            }
            return jsonResponse($gudang, 200);
        } catch (NotFoundHttpException $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage() ?? 'data tidak ditemukan', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        $gudang = Gudang::find($id);
        $gudang->delete();

        return response(null, 204);
    }
}
