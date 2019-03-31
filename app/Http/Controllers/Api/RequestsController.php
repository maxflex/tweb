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

        try {
            /**
             * Это ваше дополнение выкидывает 500 Internal Server Error
             */
            $roistat = $_COOKIE['roistat_visit'];
            $formName = 'Расчет ремонта';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'http://bik.agency/mycrm/add.php?roistatID='.urlencode($roistat).'&formName='.urlencode($formName).'&domain=http://souz-pribor.ru'.'&formData[ФИО]='.urlencode($request->name).'&formData[Телефон]='.urlencode($request->phone));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $out = curl_exec($curl);
            curl_close($curl);
        } catch (\Exception $e) {

        }
    }
}
