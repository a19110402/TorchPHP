<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Auth\Events\Registered;



class UpgradeController extends Controller
{
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'corporation' => ['required', 'string', 'max:255'],
        ]);
    }

      /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'corporation' => $data['corporation'],
        ]);
    }

    public function index(){

        return view('admin/corp');
    }

    public function edit($id){
        $user = User::find($id);

        return view('admin/corp', ['user' => $user]);
    }

    public function upgrade(Request $request, $id){
        
        $this->validator($request->all())->validate();

        $user = User::find($id);
        $user->corporation = $request->corporation;

        $user->save();

        return redirect()->route('home')->with('success', 'Ahora eres cuenta corporativa');

        // return redirect()->to('/home')->with('success', 'Ahora eres cuenta corporativa');

    }

    // public function updateUser(Request $request, $id){
    //     $user = User::find($id);
    //     $user->name = $request->name;
    //     $user->lastname = $request->lastname;
    //     $user->phone = $request->phone;
    //     $user->createdBy = $request->createdBy;
    //     $user->role = $request->role;

    //     $user->save();

    //     return redirect()->route('users')->with('success', 'Usuario actualizado');
    // }
}
