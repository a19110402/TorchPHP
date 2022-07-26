<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Controllers\Controller;

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

    protected function create(array $data)
    {
        return User::create([
            'corporation' => $data['corporation'],
        ]);
    }

    public function index(){
        return view('admin/corp');
    }

    public function upgrade(Request $request){
        
        $this->validator($request->all())->validate();

        $user = Auth::user($request);
        $user->corporation = $request->corporation;
        $user->type = 'corp';
        $user->save();

        return redirect()->route('home')->with('success', 'Ahora eres cuenta corporativa');

    }
}
