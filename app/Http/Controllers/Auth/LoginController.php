<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Notifications\AuthenticateUser;
use Illuminate\Http\Request;
use App\User;
use Hash;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->email;
        $password = $request->password;

        $auth = User::authenticate($email)->first();

        if(!empty($auth)){
            if ($auth->status) {
                if (Hash::check($password, $auth->password)) {
                    // $auth->update(['email_token' => bin2hex(openssl_random_pseudo_bytes(4))]);
                    // \Notification::send($auth, new AuthenticateUser($auth));
                    // return view('auth.verify');

                    Auth::login($auth);
                    return redirect('home');
                }
                else{
                    return redirect(route('login'))
                            ->withInput($request->only('email', 'remember'))
                            ->withErrors([
                                'password' => 'Invalid credentials, check your password',
                            ]);
                }
            }
            else{
                return redirect(route('login'))
                        ->withInput($request->only('email', 'remember'))
                        ->withErrors([
                            'password' => 'Your account is not active',
                        ]);
            }
        }
        else{
            return redirect(route('login'))
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors([
                        'password' => 'Invalid credentials, check your password',
                    ]);
        }
    }

    public function emailVerify()
    {
        $token = request('email_token');
        if (!$token)
        {
            return  redirect('login')->withErrors(['email' => 'Email Verification Token not provided!']);
        }

        $user = User::where('email_token', $token)->first();

        if (!$user)
        {
            return  redirect('login')->withErrors(['flash-error' => 'Invalid Email Verification Token!']);
        }

        Auth::login($user);
        return redirect('home');
    }

}
