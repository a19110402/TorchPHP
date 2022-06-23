<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function index(){

        return view('admin/index');
    }

    public function watchUsers(){
        $users = User::all();

        return view('admin/users', ['users' => $users]);
    }
}
