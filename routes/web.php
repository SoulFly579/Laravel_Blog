<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\Homepage;
use App\Http\Controllers\Back\Dashboard;
use App\Http\Controllers\Back\AuthController;
use App\Http\Controllers\Back\ArticleController;
use App\Http\Controllers\Back\CategoryController;
use App\Http\Controllers\Back\PageController;

/*
|--------------------------------------------------------------------------
| Back Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware('isLogin')->group(function (){
    Route::get('/login',[AuthController::class,'login'])->name('login');
    Route::post('/login',[AuthController::class,'loginPost'])->name('login.post');
});

Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function (){
    Route::get('/panel',[Dashboard::class,'index'])->name('dashboard');
    // Makale Route
    Route::get('/makaleler/silinenler',[ArticleController::class, 'trashed'])->name('trashed.article');
    Route::resource('makaleler', ArticleController::class);
    Route::get('/switch',[ArticleController::class, 'switch'])->name('switch');
    Route::get('/delete/{id}',[ArticleController::class, 'delete'])->name('deletearticle');
    Route::get('/harddelete/{id}',[ArticleController::class, 'harddelete'])->name('harddelete');
    Route::get('/recovery/{id}',[ArticleController::class, 'recovery'])->name('recoveryarticle');
    // Kategori Route
    Route::get('/kategoriler',[CategoryController::class,'index'])->name('category.index');
    Route::get('/kategori/status',[CategoryController::class,'switch'])->name('category.switch');
    Route::get('/kategoriler/getdata',[CategoryController::class,'getdata'])->name('category.getdata');
    Route::post('/kategoriler/update',[CategoryController::class,'update'])->name('category.update');
    Route::post('/kategoriler/create',[CategoryController::class,'create'])->name('category.create');
    Route::post('/kategoriler/delete',[CategoryController::class,'index'])->name('page.index');
    //Page Routes
    Route::get('/sayfalar',[PageController::class,'index'])->name('page.index');
    Route::get('/sayfa/switch',[PageController::class, 'switch'])->name('page.switch');
    Route::get('/sayfa/create',[PageController::class, 'create'])->name('page.create');
    Route::post('/sayfa/create',[PageController::class, 'post'])->name('page.post');
    Route::get('/sayfa/edit/{id}',[PageController::class, 'edit'])->name('page.edit');
    Route::get('/sayfa/delete/{id}',[PageController::class, 'delete'])->name('page.delete');
    Route::post('/sayfa/edit/{id}',[PageController::class, 'editPost'])->name('page.edit.post');
    //
    Route::get('/logout',[AuthController::class,'logout'])->name('logout');
});


/*
|--------------------------------------------------------------------------
| Front Routes
|--------------------------------------------------------------------------
*/

Route::get('/',[Homepage::class,'index'])->name('homepage');
Route::get('/kategori/{category}',[Homepage::class,'category'])->name('category');
Route::get('/iletisim',[Homepage::class,'contact'])->name('contact');
Route::post('/iletisim',[Homepage::class,'contact_post'])->name('contact_post');
Route::get('/{category}/{slug}',[Homepage::class,'single'])->name('single');
Route::get('/{sayfa}',[Homepage::class,'page'])->name('page');



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
