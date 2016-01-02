<?php

namespace App\Http\Controllers\Auth;

use Mail;
use Input;
use Log;

use App\User;
use Validator;
use JsValidator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectPath = '/';
    protected $redirectTo = '/';


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    public function postRegister(Request $request)
    {
        $registerRedirectPath = '/register-success';
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        Auth::login($this->create($request->all()));

        return redirect($registerRedirectPath);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $confirmationCode = str_random(16);

        $newUser = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'status' => 'unconfirmed',
            'confirmation_code' => $confirmationCode
        ]);

        Mail::queue(['emails.verify', 'emails.verify-plain-text'], ['confirmationCode' => $confirmationCode], function($message) {
            $message->to(Input::get('email'))
                ->bcc('support@roastmygame.com', 'Support')
                ->subject('Please confirm your email');
        });
        Log::info('Confirm account email sent out to '.Input::get('email').' with confirmation code '.$confirmationCode);

        return $newUser;
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        $rules = array(
            'email' => 'required|email',
            'password' => 'required',
        );
        $validator = JsValidator::make($rules);

        return view('auth.login', ['validator'=>$validator]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        $validator = JsValidator::validator(
            $this->validator([])
        );
        return view('auth.register', ['validator'=>$validator]);
    }

}
