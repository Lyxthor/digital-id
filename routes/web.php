<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dukcapil\CitizenController as DukcapilCitizenController;
use App\Http\Controllers\Dukcapil\DocumentController as DukcapilDocumentController;
use App\Http\Controllers\ImageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/invalid', function() {

})->name('invalid.index');
Route::get('image/{filename}', [ImageController::class, 'show'])->name('image.show');
Route::post('image', [ImageController::class, 'store'])->name('image.store');
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
]);;
