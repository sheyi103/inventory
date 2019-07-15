<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('pages.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = null;
        return view('pages.user.create',compact('user'));
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
            'name'      => 'required|string',
            'email'     => 'required|string|email|unique:users',
            'password'   => 'required|string|min:6',
            'image'     => 'mimes:jpeg,png,jpg',
        ]);

        if(!empty($request->file('image')))
        {
            $file = $request->file('image') ;
            $image = time() . '.' . $file->getClientOriginalExtension() ;
            $destinationPath = public_path().'/images/users/' ;
            $file->move($destinationPath,$image);
        }
        else {
            $image = 'avatar.jpg';
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $image
        ]);

        return redirect()
                    ->route('user.index')
                    ->with('success', 'Successfully Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('pages.user.edit', compact('user'));
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
            'name'      => 'required|string',
            'email'     => 'required|string|email|unique:users,email,'.$id,
            'image'     => 'mimes:jpeg,png,jpg',
        ]);

        $user = User::find($id);

        if(!empty($request->file('image')))
        {
            $file = $request->file('image') ;
            $image = time() . '.' . $file->getClientOriginalExtension() ;
            $destinationPath = public_path().'/images/users/' ;
            $file->move($destinationPath,$image);
            $user->image = $image;
            $user->save();
        }


        $user->update([
            'name'      => $request->name,
            'email'   => $request->email,
        ]);

        return redirect()
                    ->route('user.index')
                    ->with('success', 'Successfully Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()
                    ->route('user.index')
                    ->with('warning', 'User Has Been Deleted');
    }
}
