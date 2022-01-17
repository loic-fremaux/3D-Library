<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Storage;

class FilesController extends Controller
{
    public function listFiles()
    {

        $models = array_map(function ($file) {
            $parts = explode('/', $file);
            return [
                'name' => explode('.', $parts[count($parts) - 1])[0],
                'file' => $file,
                'link' => Storage::drive('public')->url($file),
                'size' => $this->humanFileSize(Storage::drive('public')->size($file)),
                'last_edit' => Carbon::createFromTimestamp(Storage::drive('public')->lastModified($file))->diffForHumans()
            ];
        }, array_filter(Storage::drive('public')->allFiles(), function ($file) {
            return str_ends_with($file, '.stl') || str_ends_with($file, '.obj');
        }));

        // $models = Model

        return view('list_models', [
            'models' => $models,
        ]);
    }

    function humanFileSize($size,$unit="") {
        if( (!$unit && $size >= 1<<30) || $unit == "GB")
            return number_format($size/(1<<30),2)."GB";
        if( (!$unit && $size >= 1<<20) || $unit == "MB")
            return number_format($size/(1<<20),2)."MB";
        if( (!$unit && $size >= 1<<10) || $unit == "KB")
            return number_format($size/(1<<10),2)."KB";
        return number_format($size)." bytes";
    }
}
