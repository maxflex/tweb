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
        foreach($files as $file) {
            $source = public_path() . '/img/background/' . $file;
            $destination = public_path() . '/img/webp/background/' . explode('.', $file)[0] . '.webp';
            WebPConvert::convert($source, $destination);
            $bar->advance();
        }
        $bar->finish();
    }
}
