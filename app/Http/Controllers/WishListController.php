<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class WishListController extends Controller
{

    public function index() {
        // no need to show the authenticated users wishlist here
        $users = User::all()->except(auth()->id());
        return view('wishlist.all',compact('users'));
    }

    public function show(User $user) {
        return view('wishlist.show',compact('user'));
    }
}
