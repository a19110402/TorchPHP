<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AdminController extends Controller
{
    public function index(){

        return view('admin/index');

    }

    
    public function createNew(){
        return view('auth/register');
     }

     
    public function createPerron(){ 
        $user = new User;
        $user->name = "anotherUser";
        $user->email = "admin2@prueba.com";
        $user->password = "1234";
        $user->save();    
    }
}
