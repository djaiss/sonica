<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\ViewModels\User\UserViewModel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('user.index', [
            'data' => UserViewModel::index(),
        ]);
    }

    public function show(Request $request): View
    {
        $user = $request->attributes->get('user');

        return view('user.show', [
            'data' => UserViewModel::show($user),
        ]);
    }
}
