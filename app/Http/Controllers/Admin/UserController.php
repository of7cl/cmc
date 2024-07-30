<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        //$this->middleware('can:administracion.users.index')->only('index');
        //$this->middleware('can:administracion.users.edit')->only('edit', 'update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      =>  'required',
            'email'     =>  'required|email|unique:users',
            'password'  =>  'required|confirmed|min:8',
            'password_confirmation' => 'required'
        ]);

        /* $user = User::create($request->all()); */
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        $user->roles()->sync($request->roles);
        return redirect()->route('admin.users.edit', $user)->with('info', 'Usuario agregado con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {    
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function change_pass(User $user)
    {
        $roles = Role::all();
        return view('admin.users.change_password', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {        
        if($request->change_pass == '1') //cambiar contraseña
        {
            $request->validate([
                'password'  =>  'required|confirmed|min:8',
                'password_confirmation' => 'required'
            ]);
            $user->update(['password' => Hash::make($request['password'])]);                                
            $message = 'Contraseña actualizada con éxito!';
        }
        else{
            $request->validate([
                'name'      =>  'required',
                'email'     =>  "required|email|unique:users,email,$user->id"
            ]);
            $user->update($request->all());
    
            /*return redirect()->route('admin.users.edit', $user)->with('info', 'Usuario actualizado con éxito!'); */
    
            $user->roles()->sync($request->roles);
            $message = 'Usuario actualizado con éxito!';
        }
        
        return redirect()->route('admin.users.edit', $user)->with('info', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
