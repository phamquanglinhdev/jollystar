<?php

use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array)config('backpack.base.web_middleware', 'web'),
        (array)config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::middleware("super")->group(function () {
        Route::crud('staff', 'StaffCrudController');
        Route::crud('admin', 'AdminCrudController');
        Route::crud('post', 'PostCrudController');
    });
    Route::middleware("staff")->group(function () {
        Route::crud('user', 'UserCrudController');
        Route::crud('customer', 'CustomerCrudController');
        Route::crud('caring', 'CaringCrudController');
        Route::crud('teacher', 'TeacherCrudController');
        Route::crud('task', 'TaskCrudController');
        Route::get("/task", [TaskController::class, "index"]);
        Route::post("/task/sorted", [TaskController::class, "sorted"])->name("task.sorted");
        Route::post("/task/detail", [TaskController::class, "detail"])->name("task.detail");
        Route::post("/task/action", [TaskController::class, "action"])->name("task.action");
        Route::post("/task/answer", [TaskController::class, "comment"])->name("task.answer");
    });
    Route::crud('course', 'CourseCrudController');
    Route::crud('invoice', 'InvoiceCrudController');
    Route::crud('student', 'StudentCrudController');
    Route::crud('grade', 'GradeCrudController');
    Route::crud('log', 'LogCrudController');
    Route::crud('bag', 'BagCrudController');
    Route::get('bag/list', 'BagCrudController@list');
    Route::crud('book', 'BookCrudController');
    Route::crud('income', 'IncomeCrudController');
    Route::crud('teacher-salary', 'TeacherSalaryCrudController');
    Route::crud('payment', 'PaymentCrudController');
    Route::get('finance', 'FinanceCrudController@index');
    Route::prefix("message")->group(function () {
        Route::get("/", [MessageController::class, "index"])->name("message.index");
        Route::post("/", [MessageController::class, "send"])->name("message.send");
    });

    Route::crud('conversation', 'ConversationCrudController');
    Route::get("super/switch", [SuperAdminController::class, "switchBranch"])->name("super.switch");

    Route::crud('branch', 'BranchCrudController');
}); // this should be the absolute last line of this file