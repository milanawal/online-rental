<div class="row">
    <div class="col-md-6">
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="{{asset('assets/img/esewa-digital-wallet-.jpg')}}" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">e-Sewa</h5>
                <form method="POST" action="order-proceed">
        @csrf
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
                <button type="submit"   class="btn btn-success">Pay Via eSewa</button> 
            </div>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="{{asset('assets/img/Khali-Digital-wallet-.jpg')}}" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Khalti</h5>
                <button class="btn btn-primary" disable>Pay Via Khalti</button>
            </div>
        </div>
    </div>
</div>
