<?php

use App\Http\Controllers\API\V1\Auth\ForgotPasswordController;
use App\Http\Controllers\API\V1\Auth\LogoutController;
use App\Http\Controllers\API\V1\Auth\RegisterController;
use App\Http\Controllers\API\V1\Auth\ResetPasswordController;
use App\Http\Controllers\API\V1\Auth\VerificationController;
use App\Http\Controllers\API\V1\CandidateController;
use App\Http\Controllers\API\V1\EducationInstitutionController;
use App\Http\Controllers\API\V1\PositionController;
use App\Http\Controllers\API\V1\SkillController;
use App\Http\Controllers\API\V1\UserController;
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

Route::prefix('v1')->group(function () {
    /*
     * Auth
     */
    Route::post('logout', [LogoutController::class, 'logout']);

    Route::post('register', [RegisterController::class, 'register']);

    Route::get('verify-email/{id}/{hash}', [VerificationController::class, 'verify'])
    ->name('verification.verify');

    Route::post('verify-email/resend', [VerificationController::class, 'resend'])
    ->name('verification.resend');

    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

    Route::post('reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.reset');

    /*
     * User
     */
    Route::get('user', [UserController::class, 'show']);

    Route::patch('user', [UserController::class, 'update']);

    Route::delete('user', [UserController::class, 'destroy']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::apiResource('/candidates', CandidateController::class)->except(['create']);
    });

    Route::apiResource('/candidates', CandidateController::class)->only(['create']);
    Route::apiResource('/institutions', EducationInstitutionController::class);
    Route::apiResource('/positions', PositionController::class);
    Route::apiResource('/skills', SkillController::class);
});
