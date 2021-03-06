<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Gate;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('supplier_index');
        return view('supplier.index');
    }

    public function data()
    {
        if (Gate::denies('supplier_index')) {
            return jsonResponse("Anda tidak dapat Mengakses Halaman atau Tindakan ini", 403);
        }
        $supplier = Supplier::orderBy('id_supplier', 'desc')->get();

        return datatables()
            ->of($supplier)
            ->addIndexColumn()
            ->addColumn('aksi', function ($supplier) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`'. route('supplier.update', $supplier->id_supplier) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`'. route('supplier.destroy', $supplier->id_supplier) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
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
        if (Gate::denies('supplier_create')) {
            return jsonResponse("Anda tidak dapat Mengakses Halaman atau Tindakan ini", 403);
        }
        $supplier = Supplier::latest()->first();
        $supplier = Supplier::create($request->all());
        return response()->json('Data Berhasil Disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('supplier_edit')) {
            return jsonResponse("Anda tidak dapat Mengakses Halaman atau Tindakan ini", 403);
        }
        $supplier = Supplier::find($id);

        return response()->json($supplier);
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
        if (Gate::denies('supplier_edit')) {
            return jsonResponse("Anda tidak dapat Mengakses Halaman atau Tindakan ini", 403);
        }
        $supplier = Supplier::find($id);
        $supplier->nama_supplier = $request->nama_supplier;
        $supplier->alamat = $request->alamat;
        $supplier->telepon = $request->telepon;
        $supplier->contact_person = $request->contact_person;
        $supplier->update();

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
        if (Gate::denies('supplier_delete')) {
            return jsonResponse("Anda tidak dapat Mengakses Halaman atau Tindakan ini", 403);
        }
        $supplier = Supplier::find($id);
        $supplier->delete();

        return response(null, 204);
    }
}
