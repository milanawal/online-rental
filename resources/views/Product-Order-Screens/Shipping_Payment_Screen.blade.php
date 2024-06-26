<div class="col-md-7  " id="shipping_and_returns" >
    <form method="POST" action="order-proceed">
        @csrf


        <!--Form Data For Shippping and Payment Details Ended Here -->
        <!--Form Data For Order Details,....Starts Here-->
            @if(session('cart'))
                <?php $total=0;$count=0;$order_details='';$delivery_charges=0;?>
                
                    @foreach(session('cart') as $id => $details)
                        <?php     $count=$count +1 ;
                        $total += $details['item_price'] * $details['item_quantity'] * $details['days'] ?>
                        <?php $delivery_charges = $delivery_charges + $details['delivery_charges'] ?>
                        @php  
                        $order_details=$order_details.'<br>'.
                        ('Product Name:'.$details["item_name"].', Quantity: '.$details["item_quantity"].
                        '<br> Price:'.$details["item_price"]);
                        @endphp 
                    @endforeach
                
               
            @endif  
            @if(session('promocode'))
                 <input type="hidden" value="{{ $total + $delivery_charges - session('discount') * $total / 100 }}" class="form-control" name="Amount" >
            @else
                 <input type="hidden" value="{{$total + $delivery_charges}}" name="Amount" class="form-control">
            @endif
            <textarea  hidden class="form-control">{{$order_details}}</textarea>
            <input type="hidden" value="{{session('promocode')}}" class="form-control">
            <div align="center" class="col-md-12">
                
                <button type="submit"   class="btn btn-dark btn-lg">PLACE ORDER</button>  
            
            </div>
        <!--Form Data For Order Details,....Ended Here-->
    </form>
</div>
