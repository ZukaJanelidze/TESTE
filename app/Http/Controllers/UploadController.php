<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function store(Request $request)
    {
    $file = $request->file('image');
    $filename = time() . '.' . $file->getClientOriginalExtension();
    $file->move(PUBLIC_PATH('uploads'),$filename);
    return "File uploaded succsessfully: ". $filename;
    }
}
