<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
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
        $newLogsActivity = $logsActivity->map(function($item){
            $item->description = Arr::get($this->propertiesLogEvents(), $item->description);
            $attribute_text = '';
            foreach ($item->properties as $key => $propertie) {
                $arr_key = array_keys($propertie);
                $arr_values = array_values($propertie);
                if ($key == 'attributes') {
                    $attribute_text .= $this->eachAttributes($item->description, $arr_key, $arr_values);
                }
                if ($key == 'old') {
                    $attribute_text .= $this->eachOldAttributes( $arr_key, $arr_values);
                }
            }
            $item->attributes_to_text = $attribute_text;
            return $item;
        });
        return datatables()
        ->of($newLogsActivity)
        ->addIndexColumn()
        ->addColumn('causer.name', function ($newLogsActivity) {
            $causer = $newLogsActivity->causer->name ?? 'Database Seeder';
            return "<span class='label label-success'>{$causer}</span";
        })
        ->rawColumns(['attributes_to_text','causer.name'])
        ->make(true);
    }

    public function eachAttributes($description, $key, $value)
    {
        $text = "{$description} data dengan detail attributes: <br/>";
        for ($i=0; $i < count($key); $i++) {
            $text .= "<span class='label label-primary'>{$key[$i]}</span> dengan nilai <span class='label label-primary'>{$value[$i]}</span><br/>";
        }
        return $text;
    }

    public function eachOldAttributes($key, $value)
    {
        $text = "<br/> Dari data sebelumnya: <br/>";
        for ($i=0; $i < count($key); $i++) {
            $text .= "<span class='label label-primary'>{$key[$i]}</span> dengan nilai <span class='label label-primary'>{$value[$i]}</span><br/>";
        }
        return $text;
    }

    public function propertiesLogEvents()
    {
        return [
            'created' => 'Menambahkan',
            'updated' => 'Mengubah',
            'deleted' => 'Menghapus',
        ];
    }
}
