<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Spatie\Activitylog\Models\Activity;

class LogActivityController extends Controller
{

    public function index()
    {
        return view('log_activity.index');
    }

    public function data()
    {
        $logsActivity = Activity::with('causer')->orderBy('created_at', 'desc')->get();

        return datatables()
        ->of($logsActivity)
        ->addIndexColumn()
        ->make(true);
    }

    // public function delete()
    // {
    //     try {
    //         Artisan::call('activitylog:clean',['days'=>1]);
    //         return redirect()->route('log.activity_user')->with('clean','Berhasil dihapus');
    //     } catch (\Throwable $th) {
    //         return redirect()->route('log.activity_user')->with($th->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }
}
