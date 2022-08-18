<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateLabRequest;
use App\Models\Barangmasuk;
use App\Models\Enums\StatusGudangEnum;
use App\Models\Lab;
use App\Models\Gudang;
use App\Models\Enums\StatusLabEnum;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class LabController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('lab_index');
        return view('lab.index');
    }

    public function data()
    {
        if (Gate::denies('lab_index')) {
            return jsonResponse("Anda tidak dapat Mengakses Halaman atau Tindakan ini", 403);
        }
        $lab = Lab::join('status_gudang as sg', 'sg.id_status', '=', 'lab.id_status_gudang')
            ->join('barangmasuk', 'barangmasuk.id_barangmasuk', '=', 'lab.id_barangmasuk')
            ->join('bahan', 'bahan.id_bahan', '=', 'barangmasuk.id_bahan')
            ->orderBy('lab.created_at', 'DESC')
            ->select(['lab.id_lab', 'lab.kode_lab', 'lab.updated_at', 'bahan.nama_bahan', 'barangmasuk.jumlah_bahan', 'lab.bahan_layak', 'lab.status', 'sg.status as status_gudang']);

        return datatables()
            ->of($lab)
            ->addIndexColumn()
            ->addColumn('kode_lab', function ($lab) {
                return '<span class="label label-success">' . $lab->kode_lab . '</span>';
            })
            ->addColumn('id_lab', function ($lab) {
                return '<span class="label label-success">' . $lab->id_lab . '</span>';
            })
            ->addColumn('aksi', function ($lab) {
                $html = '<div class="">
                            <button onclick="editLabForm(`' . route('lab.editLab', $lab->id_lab) . '` , `' . route('lab.updateLab', $lab->id_lab) . '`)" class="btn btn-xs btn-primary btn-flat"><i class="fa fa-pencil"></i></button>';
                if ($lab->status != StatusLabEnum::Accept) {
                    $html .= '<button onclick="editForm(`' . route('lab.edit', $lab->id_lab) . '` , `' . route('lab.update', $lab->id_lab) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-plus"></i></button>
                    <button onclick="check(`' . route('lab.edit', $lab->id_lab) . '` , `' . route('lab.checkStatus', $lab->id_lab) . '`)" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-check"></i></button>';
                }
                $html .= '</div>';
                return $html;
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
        $this->authorize('lab_create');
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
        $this->authorize('lab_edit');
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
            $this->authorize('lab_edit');
            $barangMasuk = Lab::with('barang_masuk.bahan', 'barang_masuk.kategori', 'barang_masuk.supplier')->find($id);
            if ($barangMasuk == null) {
                throw new NotFoundHttpException("barang tidak ditemukan");
            }
            return jsonResponse($barangMasuk, 200);
        } catch (AuthorizationException $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_FORBIDDEN);
        } catch (NotFoundHttpException $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return jsonResponse("Terjadi kesalahan " . $th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
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
            $this->authorize('lab_edit');
            DB::beginTransaction();
            $barangMasuk = Lab::with('barang_masuk')->find($id);
            $jumlahBahanBrgMsk = $barangMasuk->barang_masuk->jumlah_bahan;
            if ($bahanLayak <= $jumlahBahanBrgMsk || $bahanTidakLayak <= $jumlahBahanBrgMsk) {
                $totalBahanLab = $bahanLayak + $bahanTidakLayak;
                if ($totalBahanLab <= $jumlahBahanBrgMsk) {
                    $barangMasuk->update($request->only(['bahan_layak', 'bahan_tidak_layak', 'status']));
                    DB::commit();
                    return jsonResponse('Data berhasil disimpan', 200);
                } else {
                    DB::rollback();
                    return jsonResponse('Jumlah bahan layak, tidak boleh lebih dari ' . $jumlahBahanBrgMsk, Response::HTTP_NOT_ACCEPTABLE);
                }
            } else {
                DB::rollback();
                return jsonResponse('Jumlah bahan layak, tidak boleh lebih dari ' . $jumlahBahanBrgMsk, Response::HTTP_NOT_ACCEPTABLE);
            }
        } catch (AuthorizationException $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_FORBIDDEN);
        } catch (\Throwable $th) {
            DB::rollback();
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function editLab($id): JsonResponse
    {
        try {
            $this->authorize('lab_edit');
            $lab = Lab::with('barang_masuk', 'barang_masuk.bahan.satuan')->find($id);
            if ($lab == null) {
                throw new NotFoundHttpException("barang tidak ditemukan");
            }
            return jsonResponse($lab, 200);
        } catch (AuthorizationException $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_FORBIDDEN);
        } catch (NotFoundHttpException $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            echo "authorization throwable";
            return jsonResponse($th->getMessage() ?? 'data tidak ditemukan', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateLab(UpdateLabRequest $request, $id): JsonResponse
    {
        try {
            $this->authorize('lab_edit');
            $lab = Lab::find($id);
            if ($lab == null) {
                throw new NotFoundHttpException("Barang tidak ditemukan");
            }
            $lab->update($request->validated());
            return jsonResponse($lab);
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
    public function destroy($id)
    {
        try {
            $this->authorize('lab_delete');
            $barangmasuk = Barangmasuk::find($id);
            if ($barangmasuk == null) {
                throw new NotFoundHttpException("Barang tidak ditemukan");
            }
            $barangmasuk->delete();
            return jsonResponse(null, Response::HTTP_NO_CONTENT);
        } catch (AuthorizationException $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_FORBIDDEN);
        } catch (NotFoundHttpException $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function checkStatus(Request $request, $id): JsonResponse
    {
        $this->authorize('lab_edit');
        try {
            DB::beginTransaction();
            $lab = Lab::with('barang_masuk')->find($id);
            if ($lab == null) {
                throw new NotFoundHttpException("Barang tidak ditemukan");
            }
            if ($request->status == StatusLabEnum::Accept) {
                $jumlahHasilLab = $lab->bahan_layak + $lab->bahan_tidak_layak;
                $jumlahBahanBrgMsk = $lab->barang_masuk->jumlah_bahan;
                if ($jumlahBahanBrgMsk != $jumlahHasilLab) {
                    throw new HttpException(Response::HTTP_NOT_ACCEPTABLE, "Bahan yang diverifikasi {$jumlahHasilLab} dari {$jumlahBahanBrgMsk}");
                }
            }

            // Update Lab id_status_gudang
            $request->merge([
                'id_status_gudang' => StatusGudangEnum::Sudah
            ]);
            $lab->update($request->all());

            // Save To Gudang
            $cariBahandiGudang = Gudang::where('id_bahan', $lab->barang_masuk->id_bahan)->first();
            if (!is_null($cariBahandiGudang)) {
                $ttlStokBahan = $cariBahandiGudang->stok + $lab->bahan_layak;
                $cariBahandiGudang->update([
                    'stok' => $ttlStokBahan,
                ]);
            } else {
                $gudang = new Gudang();
                $gudang->id_bahan = $lab->barang_masuk->id_bahan;
                $gudang->stok = $lab->bahan_layak;
                $gudang->save();
            }
            DB::commit();
            return jsonResponse('Data berhasil disimpan', 200);
        } catch (NotFoundHttpException $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function printPdfLab()
    {
        $this->authorize('lab_edit');
        $labs = Lab::with('barang_masuk.bahan')->get();
        $pdf = Pdf::loadview('lab.lab_pdf', compact('labs'));
        return $pdf->download('laporan-lab.pdf');
    }
}
