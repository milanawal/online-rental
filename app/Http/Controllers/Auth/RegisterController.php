<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
        public function redirectTo()
    {
         $count=session()->get('cart');
         if($count)
         {
               return 'checkout';
         }
         else
         {
             return '/';
         }
        
    }
  //  protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'mnumber' => ['required', 'string', 'digits:10', 'unique:users'],
        ], [
            'mnumber.required' => 'The mobile number is required.',
            'mnumber.digits' => 'The mobile number must be exactly 10 digits.',
            'mnumber.unique' => 'The mobile number has already been taken.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if($user){
            $name='Online Rental';
            $email='milanawal123@gmail.com';
            $subject='Test';
            $message='Hello';
            $emailto=$data['email'];
            $recievername=$name;
            /* Mail Starts Here */
            $welcomemessage='Hello';
            $emailbody=$data['name'];
            $verificationUrl = $this->generateVerificationUrl($user);
            $emailcontent=array(
                'WelcomeMessage'=>$welcomemessage,
                'emailBody'=>$emailbody,
                'verificationUrl'=>$verificationUrl
            );
            

            Mail::send(array('html' => 'emails.emailVerification'), $emailcontent, function($message) use
                ($emailto, $subject,$recievername)
                {
                    $message->to($emailto, $recievername)->subject
                    ('Hello Admin New Mail From your Client/Customer:'.$subject);
                    $message->from('admin@onlinerental.com','OnlineRental');
                    
                });
                            

            return $user;
        }


    }
    
    protected function generateVerificationUrl($user)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
        );
    }
}
