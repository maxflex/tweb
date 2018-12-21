<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Sitemap;
use App\Models\Page;

class SitemapController extends Controller
{
    public function index()
    {
      return Sitemap::render();
    }

    private static function _url($url = '')
    {
       return config('app.url') . ($url[0] == '/' ? substr($url, 1) : $url);
    }
}

