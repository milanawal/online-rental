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
use App\Models\Transaction;
use Illuminate\Auth\Events\Verified;
use Session;


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
            $categories = Category::all();
        $Products = Products::find($id); 

        return view("dashboards.user.productedit")->with('Products',$Products)->with('categories',$categories);
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
    
            if ($user->email_verified==0) {
                $user->email_verified = 1;
                $user->email_verified_at = time();
                $user->save();
                return redirect()->intended('dashboard')->with('successstatus', 'Your email is verified.');
            }elseif($user->email_verified==1){
                return redirect()->intended('dashboard')->with('successstatus', 'Your email is already verified.');
            }
    
            if ($user->markEmailAsVerified()) {
                event(new Verified($user));
            }


    
            return redirect()->intended('dashboard')->with('message', 'Your email has been verified.');
        }


        public function productUpdate(Request $request, $id)
        {
            $products=Products::find($id);
            $products->name= $request->input('name'); 
            // $products->url= $request->input('url');
            $products->description= $request->input('small_description');
            $products->price= $request->input('price');
            $products->discount= $request->input('Discount');
            $products->rating= $request->input('rating');
            $products->priority= $request->input('priority');
            $products->category_id= $request->input('category_id');
    
    
             $products->title= $request->input('meta_title');
            $products->meta_description= $request->input('meta_description');
            $products->keywords= $request->input('meta_keyword');
    
            $products->status= $request->input('status')==true ? '1':'0';
            
               $products->delivery_charges= $request->input('delivery_charges');
               $products->additional_info= $request->input('additional_info');
    
            $image1 =$request->file('image1');
            if($request->hasfile('image1'))
            {
                $destination='Uploads/Products/'.$products->image1;
                if(File::exists($destination))
                {
                    File::delete($destination);
                }
                $extension=$image1->getClientOriginalExtension();
                $product_Image_name=$products->url.'-1-.'.$extension;
                $image1->move('Uploads/Products/',$product_Image_name);
                $products->image1=$product_Image_name;
    
            }
    
    
            $image2 =$request->file('image2');
            if($request->hasfile('image2'))
            {
                $destination='Uploads/Products/'.$products->image2;
                if(File::exists($destination))
                {
                    File::delete($destination);
                }
                $extension=$image2->getClientOriginalExtension();
                $product_Image_name=$products->url.'-2-.'.$extension;
                $image2->move('Uploads/Products/',$product_Image_name);
                $products->image2=$product_Image_name;
    
            }
            $image3 =$request->file('image3');
            if($request->hasfile('image3'))
            {
                $destination='Uploads/Products/'.$products->image3;
                if(File::exists($destination))
                {
                    File::delete($destination);
                }
                $extension=$image3->getClientOriginalExtension();
                $product_Image_name=$products->url.'-3-.'.$extension;
                $image3->move('Uploads/Products/',$product_Image_name);
                $products->image3=$product_Image_name;
    
            }
    
            $image4 =$request->file('image4');
            if($request->hasfile('image4'))
            {
                $destination='Uploads/Products/'.$products->image4;
                if(File::exists($destination))
                {
                    File::delete($destination);
                }
                $extension=$image4->getClientOriginalExtension();
                $product_Image_name=$products->url.'-4-.'.$extension;
                $image4->move('Uploads/Products/',$product_Image_name);
                $products->image4=$product_Image_name;
    
            }
            $products->save();
            return redirect()->back()->with('status','Product Data Updated Successfully Successfully');   
        }

        function paymentSuccess(Request $request){
            $result = base64_decode($request->data);
            $data = json_decode($result);
            
            $transaction = Transaction::where('TXNID',$data->transaction_uuid)->first();
            if($transaction){
                $transaction->transaction_code = $data->transaction_code; 
                $transaction->status = 'payment_success';
                $transaction->save();
                $order = Order::where('id',$transaction->Oder_No)->first();
                $order->payment_status=1;
                $order->p_status='completed';
                $order->save();
                Session::forget('cart');
                return redirect("/Orders")->with('status','Order Placed Succesfully!');  
            }
                           


        }

    
    
}