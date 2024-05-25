<?php

#Редиректы

$routes = [
    '/t-shirts-alteration/' => '/t-shirts-alter/',
    '/coats-alteration/' => '/alter-coats',
    '/blouses-alteration/' => '/alter-blouses/',
    '/embroidery-jeans-jackets/' => '/embroidery-jeans-jeckets/',
    '/tailoring-repair-outerwear/' => '/tailoring-outerwear/',
    '/embroidery-sample-emblem-monogram/' => '/',
    '/embroidery-samples-cross-lace-cutwork-embroidery/' => '/',
    '/embroidery-samples-expanse/' => '/',
    '/embroidery-samples-font/' => '/',
    '/embroidery-samples/' => '/',
    '/samples-3D-embroidery/' => '/',
    '/samples-chevron-applique/' => '/',
    '/samples-realistic-embroidery/' => '/',
];

foreach ($routes as $from => $to) {
    Route::get($from, function() use ($to){
        return Redirect::to($to, 301);
    });
}