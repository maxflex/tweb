<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FindAllLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'find:links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $orders = \DB::table('request_log')->where('id', '>=', 1885)->get();
        $result = [['дата', 'имя', 'телефон', 'комментарий', 'фото']];
        foreach($orders as $order) {
            $data = json_decode($order->data);
            if (isset($data->phone)) {
                // dump($data);
                $result[] = [
                    $order->created_at,
                    @$data->name,
                    \App\Service\Phone::format('7' . $data->phone),
                    @$data->comment,
                    implode("\n", array_map(function ($url) {
                        return config('app.url') . 'request-photos/' . $url;
                    }, $data->photos))
                ];
            } else {
                // dump($order);
                $order->data = $order->data . '"}';
                $data = json_decode($order->data);
                dump($order);
            }
        }
        // $fp = fopen('orders.csv', 'w');
        // foreach ($result as $fields) {
        //     fputcsv($fp, $fields);
        // }
        // fclose($fp);
    }
}
