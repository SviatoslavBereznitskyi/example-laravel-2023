<?php

declare(strict_types=1);

use App\Http\Admin\Catalog\Address\MetroImportController;
use App\Http\Admin\Catalog\Address\StreetImportController;
use App\Http\Admin\Promo\GeneratePromoCodesController;
use App\Http\Admin\Raffle\RaffleFinishController;
use App\Http\Controllers\Api\V1\Auth\OAuth\SocialLoginController;
use App\Http\Controllers\CentrifugoProxyController;
use App\Models\Settings\Setting;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', static fn () => view('welcome'));

Route::get('policy', static fn () => response()->view('policy', ['policy' => Setting::where('key', Setting::POLICY)->first()->value]));
Route::post('admin/promocodes/generate', GeneratePromoCodesController::class)->middleware('auth')->name('admin.promocodes.generate');
