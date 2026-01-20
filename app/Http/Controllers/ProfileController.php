<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Show profile
    public function showStudent() {
        return view('profile.studentprofile');
    }

    public function showTeacher() {
        return view('profile.teacherprofile');
    }

    // Update user info
    public function updateStudent(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.auth()->id(),
        ]);
        auth()->user()->update($request->only('name','email'));
        return back()->with('success','Profile updated.');
    }

    public function updateTeacher(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.auth()->id(),
        ]);
        auth()->user()->update($request->only('name','email'));
        return back()->with('success','Profile updated.');
    }

    // Update password
    public function updatePasswordStudent(Request $request) {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);
        if(!Hash::check($request->current_password, auth()->user()->password)){
            return back()->with('error','Current password does not match.');
        }
        auth()->user()->update(['password'=>Hash::make($request->new_password)]);
        return back()->with('success','Password updated.');
    }

    public function updatePasswordTeacher(Request $request) {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);
        if(!Hash::check($request->current_password, auth()->user()->password)){
            return back()->with('error','Current password does not match.');
        }
        auth()->user()->update(['password'=>Hash::make($request->new_password)]);
        return back()->with('success','Password updated.');
    }

    // Delete account
    public function destroyStudent() {
        auth()->user()->delete();
        return redirect('/')->with('success','Account deleted.');
    }

    public function destroyTeacher() {
        auth()->user()->delete();
        return redirect('/')->with('success','Account deleted.');
    }
}
