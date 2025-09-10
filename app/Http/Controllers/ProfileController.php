<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return view('profile.show', ['user' => $request->user()]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
        ]);

        $user = $request->user();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->save();

        return back()->with('success', 'تم تحديث الملف الشخصي');
    }

    public function showPassword(Request $request)
    {
        return view('profile.password');
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = $request->user();
        if (!Hash::check($data['current_password'], $user->getAuthPassword())) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
        }

        $user->password = Hash::make($data['password']);
        $user->save();

        return back()->with('success', 'تم تغيير كلمة المرور');
    }
}
