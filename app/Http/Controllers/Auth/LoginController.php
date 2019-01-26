<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\User ;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $userSocial = Socialite::driver('facebook')->user();

        // return $user->token;

        $findUser = User::where('email' ,$userSocial->email)->first();

        if($findUser){
            Auth::login($findUser);

            return 'done with old' ;
        }

        else {
            $user = new User ;

            $user->name = $userSocial->name ;
            $user->email = $userSocial->email ;
            $user->password = bcrypt(123456) ;
    
            $user->save();
    
            Auth::login($user);
    
            return 'done new' ;
        }
      
        
//         $token = $user->token;
//         $refreshToken = $user->refreshToken; // not always provided
//         $expiresIn = $user->expiresIn;

// // OAuth One Providers
//         $token = $user->token;
//         $tokenSecret = $user->tokenSecret;

// // All Providers
//         $user->getId();
//         $user->getNickname();
//         $user->getName();
//         $user->getEmail();
//         $user->getAvatar();
//     }
    }
}
