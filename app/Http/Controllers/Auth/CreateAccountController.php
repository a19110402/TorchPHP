<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class CreateAccountController extends Controller
{
    use RegistersUsers;

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
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required'],
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
            'name' => $data['name'],
            'lastname' => null,
            'email' => null,
            'phone' => null,
            'password' => null,
            'role' => 'account',
            'type' => null,
            'status' => $data['status'],
            'createdBy' => auth()->user()->name,
            'corporation' => null,
        ]);
    }

    public function show(){
        return view('auth/cuenta');
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($account = $this->create($request->all())));
        return $this->registered($request, $account)
           // ?: redirect($this->redirectPath());
          ?: redirect()->route('home')->with('success', 'Registraste existosamente a ')->with('account', $account['name']);
    }

    public function watchAccount(){
        $users = User::all();

        return view('/accounts', ['users' => $users]);
    }

    public function editAccount($id){
        $user = User::find($id);

        return view('/editAccount', ['user' => $user]);
    }

    public function updateAccount(Request $request, $id){
        $user = User::find($id);
        $user->name = $request->name;
        $user->createdBy = $request->createdBy;
        $user->status = $request->status;

        $user->save();

        return redirect()->route('watch.account')->with('success', 'Cuenta actualizada');
    }

    public function deleteAccount($id){
        $user = User::find($id);
        $user->delete();

        return redirect()->route('watch.account')->with('success', 'Cuenta eliminada');

    }
}
