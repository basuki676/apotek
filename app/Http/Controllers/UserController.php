<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name', 'ASC')->simplePaginate(5);
        //memanggil html yang ada di folder resources/views/medicine/index.blade.php
        // manggil html yang ada di folder resource/views/medicines/index.blade.php
        return view('user.guru.index', compact('users')); 
    }
    public function create()
    {
        return view('user.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required',
            'role' => 'required',
        ]);

        $name = substr($request->name,0,3);
        $email = substr($request->email,0,3);
        $hashedPassword = Hash::make($name . $email);

        // simpan data ke db : 'name_column' => $request->name_input
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $hashedPassword
        ]);

        return redirect()->route('user.data')->with('success','done gk bang?donee!!!!!');
    }
    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user, 200);
    }
    public function edit($id)
    {
        $user = User::find($id);

        return view('user.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required',
            'role' => 'required',
            'password' => 'required',
        ]);

        //cari berdasarkan id, terus update
        User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password'=> $request->password,
        ]);

        return redirect()->route('user.data')->with('success', 'Berhasil mengubah data');
    }
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return redirect()->back()->with( 'deleted', 'lah kok ilang?' );
    }
    public function authLogin(Request $request){
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);
        $user = $request->only(['email', 'password']);
        if(Auth::attempt($user)){
            return redirect('/dashboard');
        } else{
            return redirect()->back()->with('failed', 'login gagal silahkan coba lagi');
        }
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
    
}
