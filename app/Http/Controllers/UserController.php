<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('admin.users', ['users' => User::all()]);
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
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => 'required',
        'role' => 'required|in:admin,employee,customer',
      ]);  
      
      $user = new User();
      $user->first_name = $request->first_name;
      $user->last_name = $request->last_name;
      $user->email = $request->email;
      $user->password = bcrypt($request->password);
      $user->role = $request->role;
      $user->active = isset($request->active)?$request->active:0;
      $user->save();

      return back()->with('status', 'El usuario "'.$user->full_name.'" fue registrado con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return User::findOrFail($id);
    }

    public function activate(Request $request, $id) {

      $user = User::findOrFail($id);
      $user->active = 1;
      $user->save();

      return back()->with('status', 'El usuario "'.$user->full_name.'" ha sido activado.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $request->validate([
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|email|unique:users,email,'.$id,
        'active' => 'in:0,1'
      ]);  

      $user = User::findOrFail($id);
      $user->first_name = $request->first_name;
      $user->last_name = $request->last_name;
      $user->email = $request->email;
      $user->active = isset($request->active)?$request->active:0;
      $user->save();
      return back()->with('status', 'Los datos del usuario "'.$user->full_name.'" se actualizaron con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('status', 'El cliente fue eliminado exitosamente.');
    }
}
