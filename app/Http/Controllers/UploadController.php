<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Photo;

class UploadController extends Controller
{
    const OK_FACTOR = 50;
    const allowedMimeTypes = ['image/jpeg','image/jpg','image/png'];

    public function original(Request $request)
    {
        $filename = uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
        $request->file('photo')->move(Photo::getDir(), $filename);
        return $filename;
    }

    public function cropped(Request $request)
    {
        $filename = uniqid() . '.jpg';
        $image = new \claviska\SimpleImage();
        $image
            ->fromFile($request->file('cropped_image'))
            ->resize(2000, null)
            ->toFile(Photo::getDir('cropped') . $filename, 'image/jpeg', 20);
        // $request->file('cropped_image')->move(Photo::getDir('cropped'), $filename);
        $photo = Photo::find($request->id);
        $photo->update(['cropped' => $filename]);
        return $photo;
    }

    public function pageItem(Request $request)
    {
        $filename = uniqid() . '.' . $request->file('pageitem')->getClientOriginalExtension();
        $request->pageitem->storeAs('pageitems', $filename, 'public');
        return $filename;
    }
}