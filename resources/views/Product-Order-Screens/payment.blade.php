<style>
        .hidden {
            display: none; /* Hides the button */
        }

        .invisible {
            visibility: hidden; /* Makes the button invisible but it still takes up space */
        }
    </style>
<div class="col-md-7  " id="shipping_and_returns" >
    <form method="POST" id="payment_form" action="https://rc-epay.esewa.com.np/api/epay/main/v2/form">
        @csrf

        <!--Form Data For Shippping and Payment Details Started at  Here -->


        <!--Form Data For Shippping and Payment Details Ended Here -->
        <!--Form Data For Order Details,....Starts Here-->
            @if(session('cart'))
                <?php $total=0;$count=0;$order_details='';$delivery_charges=0; $deposite=0;?>
                
                    @foreach(session('cart') as $id => $details)
                        <?php     $count=$count +1 ;
                        $total += $details['item_price'] * $details['item_quantity'] * $details['days'] ?>
                        <?php $delivery_charges = $delivery_charges + $details['delivery_charges'] ?>
                        <?php 
                                  $deposite += $details['deposite_amount']* $details['item_quantity']
                                 ?>
                        @php  
                        $order_details=$order_details.'<br>'.
                        ('Product Name:'.$details["item_name"].', Quantity: '.$details["item_quantity"].
                        '<br> Price:'.$details["item_price"]);
                        
                       
                        @endphp 
                    @endforeach
                
               
            @endif  
            
            <!-- @if(session('promocode'))
                 <input type="hidden" value="{{ $total + $delivery_charges - session('discount') * $total / 100 }}" class="form-control" name="Amount" >
            @else
                 <input type="hidden" value="{{$total + $delivery_charges}}" name="Amount" class="form-control">
            @endif -->
            <textarea  hidden class="form-control">{{$order_details}}</textarea>
            <input type="hidden" value="{{session('promocode')}}" class="form-control">


            @php 

            $service_charge = (15 / 100) * $total;
            $total =  $total +ceil($service_charge) + $deposite + $delivery_charges;

            $signature = "total_amount=".$total.",transaction_uuid=".$tuid.",product_code=EPAYTEST";
            $secretKey = "8gBm/:&EnhH.1/q";
            

            $signature = hash_hmac('sha256', $signature, $secretKey, true);
            $base64EncodedSignature = base64_encode($signature);


            @endphp

            <input type="hidden" id="amount" name="amount" value="{{ $total }}" required>
            <input type="hidden" id="tax_amount" name="tax_amount" value ="0" required>
            <input type="hidden" id="total_amount" name="total_amount" value="{{$total}}" required>
            <input type="hidden" id="transaction_uuid" name="transaction_uuid" value="{{ $tuid }}" required>
            <input type="hidden" id="product_code" name="product_code" value ="EPAYTEST" required>
            <input type="hidden" id="product_service_charge" name="product_service_charge" value="0" required>
            <input type="hidden" id="product_delivery_charge" name="product_delivery_charge" value="0" required>
            <input type="hidden" id="success_url" name="success_url" value="{{ url('payment-success') }}" required>
            <input type="hidden" id="failure_url" name="failure_url" value="{{ url('payment-failed') }}" required>
            <input type="hidden" id="signed_field_names" name="signed_field_names" value="total_amount,transaction_uuid,product_code" required>
            <input type="hidden" id="signature" name="signature" value="{{ $base64EncodedSignature  }}" required>


            <div align="center" class="col-md-12">
                
                <button type="submit"   class="btn btn-dark btn-lg hidden">PLACE ORDER</button>  
            
            </div>
        <!--Form Data For Order Details,....Ended Here-->
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#payment_form').submit();
    });
</script>
