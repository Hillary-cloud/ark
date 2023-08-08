<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdvertController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\Admin\LodgeController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\SchoolAreaController;
use App\Models\Bookmark;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('index');
// })->name('/');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [HomeController::class, 'index'])->name('/');
Route::get('/filter', [HomeController::class, 'filteredAd'])->name('filtered-advert');
Route::get('/detail/{uuid}', [HomeController::class, 'AdDetail'])->name('property-detail');

// protected routes
Route::middleware(['auth','verified'])->group(function () {
    // advert
    Route::get('post-ad', [AdvertController::class, 'index'])->name('postAd');
    Route::post('post-ad', [AdvertController::class, 'store'])->name('store-ad');
    Route::get('draft', [AdvertController::class, 'getDraft'])->name('draft');
    Route::get('edit-draft/{uuid}', [AdvertController::class, 'editDraft'])->name('edit-draft');
    Route::put('update-draft/{uuid}', [AdvertController::class, 'updateDraft'])->name('update-draft');
    Route::get('draft/{uuid}', [AdvertController::class, 'deleteDraft'])->name('delete-draft');
    Route::post('/save-ad', [AdvertController::class, 'saveAd'])->name('save-ad');
    // admin ads
    Route::get('over-view', [AdvertController::class, 'overView'])->name('over-view');
    Route::get('all-ads', [AdvertController::class, 'allAds'])->name('admin.all-ads');
    Route::get('ad-details/{uuid}', [AdvertController::class, 'viewAd'])->name('admin.view-ad');
    Route::get('delete-ad/{uuid}', [AdvertController::class, 'deleteAd'])->name('admin.delete-ad');
    // user ads
    Route::get('my-ads', [AdvertController::class, 'myAds'])->name('my-ads');
    Route::get('my-ad-details/{uuid}', [AdvertController::class, 'viewMyAd'])->name('view-my-ad');
    Route::get('delete-my-ad/{uuid}', [AdvertController::class, 'deleteMyAd'])->name('delete-my-ad');
    Route::get('relist/{uuid}', [AdvertController::class, 'Relist'])->name('relist');
    Route::put('update-relist-ad/{uuid}', [AdvertController::class, 'updateRelist'])->name('update-relist');


    Route::get('/payment/{uuid}', [PaymentController::class, 'showPaymentPage'])->name('payment-page');
    Route::post('/pay/{uuid}', [PaymentController::class, 'redirectToGateway'])->name('pay');
    Route::get('/payment/callback/{uuid}', [PaymentController::class, 'handleGatewayCallback'])->name('payment.callback');
    Route::get('/payment/success/{uuid}', function () {
        return view('success');
    })->name('success');
    Route::get('/transaction-history', [PaymentController::class, 'showTransactionHistoryPage'])->name('payment-history');

    // admin routes
    // location
    Route::get('admin/location', [LocationController::class, 'index'])->name('admin.location');
    Route::get('admin/add-location', [LocationController::class, 'add'])->name('admin.add-location');
    Route::post('admin/add-location', [LocationController::class, 'store'])->name('admin.store-location');
    Route::get('/admin/location/edit/{id}', [LocationController::class, 'edit'])->name('admin.edit-location');
    Route::put('/admin/location/edit/{id}', [LocationController::class, 'update'])->name('admin.update-location');
    Route::get('/admin/location/delete/{id}', [LocationController::class, 'delete'])->name('admin.delete-location');

    // school
    Route::get('admin/school', [SchoolController::class, 'index'])->name('admin.school');
    Route::get('admin/add-school', [SchoolController::class, 'add'])->name('admin.add-school');
    Route::post('admin/add-school', [SchoolController::class, 'store'])->name('admin.store-school');
    Route::get('/admin/school/edit/{id}', [SchoolController::class, 'edit'])->name('admin.edit-school');
    Route::put('/admin/school/edit/{id}', [SchoolController::class, 'update'])->name('admin.update-school');
    Route::get('/admin/school/delete/{id}', [SchoolController::class, 'delete'])->name('admin.delete-school');
    Route::get('/post-ad/schools/{location}', [SchoolController::class, 'getSchools']);

    // school area
    Route::get('admin/school-area', [SchoolAreaController::class, 'index'])->name('admin.school-area');
    Route::get('admin/add-school-area', [SchoolAreaController::class, 'add'])->name('admin.add-school-area');
    Route::post('admin/add-school-area', [SchoolAreaController::class, 'store'])->name('admin.store-school-area');
    Route::get('/admin/school-area/edit/{id}', [SchoolAreaController::class, 'edit'])->name('admin.edit-school-area');
    Route::put('/admin/school-area/edit/{id}', [SchoolAreaController::class, 'update'])->name('admin.update-school-area');
    Route::get('/admin/school-area/delete/{id}', [SchoolAreaController::class, 'delete'])->name('admin.delete-school-area');
    Route::get('/post-ad/school-areas/{school}', [SchoolAreaController::class, 'getSchoolAreas']);

    // lodge
    Route::get('admin/lodge', [LodgeController::class, 'index'])->name('admin.lodge');
    Route::get('admin/add-lodge', [LodgeController::class, 'add'])->name('admin.add-lodge');
    Route::post('admin/add-lodge', [LodgeController::class, 'store'])->name('admin.store-lodge');
    Route::get('/admin/lodge/edit/{id}', [LodgeController::class, 'edit'])->name('admin.edit-lodge');
    Route::put('/admin/lodge/edit/{id}', [LodgeController::class, 'update'])->name('admin.update-lodge');
    Route::get('/admin/lodge/delete/{id}', [LodgeController::class, 'delete'])->name('admin.delete-lodge');

    // bookmark
    Route::post('/bookmark/toggle', [BookmarkController::class, 'toggleBookmark'])
    ->name('bookmark.toggle');
    Route::get('/bookmark', [BookmarkController::class, 'bookmarkAds'])->name('bookmarks');
    Route::get('/bookmark/delete/{id}', [BookmarkController::class, 'deleteBookmark'])->name('delete-bookmark');

});
// email verification routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
 
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');
 
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


require __DIR__.'/auth.php';
