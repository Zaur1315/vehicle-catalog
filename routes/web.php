<?php

declare(strict_types=1);

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\WarrantyReturnController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/inventory', InventoryController::class)->name('inventory.index');

Route::get('/inventory/{vehicle:slug}', [VehicleController::class, 'show'])
    ->name('vehicles.show');

Route::post('/inventory/{vehicle:slug}/inquiry', [VehicleController::class, 'inquiry'])
    ->name('vehicles.inquiry');

Route::get('/delivery', DeliveryController::class)->name('delivery');

Route::get('/warranty-return', WarrantyReturnController::class)->name('warranty-return');

Route::get('/about', AboutController::class)->name('about');

Route::get('/contact', [ContactController::class, 'index'])
    ->name('contact.index');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');
