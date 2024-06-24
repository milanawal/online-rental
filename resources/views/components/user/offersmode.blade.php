<div class="container my-5"> 



    <h3 class="py-2 px-5">Offers received</h3>
   <div class="row px-5">
       
       <div class="col-md-12">
               <div class="card">
                   <div class="card-body table-responsive">
                       <table class="table table-striped table-bordered ">
                           <thead>
                               <th>Order_Id</th>
                               <th>Order Details</th>
                               <th>Delivery Address</th>
                               <th>Total Price (INR)</th>
   
                                
                               <th>Action</th>
                               
   
                           </thead>
                           @php
                           $email= Auth::user()->email;
                           $productsIds = App\Models\Products::where('owner_id','=',Auth::user()->id)->pluck('id');
                           $Orders=App\Models\Order::whereIn('product_id',$productsIds)->get();
                         @endphp
                           <tbody>
                               @foreach ($Orders as $item)
                           <tr>
   
                               <td>{{$item->id}}</td>
                               <td><?php echo $item->Order_Details?></td>
                               <td><?php echo $item->Delivery_Address ?></td>
                               <td>{{$item->Amount}}</td>
                               
                               <td> 
                                   <a href="{{url('Order-Status/'.$item->id.'')}}" class="badge btaobtn btaobtn-primary px-2 py-2 ">Check Status</a>
                                 
                               
<!--                                   
                                
                                 @if($item->Delivery_Status!='pending' || $item->Order_Cancel_Status==1 || $item->offer_status==1)
                                  <a href="{{url('Order-Status/'.$item->id.'')}}"    class="badge btaobtn btaobtn-danger px-2 py-2 disabled">Reject Offer</a>
                                  @else
                                      <a href="{{url('Order-Cancel/'.$item->id.'')}}" class="badge btaobtn btaobtn-danger px-2 py-2">Reject Offer</a>
                               
                                 @endif
                                 @if($item->Delivery_Status!='pending' || $item->Order_Cancel_Status==1 || $item->offer_status==1)
                                 <a href="{{url('accept-rent/'.$item->id.'')}}" class="badge btaobtn btaobtn-primary px-2 py-2 disabled">Accept Rent Offer</a>
                                @else
                                <a href="{{url('accept-rent/'.$item->id.'')}}" class="badge btaobtn btaobtn-primary px-2 py-2 ">Accept Rent Offer</a>

                                @endif -->
   
   
                               </td>
   
   
   
   
    
                               </td>
                           </tr>
                               @endforeach
   
                           </tbody>
   
                       </table>
                   </div>
               </div>
       </div>
   </div>
</div>
   <br> 
   
   