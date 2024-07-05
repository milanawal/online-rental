<?php
namespace App\Http\Controllers\Product_Ordering_Controller;

    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller; 
    use App\Models\Products;
    use Illuminate\Support\Facades\Cookie;
    use Session;
    use Illuminate\Support\Facades\Validator;
    use App\Models\Coupen_Code;
    use App\Models\Order;
    use Illuminate\Support\Facades\Auth;
    use Mail;
    use App\Models\Transaction;
    use App\Models\OrderProducts;


    class booking    extends Controller
    {
        public function openrentoutpage()
        {
           
            return view('Product-Order-Screens.rentout');
        }
        
        public function Shipping_Payment_Screen()
        {
        //    dd('sdfsd');
            return view('Product-Order-Screens.Shipping_Payment_Screen');
        }
        public function apply_promo_code(Request $request)
        {

                $promo_code = $request->input('promo_code');
               // $Coupen_Code=Coupen_Code::find($promo_code);
                
                
                if($Coupen=Coupen_Code::where('code',$promo_code)->first())
                {
                     
                    session(['promocode' => $Coupen->code]);
                    session(['discount' =>$Coupen->discount ]);
                    session(['message' =>'% Promo Code Applied Succesfully' ]);
                    session()->reflash();   
                  
                    
                    return back();
                }
                else
                {
                    //die 
                    
                return back()->with('invalid','You Entered Invalid Promo Code');
                }
            
        }
        public function  order_proceed(Request $request)
        {
            //    dd('fsdf');
                /* Delivery Details*/
                $address1=auth()->user()->profile->address_1;
                $address2=auth()->user()->profile->address_2;
                $city=auth()->user()->profile->city;
                $state=auth()->user()->profile->state;
                $mno=auth()->user()->profile->mobile_1;
                $alternativemno=auth()->user()->profile->mobile_2;
                
                $country=auth()->user()->profile->country;
                
               

                $Delivery_Address=$address1.','.$address2.'<br>'.$city.','.$state.','.$country.'<br>'.','.$mno.','.$alternativemno;
             /* Delivery Details*/
                $p_method='Online';
            /* Order Details Starts Here*/
                if(session('cart'))
                {
                    $total=0;$count=0;$order_details='';$delivery_charges=0;$deposite=0;                    
                    foreach (session('cart') as $id => $details) 
                    {
                        $count=$count +1 ;
                        $productId=$details['item_id'];
                        $total += $details['item_price'] * $details['item_quantity'] * $details['days'];
                        $order_details=$order_details.'<br>'.
                        ('Product Name:'.$details["item_name"].', Quantity: '.$details["item_quantity"].
                        '<br> Price:'.$details["item_price"]);
                        $delivery_charges = $delivery_charges + $details['delivery_charges'] ;
                        $date = $details['start_date'] ;
                        $end_date = $details['end_date'] ;
                        $sum = 0;
                        $sum =  $details['deposite_amount']*$details['item_quantity'];
                        $deposite += $sum;
                    }
                
                }
                $service_charge = (15 / 100) * $total;
                $promocode=null;
                $Amount = $total +$deposite + $delivery_charges +$service_charge;
                $O_Details=$order_details;
                $Email_Id=Auth::user()->email;
                $loginid=$Email_Id;
                $name=Auth::user()->name;
            /*Order Details Ends Here*/
                 $Order = new Order();
                 $Order->Customer_Emailid=$Email_Id;
                 $Order->Delivery_Address=$Delivery_Address;
                 $Order->Order_Details=$O_Details;
                 $Order->Coupen_Code=$promocode;
                 $Order->Amount=$Amount;
                 $Order->payment=$total+ $delivery_charges +$service_charge;
                 $Order->deposite_Amount=$deposite;
                 $Order->delivery_charge=$delivery_charges;
                 
                 $Order->required_date = $date;
                 $Order->product_id = $productId;
                 $Order->paymentmode=$p_method;
                 $Order->payment_status=0;
                 $Order->start_date=$date;
                 $Order->end_date=$end_date;
                 $Order->save();       
                 $id=$Order->id;

                if(session('cart'))
                {
                    $total=0;$count=0;$order_details='';$delivery_charges=0;                    
                    foreach (session('cart') as $key => $details) 
                    {
                        $productId=$details['item_id'];
                        $OrderProduct = new OrderProducts();
                        $OrderProduct->order_id=$id;
                        $OrderProduct->product_id=$productId;
                        $OrderProduct->quantity=$details['item_quantity'];
                        $OrderProduct->start_date=$details['start_date'];
                        $OrderProduct->end_date=$details['end_date'];
                        $OrderProduct->created_at=date('Y-m-d H:i:s');
                        $OrderProduct->save(); 

                        $product = Products::where('id',$productId)->first();
                        // $product->quantity = $product->quantity -$details['item_quantity'];
                        $product->save(); 

                    }
                
                }
                
                $transaction_id= (string) \Illuminate\Support\Str::uuid();
                $transaction = new Transaction();
                $transaction->TXNID =  $transaction_id;
                $transaction->Oder_No = $id;
                $transaction->email = $Email_Id;
                $transaction->amount =$Amount;
                $transaction->status = 'pending';
                $transaction->save();

                
    	               
                    $welcomemessage='Hello '.$name.'<br>';
                    $emailbody='Your Order Was Placed Successfully<br>
                    <p>Thank you for your order. We’ll send a confirmation when your order ships. Your estimated delivery date is 3-5 working days. If you would like to view the status of your order or make any changes to it, please visit Your Orders on <a href="https://www.onlinerental.com">Onlinerental.com</a></p>
                    <h4>Order Details: </h4><p> Order No:'.$id.$O_Details.'</p>
                        <p><strong>Delivery Address:</strong>
                    '.$Delivery_Address.'</p>
                    <p> <strong>Total Amount:</strong>
                    '.$Amount.'</p>
                        <p><strong>Payment Method:</strong>'.$p_method.'</p>';
                    $emailcontent=array(
                        'WelcomeMessage'=>$welcomemessage,
                        'emailBody'=>$emailbody
                        
                        );
                        Mail::send(array('html' => 'emails.order_email'), $emailcontent, function($message) use
                        ($loginid, $name,$id)
                        {
                            $message->to($loginid, $name)->subject
                            ('Your Onlinerental.com order '.$id.' is Confirmed');
                            $message->from('admin@onlinerental.com','OnlineRental');
                            
                        });
                
                    // Session::forget('cart');
                    
                    session()->flash('success', 'Session data  is Cleared');
                              

                    // return view('Product-Order-Screens.payment')->with('total',$Amount)->with('tuid',$transaction_id);

                    return redirect(url('payment-confirm',$transaction_id))->with('success', 'Address updated successfully!');

                    // return redirect()->url("/payment-confirm",$transaction_id)->with('status','Order Placed Succesfully!');                  
                 
                
        }

        function paymentScreen($transaction_id) {
            return view('Product-Order-Screens.payment')->with('tuid',$transaction_id);
        }
       
        
        
    }