<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::match(['get', 'post'], '/student/results', [StudentController::class, 'showResults'])->name('student.showResults')->middleware('auth');



Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/eleves', [AdminController::class, 'viewEleves'])->name('admin.viewEleves');
    Route::get('/admin/matieres', [AdminController::class, 'viewMatieres'])->name('admin.viewMatieres');
    Route::get('/admin/notes', [AdminController::class, 'viewNotes'])->name('admin.viewNotes');
    Route::get('/admin/classes', [AdminController::class, 'viewClasses'])->name('admin.viewClasses');
    Route::post('/admin/add-classes', [AdminController::class, 'addClasses'])->name('admin.addClasses');
    Route::post('/admin/store-classes', [AdminController::class, 'storeClasses'])->name('admin.storeClasses');
    Route::get('/admin/manage-classes', [AdminController::class, 'manageClasses'])->name('admin.manageClasses');
    Route::post('/admin/class-details', [AdminController::class, 'classDetails'])->name('admin.classDetails');
    //Route::post('/admin/save-notes', [AdminController::class, 'saveNotes'])->name('admin.saveNotes');
    Route::post('/admin/save-student-details', [AdminController::class, 'saveStudentDetails'])->name('admin.saveStudentDetails');
    Route::post('/admin/add-student', [AdminController::class, 'addStudent'])->name('admin.addStudent');
    Route::get('/admin/view-matieres', [AdminController::class, 'viewMatieres'])->name('admin.viewMatieres');
    Route::post('/admin/add-matiere', [AdminController::class, 'addMatiere'])->name('admin.addMatiere');
    Route::get('/admin/view-classe/{classeId}', [AdminController::class, 'viewClasse'])->name('admin.viewClasse');
    Route::post('/admin/save-notes', [AdminController::class, 'saveNotes'])->name('admin.saveNotes');
    Route::get('/admin/manage-classes', [AdminController::class, 'manageClasses'])->name('admin.manageClasses');
    Route::get('/admin/view-class/{id}', [AdminController::class, 'viewClass'])->name('admin.viewClass');
    Route::post('/admin/add-notes', [AdminController::class, 'addNotes'])->name('admin.addNotes');
});