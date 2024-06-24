<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Order;
use App\Models\NewsLetter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Mail;
use App\Models\Products;
use App\Models\Category;
use App\Models\BankDetail;
use Illuminate\Auth\Events\Verified;


class UserController extends Controller
{
    public function subscribe(Request $request)
    {
           $NewsLetter = new NewsLetter();
           $NewsLetter->name= $request->input('name'); 
           $NewsLetter->email= $request->input('email');
           $NewsLetter->save();
           return redirect()->back()->with('status','Thanks for Subscribing! We Will mail You Our Latest Updates');

    }
    public function index()
    {
         return view('dashboards.user.index');
    }
    public function open_profile()
    {
         return view('dashboards.user.profile');
    }
    public function update(Request $request)
    {
          

                 $validation =$request->validate([
                       'name'=>'nullable|max:60',
                       'image'=>'',
                       'address1'=>'',
                       'address2'=>'',
                      'LandMark'=>'nullable|max:60',
                      'city'=>'nullable|max:60|regex:/^[a-zA-Z\s]*$/',
                      'state'=>'nullable|max:60|regex:/^[a-zA-Z\s]*$/',
                      'pincode'=>'nullable|digits_between:4,10',
                      'mno'=>'nullable|digits:10',
                       'alternativemno'=>'nullable|digits:10',
                      'country'=>'nullable|max:30|regex:/^[a-zA-Z\s]*$/',
                // 'MobileNumber'=>'required|numeric',
                 
                ]);
                  print_r($validation);
                $name=$request->input('name');
                $address1=$request->input('address1');
                $address2=$request->input('address2');
                $city=$request->input('city');
                $state=$request->input('state');
                $pincode=$request->input('pincode');
                $mno=$request->input('mno');
                $alternativemno=$request->input('alternativemno');
                
                $country=$request->input('country');
                
                $user_id=Auth::user()->id;
                $user=User::findOrFail($user_id);
                $user->name=$name;
                
                $user->address1=$address1;
                $user->address2=$address2;
                $user->city=$city;
                $user->state=$state;
                $user->pincode=$pincode;
                $user->mnumber=$mno;
                $user->alternativemno=$alternativemno;
                
                $user->country=$country;
                
        
                if($request->hasfile('image'))
                {
                    $destination='Uploads/profiles/'.$user->image;
                    if(File::exists($destination))
                    {
                        File::delete($destination);
                    }
                    $file=$request->file('image');
                    $extension=$file->getClientOriginalExtension();
                    $filename=time() .'.'.$extension;
                    $file->move('Uploads/profiles/',$filename);
                    $user->image=$filename;
        
        
                }
        
                  $user->update();
                   return redirect()->back()->with('successstatus', 'Your Profile Data is Updated Succesfully');
    


    }
    public function open_orders()
    {

         return view('dashboards.user.orders');
    }
    public function open_transactions()
        {
            
            return view('dashboards.user.transactions');
        }
         public function updatepassword(Request $request)
         {
             $validation =$request->validate([
                       'newpass'=>'required', 
                        'confirm_new_Pass'=>'required', 
                 
                ]);
                  print_r($validation);
                $newpass=$request->input('newpass');
                $confirm_new_Pass=$request->input('confirm_new_Pass');
                if($confirm_new_Pass==$newpass)
                {
                    $user_id=Auth::user()->id;
                    $user_id=Auth::user()->id;
                    $user=User::findOrFail($user_id);
                    $user->password=Hash::make($newpass);
                    $user->update();
                    return redirect()->back()->with('successstatus', 'Password is Updated Succesfully');   
                }
                else
                {
                    
                    return redirect()->back()->with('passwordwontmatch', 'Password Wont Match! Please Try Again!!');  
                    
                }
                   
         }
         
         public function send_email(Request $request)
         {
             $validation =$request->validate([
                       'name'=>'required|max:30|regex:/^[a-zA-Z\s]*$/', 
                        'email'=>'required|email', 
                         'subject'=>'required|max:80', 
                        'message'=>'required|max:300', 
                 
                ]);
                  print_r($validation);
             
                $name=$request->input('name');
                $email=$request->input('email');
                $subject=$request->input('subject');
                $message=$request->input('message');
                $emailto="rahulvijayanagaram@gmail.com";
                $recievername="Admin";
                /* Mail Starts Here */
                   $welcomemessage='Hello Admin';
        	                $emailbody='I am '.$name.'<br>
        	             <p><strong>My Query/Message: </strong> :'.$message.'</p> <br>
        	             <strong>My Emailid: </strong>'.$email.'<br>';
        	                $emailcontent=array(
        	                    'WelcomeMessage'=>$welcomemessage,
        	                    'emailBody'=>$emailbody
        	                   
        	                    );
        	                    Mail::send(array('html' => 'emails.order_email'), $emailcontent, function($message) use
        	                    ($emailto, $subject,$recievername)
        	                    {
        	                        $message->to($emailto, $recievername)->subject
        	                        ('Hello Admin New Mail From your Client/Customer:'.$subject);
        	                        $message->from('codetalentum@btao.in','CodeTalentum');
        	                        
        	                    });
                /* Mail Ends Here */
                
                 return redirect()->back()->with('status', 'Thank you for contacting us, we will reach you as soon as possible');   
                
             
         }

         function addProduct() {
            if(auth()->user()->email_verified!=1){
                return redirect()->back()->with('warningstatus', 'Please verify your email before adding products');   

            }
            $categories = Category::all();
            return view('dashboards.admin.Products.add')->with('categories', $categories);
         }

        public function products()
        {
            // dd('jere');
           

            $Products=Products::where('owner_id','=',Auth::user()->id)->paginate(5);
            return view('dashboards.user.myproducts')->with('Products', $Products);
        }

        public function  ShowEditingScreen($id)
        {
        $Products = Products::find($id); 

        return view("dashboards.user.productedit")->with('Products',$Products);
        }
        
        function getMyOffers(){
            return view('dashboards.user.offers');
        }

        function acceptMyOffers($id){
            $offer = Order::find($id);

            $offer->offer_status = 1;
            $offer->accepted_by = Auth::user()->id;
            $offer->save();
            return redirect()->back()->with('status', 'You have accepted the offer');   
        }

        public function updateProfile(){
            return view('dashboards.user.profile');
        }

        public function updateBank(Request $request){
            // dd(Auth::user()->bankDetail);
            $validation =$request->validate([
                'bank_name'=>'nullable|max:60',
                'account_name'=>'nullable|max:60',
                'branch'=>'nullable|max:60',
                'account_number'=>'nullable|digits:15',
                'phone'=>'nullable|digits:10',
            ]);

            $user_id=Auth::user()->id;
            $user=BankDetail::where('user_id',$user_id)->first();
            if(empty($user)){
                $user = new BankDetail();
            }

            $user->bank_name=$request->input('bank_name');
            $user->user_id=$user_id;
            $user->account_name=$request->input('account_name');
            $user->branch=$request->input('branch');
            $user->status=1;
            $user->account_number=$request->input('account_number');
            $user->phone_number=$request->input('phone');
            $user->save();
            return redirect()->back()->with('successstatus', 'Your Bank Data is Updated Succesfully');

        }

        public function verifyEmail(Request $request)
        {
            $user = User::find($request->route('id'));
    
            if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
                throw new AuthorizationException;
            }
    
            if ($user->hasVerifiedEmail()) {
                $user->email_verified = 1;
                $user->email_verified_at = time();
                $user->save();
                return redirect()->intended('dashboard')->with('message', 'Your email is already verified.');
            }
    
            if ($user->markEmailAsVerified()) {
                event(new Verified($user));
            }


    
            return redirect()->intended('dashboard')->with('message', 'Your email has been verified.');
        }

    
    
}