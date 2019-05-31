<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use WebPConvert\WebPConvert;

class ConvertImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert images to WEBP';

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
        $files = array_diff(scandir(public_path() . '/img/background'), ['.', '..']);
        $bar = $this->output->createProgressBar(count($files));
        $image = new \claviska\SimpleImage();

        foreach($files as $file) {
            list($fileName, $fileExt) = explode('.', $file);
            $source = public_path() . '/img/background/' . $file;

            // $destination = public_path() . '/img/webp/background/' . $fileName . '.webp';
            // WebPConvert::convert($source, $destination);


            $thumb = public_path() . '/img/background/' . $fileName . '_small.' . $fileExt;
            // $image
            //     ->fromFile($source)
            //     ->resize(800, null)
            //     ->toFile($thumb , 'image/jpeg', 90);

            $destination = public_path() . '/img/webp/background/' . $fileName . '_small.webp';
            WebPConvert::convert($thumb, $destination);

            $bar->advance();
        }
        $bar->finish();
    }
}
