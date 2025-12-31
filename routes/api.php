<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SsMilestoneController;
use App\Http\Controllers\SsSiteController;
use App\Http\Controllers\SsStudyController;
use App\Http\Controllers\SsStudyMilestoneCategoryTaskController;
use App\Http\Controllers\SsStudyMilestoneController;
use App\Http\Controllers\SsStudyStaffController;

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

Route::middleware('auth:sanctum')->group(function () {
    // Route::get('/me', fn () => auth()->user());
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('ss-sites', SsSiteController::class);
    Route::apiResource('ss-studies', SsStudyController::class);
    Route::apiResource('ss-study-staff', SsStudyStaffController::class);
    Route::get('/get-milestones-template', [SsMilestoneController::class, 'getMilestonesTemplate']);
    Route::prefix('studies/{studyId}')->group(function () {
        Route::apiResource('milestones', SsStudyMilestoneController::class);
        Route::post('assign-tasks', [SsStudyMilestoneCategoryTaskController::class, 'assignTasks']);
    });
});
