<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Citizen\Document\DocumentTokenController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dukcapil\CitizenController as DukcapilCitizenController;
use App\Http\Controllers\Dukcapil\DocumentController as DukcapilDocumentController;
use App\Http\Controllers\Citizen\DocumentController as CitizenDocumentController;
use App\Http\Controllers\Citizen\DocumentFolderController as CitizenFolderController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Citizen\DocumentFolderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/invalid', function() {

})->name('invalid.index');

Route::get('/hashed_password/{password}', function($password) {
    return bcrypt($password);
});
Route::get('image/{filename}', [ImageController::class, 'show'])->name('image.show');
Route::post('image', [ImageController::class, 'store'])->name('image.store');
// AUTH ROUTES
Route::get('login', [AuthController::class, 'loginPage'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.store');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
// DUKCAPIL ROUTES
Route::resource('dukcapil/citizens', DukcapilCitizenController::class)
->parameters(["citizens"=>"id"])
->names([
    "index"=>"dukcapil.citizen.index",
    "create"=>"dukcapil.citizen.create",
    "edit"=>"dukcapil.citizen.edit",
    "show"=>"dukcapil.citizen.show",
    "store"=>"dukcapil.citizen.store",
    "update"=>"dukcapil.citizen.update",
    "destroy"=>"dukcapil.citizen.destroy"
]);
Route::resource('citizen/document/tokens', DocumentTokenController::class)
->parameters(["tokens"=>"id"])
->except(['show'])
->names([
    "index"=>"citizen.token.index",
    "create"=>"citizen.token.create",
    "edit"=>"citizen.token.edit",
    "store"=>"citizen.token.store",
    "update"=>"citizen.token.update",
    "destroy"=>"citizen.token.destroy"
]);
Route::get('citizen/document/tokens/{token}', [DocumentTokenController::class, 'show'])
->name('citizen.token.show')->middleware('token.authorized_citizen');
Route::post('dukcapil/citizen/search', [DukcapilCitizenController::class, 'search'])
->name('dukcapil.citizen.search');
Route::resource('dukcapil/documents', DukcapilDocumentController::class)
->parameters(["documents"=>"id"])
->names([
    "index"=>"dukcapil.document.index",
    "create"=>"dukcapil.document.create",
    "edit"=>"dukcapil.document.edit",
    "show"=>"dukcapil.document.show",
    "store"=>"dukcapil.document.store",
    "update"=>"dukcapil.document.update",
    "destroy"=>"dukcapil.document.destroy"
]);
Route::post('dukcapil/documents/generate', [DukcapilDocumentController::class, 'generate'])->name('dukcapil.document.generate');
Route::resource('citizen/documents', CitizenDocumentController::class)
->parameters(["documents"=>"id"])
->names([
    "index"=>"citizen.document.index",
    "create"=>"citizen.document.create",
    "edit"=>"citizen.document.edit",
    "show"=>"citizen.document.show",
    "store"=>"citizen.document.store",
    "update"=>"citizen.document.update",
    "destroy"=>"citizen.document.destroy"
]);
Route::resource('citizen/folders', DocumentFolderController::class)
->parameters(["folders"=>"id"])
->names([
    "index"=>"citizen.folder.index",
    "create"=>"citizen.folder.create",
    "edit"=>"citizen.folder.edit",
    "show"=>"citizen.folder.show",
    "store"=>"citizen.folder.store",
    "update"=>"citizen.folder.update",
    "destroy"=>"citizen.folder.destroy"
]);

// DASHBOARD ROUTES
Route::get('/dashboard/citizen', [DashboardController::class, 'citizenIndex'])->name('dashboard.citizen');
Route::get('/dashboard/dukcapil', [DashboardController::class, 'dukcapilIndex'])->name('dashboard.dukcapil');
