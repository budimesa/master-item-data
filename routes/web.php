<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ColorTolController;
use App\Http\Controllers\DensityController;
use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\SeriesTypeController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\SizeTolController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\WFGController;
use App\Http\Controllers\SFGController;
use App\Http\Controllers\FGController;
use App\Http\Controllers\InventoryTypeController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('brands', BrandController::class);
Route::resource('colors', ColorController::class);
Route::resource('color-tols', ColorTolController::class);
Route::resource('densities', DensityController::class);
Route::resource('item-types', ItemTypeController::class);
Route::resource('series-types', SeriesTypeController::class);
Route::get('/series-types-by-inventory-type', [SeriesTypeController::class, 'getSeriesTypesByInventoryType'])->name('series-types-by-inventory-type');
Route::resource('sizes', SizeController::class);
Route::resource('size-tols', SizeTolController::class);
Route::resource('inventory-types', InventoryTypeController::class);
Route::resource('raw-materials', RawMaterialController::class);
Route::resource('wfgs', WFGController::class);
Route::resource('sfgs', SFGController::class);
Route::resource('fgs', FGController::class);


Route::get('/master/general-data', function () {
    return Inertia::render('GeneralData');
})->name('general-data');

Route::get('/master/raw-material', function () {
    return Inertia::render('RawMaterial');
})->name('raw-material');

Route::get('/master/wfg', function () {
    return Inertia::render('WFG');
})->name('wfg');

Route::get('/master/sfg', function () {
    return Inertia::render('SFG');
})->name('sfg');

Route::get('/master/fg', function () {
    return Inertia::render('FG');
})->name('fg');

Route::get('/master/inventory-type', function () {
    return Inertia::render('InventoryType');
})->name('inventory-type');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
