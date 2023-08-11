<?php

use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\NoteController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/users', function (Request $request) {
    dd($request);
    return new JsonResponse([
        "data" => "test"
    ]);
});

//route for etudiant
Route::post('etudiants', [EtudiantController::class, 'store'])->name('etudiants.store');
Route::get('etudiants', [EtudiantController::class, 'index'])->name('etudiants.index');
Route::get('etudiants/{idEtudiant}', [EtudiantController::class, 'show'])->name('etudiants.show');
Route::put('etudiants/{idEtudiant}', [EtudiantController::class, 'update'])->name('etudiants.update');
Route::delete('etudiants/{idEtudiant}', [EtudiantController::class, 'destroy'])->name('etudiants.destroy');

//route for matiere
Route::post('matieres', [MatiereController::class, 'store'])->name('matieres.store');
Route::get('matieres', [MatiereController::class, 'index'])->name('matieres.index');
Route::get('matieres/{idMatiere}', [MatiereController::class, 'show'])->name('matieres.show');
Route::get('matieres/notes-of-matiere/{idMatiere}', [MatiereController::class, 'showNotesOfMatiere'])->name('matieres.showNotesOfMatiere');
Route::put('matieres/{id}', [MatiereController::class, 'update'])->name('matieres.update');
Route::delete('matieres/{id}', [MatiereController::class, 'destroy'])->name('matieres.destroy');
//route for note
Route::post('notes/noted/{idMatiere}/{idEtudiant}', [NoteController::class, 'noted'])->name('notes.noted');
Route::get('notes', [NoteController::class, 'index'])->name('notes.index');
Route::get('notes/generate-note-file/{idEtudiant}', [NoteController::class, 'generateEtudiantNotesFile'])->name('notes.generateEtudiantNotesFile');
Route::put('notes/{idNote}', [NoteController::class, 'modifyNote'])->name('notes.modifyNote');
Route::delete('notes/{idNote}', [NoteController::class, 'destroy'])->name('notes.destroy');


Route::get('images/{filename}', [MatiereController::class, 'getImage'])->name('matieres.getImage');
