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
        // try {
        //     /* новая версия отправки заявок в ройстат */
        //     $roistatData = array(
        //             'roistat' => isset($_COOKIE['roistat_visit']) ? $_COOKIE['roistat_visit'] : null,
        //             'key'     => 'MTcxOTM2OjEwMzc2MTo4MjY0YjI0MDA3M2NjM2EzMzVmMjQ2NWNkMWMwNGY2Mw==',
        //             'title'   => 'Новая сделка {visit}',
        //             'name'    => $request->name . ' {visit}',
        //             'phone'   => $request->phone,
        //             'fields'  => array(
        //                 'message' => $request->comment
        //             ),
        //         );
        //     $response = file_get_contents("https://cloud.roistat.com/api/proxy/1.0/leads/add?" . http_build_query($roistatData));
        // } catch (\Exception $e) {
        // }
    }
}
