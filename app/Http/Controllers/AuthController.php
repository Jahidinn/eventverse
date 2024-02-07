<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class AuthController extends Controller
{

	public function login()
	{
		return view('form.login');
	}

	public function register()
	{
		return view('form.register');
	}

	public function storeRegister(Request $request)
	{
		//dd($request->confirmPassword);

		$validatedData = $request->validate([
			'username' => ['required', 'max:255', 'unique:users'],
			'email' => 'required|email:dns|unique:users',
			'password' => 'required|min:6|max:255',
			'confirmPassword' => 'required|min:6|same:password'
		]);
		$validatedData['password'] = Hash::make($validatedData['password']);

		$data = [
			'name' => $request->username,
			'username' => $request->username,
			'email' => $request->email,
			'password' => $validatedData['password'],
		];

		// Insert Data
		$user = User::create($data);

		event(new Registered($user));

		session()->flash('success', 'Registrasi berhasil! Login dan verifikasi email!');
		return redirect('/login');
	}

	public function autenticate(Request $request)
	{
		$credentials = $request->validate([
			'email' => 'required|email',
			'password' => 'required'
		]);

		if (Auth::attempt($credentials)) {
			$request->session()->regenerate();

			if (auth()->user()->category_id == 2) {
				return redirect()->intended('/dashboard/admin');
			} else {
				return redirect()->intended('/dashboard/myevent');
			}
		}

		return back()->withInput()->with('loginError', 'Login failed! Check email or password');
	}

	public function emailVerify(EmailVerificationRequest $request)
	{
		$request->fulfill();
		return redirect('/dashboard')->with('popup', 'Email berhasil diverifikasi!');
	}

	public function resendEmail(Request $request)
	{
		$request->user()->sendEmailVerificationNotification();
		return back()->with('popup', 'Link verifikasi berhasil dikirim ulang!');
	}

	public function logout(Request $request)
	{
		Auth::logout();

		$request->session()->invalidate();
		$request->session()->regenerateToken();

		return redirect('/login')->with('logoutSuccess', 'Berhasil logout!');
	}

	public function forgotPasswordView()
	{
		return view('form.forgot-password');
	}

	public function forgotPassword(Request $request)
	{
		$request->validate(['email' => 'required|email']);

		$status = Password::sendResetLink(
			$request->only('email')
		);

		return $status === Password::RESET_LINK_SENT
			? back()->with(['status' => 'Cek email ya, link reset password sudah dikirim!'])
			: back()->withErrors(['email' => __($status)]);
	}

	public function resetPasswordView(string $token, Request $request)
	{
		return view('form.reset-password', ['token' => $token, 'email' => $request->email]);
	}

	public function resetPassword(Request $request)
	{
		$request->validate([
			'token' => 'required',
			'email' => 'required|email',
			'password' => 'required|min:6',
			'confirmPassword' => 'required|min:6|same:password',
		]);


		$status = Password::reset(
			$request->only('email', 'password', 'token'),
			function (User $user, string $password) {
				$user->forceFill([
					'password' => Hash::make($password)
				])->setRememberToken(Str::random(60));

				$user->save();

				event(new PasswordReset($user));
			}
		);

		return $status === Password::PASSWORD_RESET
			? redirect()->route('login')->with('status', 'Reset password sukses, silahkan login!')
			: back()->withErrors(['email' => [__($status)]]);
	}
}
