<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SsDepartmentController;
use App\Http\Controllers\SsMilestoneController;
use App\Http\Controllers\SsMilestoneCategoryController;
use App\Http\Controllers\SsMilestoneCategoryTaskController;
use App\Http\Controllers\SsoController;
use App\Http\Controllers\SsSiteController;
use App\Http\Controllers\SsStudyController;
use App\Http\Controllers\SsStudyMilestoneCategoryController;
use App\Http\Controllers\SsStudyMilestoneCategoryTaskController;
use App\Http\Controllers\SsStudyMilestoneController;
use App\Http\Controllers\SsStudyStaffController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
Route::get('/sso/callback', [SsoController::class, 'callback'])->middleware('web');
Route::get('/sso/verify', [SsoController::class, 'verify'])->middleware('web');
Route::get('/sso/authorization', [SsoController::class, 'authorization']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn () => auth()->user());

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('ss-sites', SsSiteController::class);
    Route::apiResource('ss-studies', SsStudyController::class);
    Route::apiResource('ss-study-staff', SsStudyStaffController::class);

    // Milestones Routes
    Route::apiResource('/milestones', SsMilestoneController::class);
    Route::apiResource('/milestone-categories', SsMilestoneCategoryController::class);
    Route::apiResource('/milestone-category-tasks', SsMilestoneCategoryTaskController::class);

    // Study Milestones Routes
    Route::apiResource('study/milestones', SsStudyMilestoneController::class);
    Route::apiResource('study/milestone-categories', SsStudyMilestoneCategoryController::class);
    Route::apiResource('study/milestone-category-tasks', SsStudyMilestoneCategoryTaskController::class);
    Route::post('assign-tasks', [SsStudyMilestoneCategoryTaskController::class, 'assignTasks']);

    Route::apiResource('departments', SsDepartmentController::class);

});
