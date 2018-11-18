<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Sms\SmsSender;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\User;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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

    private $sms;

    public function __construct(SmsSender $sms)
    {
        $this->middleware('guest')->except('logout');
        $this->sms = $sms;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/cabinet';

    public function authenticated(Request $request)
    {
        $user = Auth::user();
        if ($user->isPhoneAuthEnabled()) {
            Auth::logout();
            $token = (string)random_int(10000, 99999);
            $request->session()->put('auth', [
                'id' => $user->id,
                'token' => $token,
                'remember' => $request->filled('remember'),
            ]);

            $this->sms->send($user->phone, 'Login code: ' . $token);

            return redirect()->route('login.phone');
        }

        return false;
    }

    public function phone()
    {
        return view('auth.phone');
    }

    public function verify(Request $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }

        $this->validate($request, [
            'token' => 'required|string',
        ]);

        if (!$session = $request->session()->get('auth')) {
            throw new BadRequestHttpException('Missing token info.');
        }

        /** @var User $user */
        $user = User::findOrFail($session['id']);
        if ($request['token'] === $session['token']) {
            $request->session()->flush();
            $this->clearLoginAttempts($request);
            Auth::login($user, $session['remember']);
            return redirect()->intended(route('cabinet.home'));
        }

        $this->incrementLoginAttempts($request);

        throw ValidationException::withMessages(['token' => ['Invalid auth token.']]);
    }
}
