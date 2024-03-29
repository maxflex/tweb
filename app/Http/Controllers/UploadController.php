<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Photo;

class UploadController extends Controller
{
    const OK_FACTOR = 50;
    const allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png'];

    public function original(Request $request)
    {
        if ($request->file('photo')->getSize() > 5242880) {
            return response()->json(['error' => 'максимальный объём файла – 5 Мб']);
        }
        if ($request->file('photo')->getMimeType() != 'image/jpeg') {
            return response()->json(['error' => 'файл должен быть типа jpg/jpeg']);
        }
        $filename = uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
        $request->file('photo')->move(Photo::getDir(), $filename);
        return $filename;
    }
}
