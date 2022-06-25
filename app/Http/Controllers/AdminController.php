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

    public function editUser($id){
        $user = User::find($id);

        return view('admin/edit', ['user' => $user]);
    } 

    public function updateUser(Request $request, $id){
        $user = User::find($id);
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->phone = $request->phone;
        $user->createdBy = $request->createdBy;
        $user->role = $request->role;

        $user->save();

        return redirect()->route('users')->with('success', 'Usuario actualizado');
    }

    public function deleteUser($id){
        $user = User::find($id);
        $user->delete();

        return redirect()->route('users')->with('success', 'Usuario eliminado');

    }
}
