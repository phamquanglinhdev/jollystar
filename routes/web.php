<?php

use App\Http\Controllers\Admin\DownloadController;
use App\Http\Controllers\Admin\SocialLoginController;
use App\Http\Controllers\Client\CertificateController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\CourseController;
use App\Http\Controllers\Client\LibraryController;
use App\Http\Controllers\Client\TeacherController;
use App\Http\Controllers\Client\PostController;
use App\Models\Review;
use Illuminate\Support\Facades\Route;

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
    return redirect("/admin");
});
Route::get('/home', function () {
    return redirect("/admin");
});
Route::get("/facebook/login", [SocialLoginController::class, "facebookLogin"])->name("facebook-login");
Route::get("/facebook/callback", [SocialLoginController::class, "facebookCallback"])->name("facebook-callback");
Route::get("/google/login", [SocialLoginController::class, "googleLogin"])->name("google-login");
Route::get("/google/callback", [SocialLoginController::class, "googleCallback"])->name("google-callback");
Route::get("/github/login", [SocialLoginController::class, "githubLogin"])->name("github-login");
Route::get("/github/callback", [SocialLoginController::class, "githubCallback"])->name("github-callback");
Route::get("/test/download/{url}", [DownloadController::class, "download", "url"])->name("download");
Route::get('/', function () {
    return view('welcome', ['reviews' => Review::all()]);
});
Route::get("/danh-sach-khoa-hoc", [CourseController::class, "index"])->name("courses");
Route::get("/khoa-hoc/{slug?}", [CourseController::class, "show", "slug"])->name("course");
Route::any("/tat-ca-giao-vien", [TeacherController::class, "index"])->name("teachers");
Route::any("/thu-vien", [LibraryController::class, "index"])->name("library");
Route::any("/su-kien", [PostController::class, "index"])->name("posts");
Route::any("/bai-viet", [PostController::class, "show"])->name("post");
Route::any("/seed", [PostController::class, "seed"])->name("seed");
Route::post("/lien-he", [ContactController::class, "store"])->name("contact.save");
Route::get("/chung-chi", [CertificateController::class, "all"])->name("certificates");
