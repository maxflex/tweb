<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestStore;
use Illuminate\Support\Facades\Mail;
use App\Mail\Order;
use DB;

class RequestsController extends Controller
{
    public function store(RequestStore $request)
    {
        DB::table('request_log')->insert([
            'data' => json_encode($request->all())
        ]);
        Mail::send(new Order($request->all()));
    }
}
