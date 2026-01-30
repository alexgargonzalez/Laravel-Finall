<?php

use App\Http\Controllers\FotoController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\VacacionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Route;

//logs
Route::get('logs',[\Rap2hpoutre\LaravelLogViewer\LogViewerController::class,'index']);

//main controller
Route::get('/', [MainController::class, 'main'])->name('main');
Route::get('about', [MainController::class, 'about'])->name('about');

//foto/imagen controller (if needed)
//Route::get('imagen/{id}', [ImagenController::class, 'imagen'])->name('imagen.imagen');

//Vacacion controller
Route::resource('vacacion', VacacionController::class);
Route::get('vacacion/tipo/{tipo}', [VacacionController::class, 'tipo'])->name('vacacion.tipo');

//User controller
Route::resource('user', UserController::class);

//Comentario controller
Route::post('comentario', [ComentarioController::class, 'store'])->name('comentario.store');
Route::get('comentario/{comentario}/edit', [ComentarioController::class, 'edit'])->name('comentario.edit');
Route::put('comentario/{comentario}', [ComentarioController::class, 'update'])->name('comentario.update');
Route::delete('comentario/{comentario}', [ComentarioController::class, 'destroy'])->name('comentario.destroy');

//Reserva controller
Route::resource('reserva', ReservaController::class)->only(['index', 'store', 'destroy']);

Auth::routes(['verify' => true]);

Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('home/edit', [App\Http\Controllers\HomeController::class, 'edit'])->name('home.edit');
Route::put('home', [App\Http\Controllers\HomeController::class, 'update'])->name('home.update');