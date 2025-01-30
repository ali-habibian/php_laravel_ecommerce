<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function index(User $user)
    {
        return view('home.user.profile.index', compact('user'));
    }
}
