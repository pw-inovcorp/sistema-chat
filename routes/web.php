<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

// Invite Routes simples
Route::get('/invite/{token}', [App\Http\Controllers\InviteController::class, 'show'])->name('invite.show');
Route::post('/invite/{token}', [App\Http\Controllers\InviteController::class, 'register'])->name('invite.register');

Route::get('/dashboard', function () {
    return redirect()->route('chat.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
   Route::get('/admin/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
   Route::get('/admin/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.users.create');
   Route::post('/admin/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.users.store');
   Route::get('/admin/users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
   Route::patch('/admin/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
   Route::delete('/admin/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/rooms/{room}', [ChatController::class, 'showRoom'])->name('chat.room');
    Route::get('/chat/users/{user}', [ChatController::class, 'showDirectMessages'])->name('chat.direct');
    Route::post('/chat/rooms/{room}/messages', [ChatController::class, 'sendRoomMessage'])->name('chat.room.send');
    Route::post('/chat/users/{user}/messages', [ChatController::class, 'sendDirectMessage'])->name('chat.direct.send');

    Route::get('/rooms', [App\Http\Controllers\RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/create', [App\Http\Controllers\RoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms', [App\Http\Controllers\RoomController::class, 'store'])->name('rooms.store');
    Route::post('/rooms/{room}/join', [App\Http\Controllers\RoomController::class, 'join'])->name('rooms.join');
    Route::delete('/rooms/{room}/leave', [App\Http\Controllers\RoomController::class, 'leave'])->name('rooms.leave');
    Route::get('/rooms/{room}/edit', [App\Http\Controllers\RoomController::class, 'edit'])->name('rooms.edit');
    Route::patch('/rooms/{room}', [App\Http\Controllers\RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [App\Http\Controllers\RoomController::class, 'destroy'])->name('rooms.destroy');
});

require __DIR__.'/auth.php';
