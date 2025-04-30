<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LandingPageController;
use App\Http\Controllers\Admin\LpSectionController;
use App\Http\Controllers\Admin\LpCardController;
use App\Models\LandingPage;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/admin/landing-pages');
    }
    return view('auth.login');
});

Auth::routes();

route::get('home', function () {
    return redirect('/admin/landing-pages');
});


// 公開されたランディングページを表示するルート
Route::get('/lp/{slug}', function ($slug) {
    $landingPage = LandingPage::where('slug', $slug)
        ->where('is_published', true)
        ->with(['sections' => function ($query) {
            $query->orderBy('order');
        }, 'sections.cards' => function ($query) {
            $query->orderBy('order');
        }])
        ->firstOrFail();

    return view('admin.landing-pages.preview', compact('landingPage'));
})->name('landing-pages.show');

// 管理画面のルート
Route::prefix('admin')->middleware(['auth'])->group(function () {
    // ランディングページ管理
    Route::resource('landing-pages', LandingPageController::class)->names([
        'index' => 'admin.landing-pages.index',
        'create' => 'admin.landing-pages.create',
        'store' => 'admin.landing-pages.store',
        'show' => 'admin.landing-pages.show',
        'edit' => 'admin.landing-pages.edit',
        'update' => 'admin.landing-pages.update',
        'destroy' => 'admin.landing-pages.destroy',
    ]);
    Route::get('landing-pages/{id}/preview', [LandingPageController::class, 'preview'])->name('admin.landing-pages.preview');
    Route::post('landing-pages/{id}/toggle-publish', [LandingPageController::class, 'togglePublish'])->name('admin.landing-pages.toggle-publish');

    // テストアップロードページ
    Route::get('test-upload', function() {
        return view('admin.landing-pages.sections.test-upload');
    });

    // セクション管理
    Route::resource('landing-pages.sections', LpSectionController::class)->shallow()->names([
        'index' => 'admin.landing-pages.sections.index',
        'create' => 'admin.landing-pages.sections.create',
        'store' => 'admin.landing-pages.sections.store',
        'show' => 'admin.sections.show',
        'edit' => 'admin.sections.edit',
        'update' => 'admin.sections.update',
        'destroy' => 'admin.sections.destroy',
    ]);
    Route::post('sections/reorder', [LpSectionController::class, 'reorder'])->name('admin.sections.reorder');

    // カード管理
    Route::resource('sections.cards', LpCardController::class)->shallow()->names([
        'index' => 'admin.sections.cards.index',
        'create' => 'admin.sections.cards.create',
        'store' => 'admin.sections.cards.store',
        'show' => 'admin.sections.cards.show',
        'edit' => 'admin.cards.edit',
        'update' => 'admin.cards.update',
        'destroy' => 'admin.cards.destroy',
    ]);
});
