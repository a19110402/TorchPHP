<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){

        return view('admin/index');

    }

    
    public function createNew(){
        return view('auth/register');
     }

     
    // public function createPerron(array $data)
    // {
    //     dd($data);
    // }
}
