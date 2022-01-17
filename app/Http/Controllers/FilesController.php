<?php

namespace App\Http\Controllers;

use App\Models\Model3D;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    public function listFiles()
    {

/*        $models = array_map(function ($file) {
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
        }));*/

        $models = Model3D::all();

        return view('list_models', [
            'models' => $models,
        ]);
    }


}
