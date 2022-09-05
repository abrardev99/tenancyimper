<?php

use App\Models\Tenant;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/imper', function (){
    $tenant = Tenant::first();
    $domain = $tenant->domains->first()->domain;
    $domain = $domain . '.' . config('tenancy.central_domains')[0];

    $token = tenancy()->impersonate($tenant, 1, 'http://foo.' . config('tenancy.central_domains')[0], 'web')->token;

    return redirect("http://$domain/impersonate/{$token}");
})->name('imper');

require __DIR__.'/auth.php';
