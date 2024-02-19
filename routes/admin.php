<?php
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\GradeController;
use App\Http\Controllers\admin\StudentController;
use App\Http\Controllers\admin\SubjectController;

Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

Route::resource('student', StudentController::class);
Route::resource('subject', SubjectController::class);
Route::post('/assign-subject-to-student', [SubjectController::class, 'assignSubjectToStudent'])->name('assign.subject.to.student');
Route::get('/fetch-subjects', [SubjectController::class, 'fetch_subjects'])->name('fetch.subjects');
Route::get('/fetch-students', [StudentController::class, 'fetch_students'])->name('fetch.students');
Route::get('/fetch-students2', [StudentController::class, 'fetch_students2'])->name('fetch.students2');
Route::get('/fetch-subjects-for-student/{studentId}', [SubjectController::class, 'fetchSubjectsForStudent'])->name('fetch.subjects.for.student');
Route::post('/set-grade', 'GradeController@setGrade')->name('set.grade');
Route::get('/fetch-student-grades/{studentId}', [GradeController::class, 'fetchStudentGrades']);
Route::get('/fetch-student-Mark', [GradeController::class, 'fetchStudentMark'])->name('fetchMark');

Route::post('/assign-mark', [GradeController::class, 'assignMark'])->name('assign.mark');



