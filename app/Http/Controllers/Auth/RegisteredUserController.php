<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ],
        [
            'name.required' => 'Vui lòng nhập tên của bạn.',
            'email.required' => 'Vui lòng nhập e-mail của bạn.',
            'email.unique' => 'E-mail này đã tồn tại.',
            'password.required' => 'Vui lòng nhập mật khẩu của bạn.',
            'password.confirmed' => 'Mật khẩu xác thực không chính xác.',
            'password.min' => 'Mật khẩu phải chứa ít nhất 8 ký tự.',
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'avatar' => 'user.png',
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        
        Auth::login($user);
        return response()->noContent();
    }
}
