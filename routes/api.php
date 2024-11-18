<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DataPlanController;
use App\Http\Controllers\Api\OperatorCardController;
use App\Http\Controllers\Api\PaymentMethodController;
use App\Http\Controllers\Api\TipController;
use App\Http\Controllers\Api\TopupController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\TransferController;
use App\Http\Controllers\Api\TransferHistoryController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\WebhookController;
use App\Models\Transaction;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('is-email-exist', [UserController::class, 'isEmailExist']);
Route::post('webhooks', [WebhookController::class, 'update']);

Route::group(
    ['middleware' => 'jwt.verify'],
    function ($router) {
        Route::post('logout', [AuthController::class, 'logout']);

        Route::get('users', [UserController::class, 'show']);
        Route::get('users/{username}', [UserController::class, 'getUserByUsername']);
        Route::put('users', [UserController::class, 'update']);


        Route::put('wallets', [WalletController::class, 'update']);
        Route::get('wallets', [WalletController::class, 'show']);

        Route::get('transfer_histories', [TransferHistoryController::class, 'index']);

        // 
        Route::post('top_ups', [TopUpController::class, 'store']);
        // 
        Route::post('transfers', [TransferController::class, 'store']);
        // 
        Route::post('data_plans', [DataPlanController::class, 'store']);

        Route::get('transactions', [TransactionController::class, 'index']);
        // 
        Route::get('payment_methods', [PaymentMethodController::class, 'index']);

        Route::get('tips', [TipController::class, 'index']);

        Route::get('operator_cards', [OperatorCardController::class, 'index']);
    }
);
