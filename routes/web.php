<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CategoriesUrlConcurrentsController;
use App\Http\Controllers\ConcurrentsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoriquePrixProduitsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProduitsConcurrentsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServicesController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function(){
    Route::get('/', [DashboardController::class, 'index'],function(){ 
        return view('dashboard');
    })->name('dashboard.index');
    
    Route::get('/dashboard', [DashboardController::class, 'indexTest'])->name('dashboard.index');
    Route::get('/dashboard/produits/{produit}/', [DashboardController::class, 'changeProduit'])->name('dashboard.changeProduit');
    Route::get('/dashboard/categorie/{categorie}', [DashboardController::class, 'changeCategorie'])->name('dashboard.changeCategorie');

    // Route Utilitaire ( gestion du script relance sauvegarde )
    Route::get('/services', [ServicesController::class, 'index'])->name('services');
    Route::get('services/historique',[ServicesController::class, 'historique'])->name('service.historique');
    Route::get('/run-scraper', function() {
        Artisan::call('app:run-scraper');
        return response()->json(['message' => 'Scraping terminé avec succès']);
    })->name('run-scraper');
    Route::get('/sync-prix', function(){
        Artisan::call('app:check-and-update-historique-prix');
        return response()->json(['message' => 'Prix synchronisés.']);
    })->name('sync-prix');
});

Route::middleware('auth')->group(function(){
    // Route CRUD Produits, Categorie, Concurrents
    Route::get('/products/create', [ProductsController::class, 'create'])->name('products.create');
    Route::get('/products/{produit}/edit', [ProductsController::class, 'edit'])->name('products.edit');
    Route::patch('/products/{produit}', [ProductsController::class, 'update'])->name('products.update');
    Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
    Route::delete('/products/{produit}', [ProductsController::class, 'delete'])->name('products.delete');

    Route::get('/categories/create', [CategoriesController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');
    Route::get('/categories/{categorie}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');
    Route::patch('/categories/{categorie}', [CategoriesController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{categorie}', [CategoriesController::class, 'delete'])->name('categories.delete');

    Route::get('/concurrents/create', [ConcurrentsController::class, 'create'])->name('concurrents.create');
    Route::post('/concurrents', [ConcurrentsController::class, 'store'])->name('concurrents.store');
    Route::get('/concurrents/{concurrent}/edit', [ConcurrentsController::class, 'edit'])->name('concurrents.edit');
    Route::patch('/concurrents/{concurrent}', [ConcurrentsController::class, 'update'])->name('concurrents.update');
    Route::delete('/concurrents/{concurrent}', [ConcurrentsController::class, 'delete'])->name('concurrents.delete');

    Route::get('/categories-url-concurrents/create', [CategoriesUrlConcurrentsController::class, 'create'])->name('categories-url-concurrents.create');
    Route::post('/categories-url-concurrents', [CategoriesUrlConcurrentsController::class, 'store'])->name('categories-url-concurrents.store');
    Route::get('/categories-url-concurrents/{url}/edit', [CategoriesUrlConcurrentsController::class, 'edit'])->name('categories-url-concurrents.edit');
    Route::patch('/categories-url-concurrents/{url}', [CategoriesUrlConcurrentsController::class, 'update'])->name('categories-url-concurrents.update');
    Route::delete('/categories-url-concurrents/{url}', [CategoriesUrlConcurrentsController::class, 'delete'])->name('categories-url-concurrents.delete');

    Route::get('/produits-concurrents/create', [ProduitsConcurrentsController::class, 'create'])->name('produits-concurrents.create');
    Route::post('/produits-concurrents', [ProduitsConcurrentsController::class, 'store'])->name('produits-concurrents.store');
    Route::get('/produits-concurrents/{produitConcurrent}/edit', [ProduitsConcurrentsController::class, 'edit'])->name('produits-concurrents.edit');
    Route::patch('/produits-concurrents/{produitConcurrent}', [ProduitsConcurrentsController::class, 'update'])->name('produits-concurrents.update');
    Route::delete('/produits-concurrents/{produitConcurrent}', [ProduitsConcurrentsController::class, 'delete'])->name('produits-concurrents.delete');

    Route::get('/historiques-prix', [HistoriquePrixProduitsController::class, 'index'])->name('historiques.index');
    Route::get('/historiques-prix/save', [HistoriquePrixProduitsController::class, 'save']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
