<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\SpecialiteController;
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
Route::get('etudiants/etudiants-of-classroom/{idClass}', [EtudiantController::class, 'showEtudiantsByClass'])->name('etudiants.showEtudiantsByClass');
Route::get('etudiants/{idEtudiant}', [EtudiantController::class, 'show'])->name('etudiants.show');
Route::post('etudiants/{idEtudiant}', [EtudiantController::class, 'update'])->name('etudiants.update');
Route::delete('etudiants/{idEtudiant}', [EtudiantController::class, 'destroy'])->name('etudiants.destroy');

//route for matiere
Route::post('matieres/{idModule}', [MatiereController::class, 'store'])->name('matieres.store');
Route::get('matieres', [MatiereController::class, 'index'])->name('matieres.index');
Route::get('matieres/evaluations-of-matiere/{idMatiere}', [MatiereController::class, 'showMatiereEvalutions'])->name('matieres.showMatiereEvalutions');

Route::get('matieres/{idMatiere}', [MatiereController::class, 'show'])->name('matieres.show');
Route::get('matieres/notes-of-matiere/{idMatiere}', [MatiereController::class, 'showNotesOfMatiere'])->name('matieres.showNotesOfMatiere');
Route::post('matieres-modifier/{id}', [MatiereController::class, 'update'])->name('matieres.update');
Route::delete('matieres/{id}', [MatiereController::class, 'destroy'])->name('matieres.destroy');
Route::get('matieres/notes-of-matiere-of-classroom/{idMatiere}', [MatiereController::class, 'showNotesOfMatiereOfClassroom'])->name('matieres.showNotesOfMatiereOfClassroom');


//route for note
Route::post('notes/noted/{idMatiere}/{idEtudiant}', [NoteController::class, 'noted'])->name('notes.noted');
Route::get('notes', [NoteController::class, 'index'])->name('notes.index');
Route::get('notes/generate-note-file/{idEtudiant}', [NoteController::class, 'generateEtudiantNotesFile'])->name('notes.generateEtudiantNotesFile');
Route::put('notes/{idNote}', [NoteController::class, 'modifyNote'])->name('notes.modifyNote');
Route::delete('notes/{idNote}', [NoteController::class, 'destroy'])->name('notes.destroy');

//route to display image
Route::get('images/{filename}', [MatiereController::class, 'getImage'])->name('matieres.getImage');

//route for module
Route::post('modules/{idSpecialite}', [ModuleController::class, 'store'])->name('modules.store');
Route::get('modules', [ModuleController::class, 'index'])->name('modules.index');
Route::get('modules/{idModule}', [ModuleController::class, 'show'])->name('modules.show');
Route::get('modules/matieres-of-module/{idModule}', [ModuleController::class, 'showMatieresOfModule'])->name('modules.showMatieresOfModule');
Route::put('modules/{idModule}', [ModuleController::class, 'update'])->name('modules.update');
Route::delete('modules/{idModule}', [ModuleController::class, 'destroy'])->name('modules.destroy');

//route for specialite
Route::get('specialites/generatePlanDEtude-of-specialite/{idDegre}', [SpecialiteController::class, 'generatePlanDEtude'])->name('specialites.generatePlanDEtude');
Route::post('specialites', [SpecialiteController::class, 'store'])->name('specialites.store');
Route::get('specialites', [SpecialiteController::class, 'index'])->name('specialites.index');
Route::get('specialites/showSpecialitiesGroupByNiveau', [SpecialiteController::class, 'showSpecialitiesGroupByNiveau'])->name('specialites.showSpecialitiesGroupByNiveau');
Route::get('specialites/{idSpecialite}', [SpecialiteController::class, 'show'])->name('specialites.show');
Route::get('specialites/modules-of-specialite/{idSpecialite}', [SpecialiteController::class, 'showModulesOfSpecialite'])->name('specialites.showModulesOfSpecialite');
Route::put('specialites/{idSpecialite}', [SpecialiteController::class, 'update'])->name('specialites.update');
Route::delete('specialites/{idSpecialite}', [SpecialiteController::class, 'destroy'])->name('specialites.destroy');



//route for classroom
Route::post('classrooms/{idDepartment}', [ClassroomController::class, 'store'])->name('classrooms.store');
Route::get('classrooms', [ClassroomController::class, 'index'])->name('classrooms.index');
Route::post('class/affect-matiere', [ClassroomController::class, 'affectMatiereToClass'])->name('classrooms.affectMatiereToClass');
Route::get('classrooms/{idClassroom}', [ClassroomController::class, 'show'])->name('classrooms.show');
Route::put('classrooms/{idClassroom}', [ClassroomController::class, 'update'])->name('classrooms.update');
Route::delete('classrooms/{idClassroom}', [ClassroomController::class, 'destroy'])->name('classrooms.destroy');
Route::get('classrooms/{idClassroom}/matieres', [ClassroomController::class, 'showMatieresOfClassroom'])->name('classrooms.showMatieresOfClassroom');

//route for department
Route::post('departments', [DepartmentController::class, 'store'])->name('departments.store');
Route::get('departments', [DepartmentController::class, 'index'])->name('departments.index');
Route::get('departments/{idDepartment}', [DepartmentController::class, 'show'])->name('departments.show');
Route::get('departments/classrooms-of-department/{idDepartment}', [DepartmentController::class, 'showClassroomsOfDepartment'])->name('departments.showClassroomsOfDepartment');
Route::put('departments/{idDepartment}', [DepartmentController::class, 'update'])->name('departments.update');
Route::delete('departments/{idDepartment}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
