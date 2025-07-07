<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\BorrowedItemController;
use App\Http\Controllers\IncomingItemController;
use App\Http\Controllers\OutgoingItemController;
use App\Http\Controllers\TableExportController;
use App\Http\Controllers\ProjectController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function (Request $request) {
    $user = Auth::user();
    if ($user->role === 'Admin') {
        return view('dashboard');
    } elseif ($user->role === 'Staff') {
        return app(\App\Http\Controllers\BorrowedItemController::class)->index();
    } elseif ($user->role === 'Technician') {
        return view('dashboard_technician');
    } else {
        abort(403, 'Unauthorized');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/borrow/create', [BorrowController::class, 'create'])->middleware(['auth', 'verified'])->name('borrow.create');
Route::post('/borrow/create', [BorrowController::class, 'store'])->middleware(['auth', 'verified'])->name('borrow.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/borrowed-items', [BorrowedItemController::class, 'index'])->name('borrowed_items.index');
    Route::get('/borrowed-items/{id}/edit', [BorrowedItemController::class, 'edit'])->name('borrowed_items.edit');
    Route::put('/borrowed-items/{id}', [BorrowedItemController::class, 'update'])->name('borrowed_items.update');
    Route::delete('/borrowed-items/{id}', [BorrowedItemController::class, 'destroy'])->name('borrowed_items.destroy');
    Route::post('/borrowed-items/{id}/send', [BorrowedItemController::class, 'sendToAdmin'])->name('borrowed_items.sendToAdmin');
    Route::get('/incoming-items', [IncomingItemController::class, 'index'])->name('incoming_items.index');
    Route::get('/incoming-items/create', [IncomingItemController::class, 'create'])->name('incoming_items.create');
    Route::post('/incoming-items', [IncomingItemController::class, 'store'])->name('incoming_items.store');
    Route::get('/incoming-items/{id}/edit', [IncomingItemController::class, 'edit'])->name('incoming_items.edit');
    Route::put('/incoming-items/{id}', [IncomingItemController::class, 'update'])->name('incoming_items.update');
    Route::delete('/incoming-items/{id}', [IncomingItemController::class, 'destroy'])->name('incoming_items.destroy');
    Route::post('/incoming-items/{id}/send', [App\Http\Controllers\IncomingItemController::class, 'sendToAdmin'])->middleware(['auth', 'verified'])->name('incoming_items.sendToAdmin');
    Route::get('/outgoing-items', [OutgoingItemController::class, 'index'])->name('outgoing_items.index');
    Route::get('/outgoing-items/create', [OutgoingItemController::class, 'create'])->name('outgoing_items.create');
    Route::post('/outgoing-items', [OutgoingItemController::class, 'store'])->name('outgoing_items.store');
    Route::get('/outgoing-items/{id}/edit', [OutgoingItemController::class, 'edit'])->name('outgoing_items.edit');
    Route::put('/outgoing-items/{id}', [OutgoingItemController::class, 'update'])->name('outgoing_items.update');
    Route::delete('/outgoing-items/{id}', [OutgoingItemController::class, 'destroy'])->name('outgoing_items.destroy');
    Route::post('/outgoing-items/{id}/send', [App\Http\Controllers\OutgoingItemController::class, 'sendToAdmin'])->middleware(['auth', 'verified'])->name('outgoing_items.sendToAdmin');
});

Route::get('/sent-tables', [App\Http\Controllers\BorrowedItemController::class, 'sentTables'])->middleware(['auth', 'verified'])->name('sent.tables');
Route::get('/all-tables', [App\Http\Controllers\BorrowedItemController::class, 'allTables'])->middleware(['auth', 'verified'])->name('all.tables');

Route::get('/notifications', function () {
    $notifications = Auth::user()->notifications;
    return view('notifications', compact('notifications'));
})->middleware(['auth', 'verified'])->name('notifications');

Route::post('/notifications/{id}/read', function ($id) {
    $notification = Auth::user()->notifications()->findOrFail($id);
    $notification->markAsRead();
    return redirect()->back();
})->middleware(['auth', 'verified'])->name('notifications.markAsRead');

Route::get('/export/borrowed/pdf', [TableExportController::class, 'exportBorrowedPdf'])->name('export.borrowed.pdf');
Route::get('/export/incoming/pdf', [TableExportController::class, 'exportIncomingPdf'])->name('export.incoming.pdf');
Route::get('/export/outgoing/pdf', [TableExportController::class, 'exportOutgoingPdf'])->name('export.outgoing.pdf');

Route::get('/progress-report', [ProjectController::class, 'index'])->middleware(['auth', 'verified'])->name('progress.report');
Route::post('/projects', [ProjectController::class, 'store'])->middleware(['auth', 'verified'])->name('projects.store');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->middleware(['auth', 'verified'])->name('projects.show');
Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->middleware(['auth', 'verified'])->name('projects.destroy');
Route::post('/site-items/{item}/update-quantity', [ProjectController::class, 'updateItemQuantity'])->middleware(['auth', 'verified'])->name('site-items.update-quantity');
Route::post('/project-sites/{site}/update-fiber-used', [\App\Http\Controllers\ProjectController::class, 'updateSiteFiberUsed'])->middleware(['auth', 'verified']);
Route::post('/projects/{project}/add-site', [App\Http\Controllers\ProjectController::class, 'addSite'])->middleware(['auth', 'verified'])->name('projects.addSite');
Route::post('/project-sites/{site}/add-item', [App\Http\Controllers\ProjectController::class, 'addItem'])->middleware(['auth', 'verified'])->name('project_sites.addItem');

require __DIR__.'/auth.php';
