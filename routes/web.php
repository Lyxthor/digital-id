<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Citizen\Document\DocumentTokenController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dukcapil\CitizenController as DukcapilCitizenController;
use App\Http\Controllers\Dukcapil\DocumentController as DukcapilDocumentController;
use App\Http\Controllers\Citizen\DocumentController as CitizenDocumentController;
use App\Http\Controllers\Citizen\DocumentFolderController as CitizenFolderController;
use App\Http\Controllers\Dukcapil\UserController as DukcapilUserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Citizen\DocumentFolderController;
use App\Http\Controllers\Citizen\EventController;
use App\Http\Controllers\ClaimCitizenRequestController;
use App\Http\Controllers\Dukcapil\DocumentTypeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/invalid', function() {

})->name('invalid.index');

Route::get('/hashed_password/{password}', function($password) {
    return bcrypt($password);
});

// AUTH ROUTES
Route::group(['middleware'=>['guest']], function() {
    Route::get('login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.store');
    Route::get('register', [AuthController::class, 'registerPage'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register.store');
    Route::get('register/{token}', [ClaimCitizenRequestController::class, 'see'])->name('register.see');
    Route::post('register/{token}', [ClaimCitizenRequestController::class, 'show'])->name('register.show');
    Route::post('register/{token}/cancel', [ClaimCitizenRequestController::class, 'cancel'])->name('register.cancel');
    Route::post('register/{token}/resend', [ClaimCitizenRequestController::class, 'resend'])->name('register.resend');
});


Route::group(['middleware'=>['auth']], function() {
    // DUKCAPIL ROUTES
    Route::group(['middleware'=>['user.type:dukcapil']], function() {
        // citizen routes
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
        // user routes
        Route::post('dukcapil/citizen/users/{id}/accept', [DukcapilUserController::class, 'accept'])
        ->name('dukcapil.user.accept');
        Route::post('dukcapil/citizen/users/{id}/deny', [DukcapilUserController::class, 'deny'])
        ->name('dukcapil.user.deny');
        Route::delete('dukcapil/citizen/users/{id}', [DukcapilUserController::class, 'destroy'])
        ->name('dukcapil.user.destroy');
        // document type routes
        Route::get('dukcapil/document-types', [DocumentTypeController::class, 'index'])
        ->name('dukcapil.document_type.index');
        Route::post('dukcapil/document-types', [DocumentTypeController::class, 'store'])
        ->name('dukcapil.document_type.store');
        Route::put('dukcapil/document-types/{id}', [DocumentTypeController::class, 'update'])
        ->name('dukcapil.document_type.update');
        Route::delete('dukcapil/document-types/{id}', [DocumentTypeController::class, 'destroy'])
        ->name('dukcapil.document_type.destroy');

        // documents routes
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
        Route::post('dukcapil/documents/generate', [DukcapilDocumentController::class, 'generate'])
        ->name('dukcapil.document.generate');

        // DASHBOARD ROUTES
        Route::get('/dashboard/dukcapil', [DashboardController::class, 'dukcapilIndex'])
        ->name('dashboard.dukcapil');

    });
    Route::post('dukcapil/citizen/search', [DukcapilCitizenController::class, 'search'])
    ->name('dukcapil.citizen.search');


    // CITIZEN ROUTES
    Route::group(['middleware'=>['user.type:citizen']], function() {
        // token routes
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
        ->name('citizen.token.show')
        ->middleware('token.authorized_citizen');
        // document routes
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
        // event routes
        Route::get('citizen/event/confirmation/{id}', [EventController::class, 'confirmation'])
        ->name('citizen.event.confirmation');
        Route::post('citizen/event/submit/{id}', [EventController::class, 'submit'])
        ->name('citizen.event.submit');
        Route::get('citizen/event/share/{id}', [EventController::class, 'share'])
        ->name('citizen.event.share');
        Route::get('citizen/event/scan', [EventController::class, 'scan'])
        ->name('citizen.event.scan');
        Route::resource('citizen/events', EventController::class)
        ->parameters(["events"=>"id"])
        ->names([
            "index"=>"citizen.event.index",
            "create"=>"citizen.event.create",
            "edit"=>"citizen.event.edit",
            "show"=>"citizen.event.show",
            "store"=>"citizen.event.store",
            "update"=>"citizen.event.update",
            "destroy"=>"citizen.event.destroy"
        ]);
        // folder routes
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
        Route::get('citizen/folder/{id}/share', [DocumentFolderController::class, 'share'])
        ->name('citizen.folder.share');

        // DASHBOARD ROUTES
        Route::get('/dashboard/citizen', [DashboardController::class, 'citizenIndex'])
        ->name('dashboard.citizen');
    });





});
// OTHER ROUTES
Route::get('image/{filename}', [ImageController::class, 'show'])
->name('image.show');
Route::post('image', [ImageController::class, 'store'])
->name('image.store');
Route::post('logout', [AuthController::class, 'logout'])
->name('logout');



