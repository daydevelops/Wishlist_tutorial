<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class FriendController extends Controller
{	
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index() {
        $users = auth()->user()->friends;
        return view('wishlist.all',compact('users'));
    }

    public function store(Request $request, User $user) {
        $user->befriend();
    }

    public function destroy(Request $request, User $user) {
        $user->unfriend();
    }
}
