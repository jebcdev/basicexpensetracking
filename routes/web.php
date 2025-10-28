<?php




\Illuminate\Support\Facades\Route::get('/', function () {
    return redirect('/admin');
});



require __DIR__ . '/auth.php';
