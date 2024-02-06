<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;
use League\CommonMark\CommonMarkConverter;


Route::middleware('guest')->group(function () {
    Route::resource('login', LoginController::class)->only(['create', 'store']);
    Route::get('/', function () {
        return Inertia::render('Welcome', [
        ]);
    })->name('welcome');

    
    Route::get('/projects/{project}', ProjectController::class . '@show')->name('projects.show');
    Route::post('/send-email', [ContactController::class, 'send'])->name('send-email');
});

Route::get('terms', function () {
    $content = File::get(resource_path('markdown/terms.md'));
    $converter = new CommonMarkConverter();
    $policyHtml = $converter->convertToHtml($content);
    return Inertia::render('TermsOfService', ['terms' => $policyHtml->getContent()]); 
})->name('terms.show');
Route::get('policy', function () {
    $content = File::get(resource_path('markdown/policy.md'));
    $converter = new CommonMarkConverter();
    $policyHtml = $converter->convertToHtml($content);
    return Inertia::render('PrivacyPolicy', ['policy' => $policyHtml->getContent()]); 
})->name('policy.show');
Route::get('cookie', function () {
    $content = File::get(resource_path('markdown/cookie.md'));
    $converter = new CommonMarkConverter();
    $policyHtml = $converter->convertToHtml($content);
    return Inertia::render('CookiePolicy', ['cookie' => $policyHtml->getContent()]); 
})->name('cookie.show');
