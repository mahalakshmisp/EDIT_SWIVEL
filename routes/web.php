<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FreelancingController;
use App\Http\Controllers\VendorAuthController;
// Vendor Authentication Routes
// Route::get('/', function () {
//     return view('index');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\VideoController;
use App\Http\Controllers\CourseController;

Route::get('/videos/{subject}', [CourseController::class, 'showSubject'])->name('videos.subject');

// Route::get('/', function () {
//     return view('index');
// });
Route::get('/vendor/login', [VendorAuthController::class, 'showLoginForm'])->name('vendor.login');
Route::post('/vendor/login', [VendorAuthController::class, 'login'])->name('vendor.login.submit');
Route::get('/vendor/register', [VendorAuthController::class, 'showRegistrationForm'])->name('vendor.register');
Route::post('/vendor/register', [VendorAuthController::class, 'register'])->name('vendor.register.submit');
Route::post('/vendor/logout', [VendorAuthController::class, 'logout'])->name('vendor.logout');
Route::get('/', [FreelancingController::class, 'showmain']);
Route::get('/livecatagories', [FreelancingController::class, 'livecatagories']);
Route::get('/videocatagories', [FreelancingController::class, 'videocatagories']);
Route::get('/bronze', [FreelancingController::class, 'bronze']);
Route::get('/bronze_details', [FreelancingController::class, 'bronze_details']);
Route::get('/silver', [FreelancingController::class, 'silver']);
Route::get('/silver_details', [FreelancingController::class, 'silver_details']);
Route::get('/gold', [FreelancingController::class, 'gold']);
Route::get('/gold_details', [FreelancingController::class, 'gold_details']);
Route::get('/diamond', [FreelancingController::class, 'diamond']);
Route::get('/diamond_details', [FreelancingController::class, 'diamond_details']);
Route::get('/form', [FreelancingController::class, 'form']);
Route::post('/formdata', [FreelancingController::class, 'formdata'])->middleware('auth');
Route::get('/details', [FreelancingController::class, 'showRegistrations']);
Route::get('/categories/{category}', [CourseController::class, 'showCategory'])->name('categories.show');
Route::get('/courses/{course}', [CourseController::class, 'showCourse'])->name('courses.show');
Route::post('/courses/{course}/subscribe', [CourseController::class, 'subscribe'])->middleware('auth')->name('courses.subscribe');
Route::get('/purchase/{course}', [CourseController::class, 'purchasePage'])->name('courses.purchase');
Route::get('/authors/{course}', [CourseController::class, 'showAuthor'])->name('authors.show');
require __DIR__ . '/video_routes.php';


require __DIR__ . '/auth.php';
Route::get('/profile', function() {
    return view('profile.show');
})->middleware('auth')->name('profile.show');
Route::get('/stream-video/{id}', [VideoController::class, 'stream'])->name('video.stream');

// User Profile Route
Route::middleware('auth')->get('/user/purchases', [UserProfileController::class, 'purchases'])->name('user.purchases');
Route::middleware('auth')->get('/user/profile', [UserProfileController::class, 'profile'])->name('user.profile');
use App\Http\Controllers\VendorProfileController;
// Vendor Profile & Upload Routes
Route::middleware('auth:vendor')->group(function () {
    Route::get('/vendor/profile', [VendorProfileController::class, 'show'])->name('vendor.profile');
});
Route::middleware('auth:vendor')->get('/vendor/dashboard', function () {
    return view('vendor.dashboard');
})->name('vendor.dashboard');
Route::middleware('auth:vendor')->group(function () {
    Route::get('/courses/upload', [VideoController::class, 'create'])->name('courses.upload');
    Route::post('/courses/upload', [VideoController::class, 'store'])->name('courses.upload.store');
});
use App\Http\Controllers\VendorWalletController;
Route::middleware('auth:vendor')->get('/vendor/wallet', [VendorWalletController::class, 'show'])->name('vendor.wallet');
