<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PictureController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(string $file_name)
    {
        // $view = request()->expectsJson() ? 'doctor.json.show' : 'doctor.nojson.show';
        // return response()->view($view, ['doctor'=>$doctor]);
        return response()->make(\Storage::get($file_name), 200, ['content-type'=>'image/jpeg']);
        //
    }
}
