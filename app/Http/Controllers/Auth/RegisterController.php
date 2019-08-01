<?php

namespace tniv\Http\Controllers\Auth;

use tniv\User;
use tniv\SucursalesUsuario;
use Carbon\Carbon;
use tniv\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \tniv\User
     */
    protected function create(array $data)
    {

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'rol' => 'ClienteNuevo',
            'estatus' => 'ClienteNuevo',
        ]);

        SucursalesUsuario::insert([
            'created_at' => Carbon::now()->subDays(1)->toDateTimeString(),
            'updated_at' => Carbon::now()->subDays(1)->toDateTimeString(),
            'estatus' => 1,
            'usuario_id' => $user->id,
            'sucursal_id' => $data['sucursal']
        ]);

        return $user;
    }

    protected function redirectTo()
    {
        if (auth()->user()->role == 1) {
            return '/';
        }
        return '/';
    }
}
