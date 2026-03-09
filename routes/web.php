<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlockController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InventoryController;

Route::get('/', function () {
    return redirect()->route('login');
});
Route::resource('block', BlockController::class)->only(['index', 'show']);
Auth::routes();

// Routes Inventaires et Blocks protégées par authentification
Route::middleware('auth')->group(function () {
    Route::resource('block', BlockController::class)->except(['index', 'show']);

    Route::resource('inventories', InventoryController::class);
    Route::post('inventories/{inventory}/blocks', [InventoryController::class, 'addBlock'])->name('inventories.blocks.add');
    Route::delete('inventories/{inventory}', [InventoryController::class, 'delete'])
    ->name('inventories.delete');
    Route::patch('inventories/{inventory}/blocks/{block}', [InventoryController::class, 'updateBlock'])->name('inventories.blocks.update');
    Route::delete('inventories/{inventory}/blocks/{block}', [InventoryController::class, 'removeBlock'])->name('inventories.blocks.remove');
});

Route::get('/home', function () {
    return redirect()->route('block.index');
})->name('home');
