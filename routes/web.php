<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/impersonate/{id}', function ($id) {
        if (!Auth::user()->hasRole('admin')) abort(403);

        $user = User::findOrFail($id);

        Auth::user()->impersonate($user);

        return redirect('/dashboard');
    })->name('impersonate');

    Route::get('/leave-impersonation', function () {
        Auth::user()->leaveImpersonation();

        return redirect('/dashboard');
    })->name('impersonate.leave');
});