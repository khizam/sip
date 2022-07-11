<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateLabRequest;
use App\Models\Barangmasuk;
use App\Models\Lab;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use PDF;

class LabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('lab.index');

    }

    public function data()
    {
        $lab = Lab::join('barangmasuk','barangmasuk.id_barangmasuk','=','lab.id_barangmasuk')
        ->join('bahan', 'bahan.id_bahan', '=', 'barangmasuk.id_bahan')
        ->orderBy('kode_barangmasuk', 'asc')
        ->get();
        // return Lab::all();

        return datatables()
        ->of($lab)
        ->addIndexColumn()
        
        ->addColumn('kode_lab', function ($lab) {
            return '<span class="label label-success">'. $lab->kode_lab .'</span>';
        })

        ->addColumn('id_lab', function ($lab) {
            return '<span class="label label-success">'. $lab->id_lab .'</span>';
        })

        ->addColumn('jumlah_bahan', function ($barangmasuk) {
            return format_uang($barangmasuk->jumlah_bahan);
        })

        ->addColumn('aksi', function ($lab) {
            return '
            <div class="">
                <button onclick="editLabForm(`'. route('lab.editLab', $lab->id_lab) .'` , `'.route('lab.updateLab', $lab->id_lab).'`)" class="btn btn-xs btn-primary btn-flat"><i class="fa fa-plus"></i></button>
                <button onclick="editForm(`'. route('lab.edit', $lab->id_lab) .'` , `'.route('lab.update', $lab->id_lab).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                <button onclick="check(`'. route('lab.edit', $lab->id_lab) .'` , `'.route('lab.checkStatus', $lab->id_lab).'`)" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-check"></i></button>
            </div>
            ';
        })
        ->rawColumns(['aksi', 'id_lab', 'kode_lab'])
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
        $barangmasuk = Barangmasuk::find($id);

        return response()->json($barangmasuk);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $barangMasuk = Lab::with('barang_masuk.bahan','barang_masuk.kategori','barang_masuk.supplier')->find($id);
            if($barangMasuk == null) {
                throw new NotFoundHttpException("barang tidak ditemukan");
            }
            return jsonResponse($barangMasuk, 200);
        } catch (\Throwable $th) {
            return jsonResponse("Terjadi kesalahan ".$th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
        $bahanLayak = $request->bahan_layak;
        $bahanTidakLayak = $request->bahan_tidak_layak;
        try {
            DB::beginTransaction();
            $barangMasuk = Lab::with('barang_masuk')->find($id);
            $jumlahBahanBrgMsk = $barangMasuk->barang_masuk->jumlah_bahan;
            if ($bahanLayak <= $jumlahBahanBrgMsk || $bahanTidakLayak <= $jumlahBahanBrgMsk) {
                $totalBahanLab = $bahanLayak + $bahanTidakLayak;
                if($totalBahanLab <= $jumlahBahanBrgMsk) {
                    $barangMasuk->update($request->only(['bahan_layak', 'bahan_tidak_layak', 'status']));
                    DB::commit();
                    return jsonResponse('Data berhasil disimpan', 200);
                } else {
                    DB::rollback();
                    return jsonResponse('Jumlah bahan layak dan tidak, tidak boleh lebih dari '.$totalBahanLab, Response::HTTP_NOT_ACCEPTABLE);
                }
            } else {
                DB::rollback();
                return jsonResponse('Jumlah bahan layak dan tidak, tidak boleh lebih dari '.$totalBahanLab, Response::HTTP_NOT_ACCEPTABLE);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function editLab($id): JsonResponse
    {
        try {
            $lab = Lab::with('barang_masuk')->find($id);
            if ($lab == null) {
                throw new NotFoundHttpException("barang tidak ditemukan");
            }
            return jsonResponse($lab, 200);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage() ?? 'data tidak ditemukan', $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateLab(UpdateLabRequest $request, $id): JsonResponse
    {
        try {
            $lab = Lab::find($id);
            if ($lab == null) {
                throw new NotFoundHttpException("Barang tidak ditemukan");
            }
            $lab->update($request->validated());
            return jsonResponse($lab);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
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
            $barangmasuk = Barangmasuk::find($id);
            if ($barangmasuk == null) {
                throw new NotFoundHttpException("Barang tidak ditemukan");
            }
            $barangmasuk->delete();
            return jsonResponse(null, Response::HTTP_NO_CONTENT);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function checkStatus(Request $request, $id): JsonResponse
    {
        try {
            $lab = Lab::with('barang_masuk')->find($id);
            if ($lab == null) {
                throw new NotFoundHttpException("Barang tidak ditemukan");
            }
            if($request->status == 'selesai') {
                $jumlahHasilLab = $lab->bahan_layak + $lab->bahan_tidak_layak;
                $jumlahBahanBrgMsk = $lab->barang_masuk->jumlah_bahan;
                if($jumlahBahanBrgMsk != $jumlahHasilLab){
                    throw new HttpException(Response::HTTP_NOT_ACCEPTABLE, "Bahan yang diverifikasi {$jumlahHasilLab} dari {$jumlahBahanBrgMsk}");
                }
            }
            $lab->update($request->all());
            return jsonResponse("berhasil");
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function cetakLab()
    
    {
        $lab = Lab::all();
        // share lab to view
        dd($lab);
        // $pdf = PDF::loadview('lab_pdf',['lab'=>$lab]);
        // return $pdf->download('laporan-lab-pdf');
      
    }
}
