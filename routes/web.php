<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Message\ChannelController;
use App\Http\Controllers\Message\MessageController;
use App\Http\Controllers\Message\TopicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\Settings\SettingsLevelController;
use App\Http\Controllers\Settings\SettingsProfileController;
use App\Http\Controllers\Settings\SettingsRoleController;
use App\Http\Controllers\Team\TeamController;
use App\Http\Controllers\Team\TeamMemberController;
use App\Http\Controllers\Team\TeamToggleSettingsController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('locale/{locale}', [LocaleController::class, 'update'])->name('locale.update');

Route::get('dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // company
    Route::get('company', [UserController::class, 'index'])->name('company.index');

    // users
    Route::get('users', [UserController::class, 'index'])->name('user.index');
    Route::middleware(['user'])->group(function (): void {
        Route::get('users/{user}', [UserController::class, 'show'])->name('user.show');
    });

    // teams
    Route::get('teams', [TeamController::class, 'index'])->name('team.index');
    Route::get('teams/new', [TeamController::class, 'new'])->name('team.new');
    Route::post('teams', [TeamController::class, 'store'])->name('team.store');
    Route::middleware(['team'])->group(function (): void {
        // basic team management
        Route::get('teams/{team}', [TeamController::class, 'show'])->name('team.show');
        Route::put('teams/{team}/toggleSettings/{setting}', [TeamToggleSettingsController::class, 'update'])->name('team.toggle.update');
        Route::middleware(['part-of-team'])->group(function (): void {
            Route::get('teams/{team}/edit', [TeamController::class, 'edit'])->name('team.edit');
            Route::put('teams/{team}', [TeamController::class, 'update'])->name('team.update');
            Route::delete('teams/{team}', [TeamController::class, 'destroy'])->name('team.destroy');
        });

        // manage team members
        Route::middleware(['part-of-team'])->group(function (): void {
            Route::get('teams/{team}/members', [TeamMemberController::class, 'index'])->name('team.member.index');
            Route::get('teams/{team}/members/new', [TeamMemberController::class, 'new'])->name('team.member.new');
            Route::post('teams/{team}/members/{member}', [TeamMemberController::class, 'store'])->name('team.member.store');
            Route::delete('teams/{team}/members/{member}', [TeamMemberController::class, 'destroy'])->name('team.member.destroy');
        });
    });

    // messages
    Route::get('messages', [MessageController::class, 'index'])->name('message.index');
    Route::get('messages/unread', [MessageController::class, 'index'])->name('message.unread.index');
    Route::get('messages/favorites', [MessageController::class, 'index'])->name('message.favorites.index');
    Route::get('channels/new', [ChannelController::class, 'new'])->name('channel.new');
    Route::post('channels', [ChannelController::class, 'store'])->name('channel.store');
    Route::middleware(['channel'])->group(function (): void {
        Route::get('channels/{channel}', [ChannelController::class, 'show'])->name('channel.show');

        Route::middleware(['part-of-channel'])->group(function (): void {
            Route::get('channels/{channel}/edit', [ChannelController::class, 'edit'])->name('channel.edit');
            Route::get('channels/{channel}/edit/users', [ChannelUserController::class, 'edit'])->name('channel.user.edit');
            Route::put('channels/{channel}', [ChannelController::class, 'update'])->name('channel.update');
            Route::get('channels/{channel}/delete', [ChannelController::class, 'delete'])->name('channel.delete');
            Route::delete('channels/{channel}', [ChannelController::class, 'destroy'])->name('channel.destroy');

            Route::get('channels/{channel}/topics/new', [TopicController::class, 'new'])->name('topic.new');
            Route::post('channels/{channel}/topics', [TopicController::class, 'store'])->name('topic.store');
        });

        // topics
        Route::middleware(['topic'])->group(function (): void {
            Route::get('channels/{channel}/topics/{topic}', [TopicController::class, 'show'])->name('topic.show');
        });
    });

    // settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');

    Route::middleware(['administrator'])->group(function (): void {
        // profile
        Route::get('settings/profile', [SettingsProfileController::class, 'index'])->name('settings.profile.index');
        Route::put('settings/profile', [SettingsProfileController::class, 'update'])->name('settings.profile.update');

        // roles
        Route::get('settings/roles', [SettingsRoleController::class, 'index'])->name('settings.role.index');
        Route::get('settings/roles/new', [SettingsRoleController::class, 'new'])->name('settings.role.new');
        Route::post('settings/roles', [SettingsRoleController::class, 'store'])->name('settings.role.store');
        Route::get('settings/roles/{role}/edit', [SettingsRoleController::class, 'edit'])->name('settings.role.edit');
        Route::put('settings/roles/{role}', [SettingsRoleController::class, 'update'])->name('settings.role.update');
        Route::delete('settings/roles/{role}', [SettingsRoleController::class, 'destroy'])->name('settings.role.destroy');

        // levels
        Route::get('settings/levels', [SettingsLevelController::class, 'index'])->name('settings.level.index');
        Route::get('settings/levels/new', [SettingsLevelController::class, 'new'])->name('settings.level.new');
        Route::post('settings/levels', [SettingsLevelController::class, 'store'])->name('settings.level.store');
        Route::get('settings/levels/{level}/edit', [SettingsLevelController::class, 'edit'])->name('settings.level.edit');
        Route::put('settings/levels/{level}', [SettingsLevelController::class, 'update'])->name('settings.level.update');
        Route::delete('settings/levels/{level}', [SettingsLevelController::class, 'destroy'])->name('settings.level.destroy');
    });
});

require __DIR__ . '/auth.php';
