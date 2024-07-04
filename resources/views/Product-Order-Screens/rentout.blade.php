@extends('layout')
@section('title') All Rental @endsection
@section('keywords') Home,About,Contact,Car @endsection
@section('description') Write some descripton about the webpage @endsection
@section('content')
 
<div class="px-5 py-2" style="background:#1CD5E8;margin-top:5px;" >
  <h5 class="my-2">  <a href="/" class="black-text">Home</a> <strong class="black-text"> > <a href="{{url('cart')}}" class="black-text" >Cart </a> > <a href="" class="white-text" >Check out </a> </strong> </h5>
           
</div>
<h2 align="center" id="writetitle" class="black-text py-3" style="font-weight:bold;">Rent Confirm Summary</h2>
<script>
    function Continue()
    {
      event.preventDefault();
      const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
        url:"Shipping_Payment_Screen",
        type:"get",
        data:{
          CSRF_TOKEN
        },
        success:function (data)
        {
          window.scroll({    top: 0, left: 0,    behavior: 'smooth'  });
          //console.log(data)
          $('#dynamic_content').html(data)
         
          $('#writetitle').html('Choose your payment method') 
           
         
        }
      })
    }
     
</script>
@if (session('invalid'))
  
      <script>
          $(document).ready(function () {
           alertify.set('notifier','position','top-right');
                
  
                alertify.alert("Reponse","You Entered Invalid Promo Code");
          });
     </script>
     
@endif  
@if (session('valid'))
  
      <script>
          $(document).ready(function () {
           alertify.set('notifier','position','top-right');
                
  
                alertify.success("Promo Code Applied Succesfully");
          });
     </script>
     
@endif 

     <section  class="container py-4">
         <div class="row">
             <div id="dynamic_content" class="col-md-12">
                <div class="col-md-6" id="order_summary"  >
                
                        <ul  class="card    p-3"  style=" list-style: none;">
                                    
                            @if(session('cart'))
                                <?php $total=0;$count=0;$delivery_charges=0;$deposite=0 ?>
                                @foreach(session('cart') as $id => $details)
                                <?php     $count=$count +1 ;
                                $total += $details['item_price'] * $details['item_quantity'] * $details['days']
                                 ?>

                                <?php 
                                $sum = 0;
                                  $sum =  $details['deposite_amount']*$details['item_quantity'];
                                  $deposite += $sum;
                                  
                                 ?>
                                

                        
                                @endforeach
                                
                                <li>
                                    <p align="left" style="float:left;">
                                        <strong>
                                            Product
                                        </strong>
                                    </p>
                                    
                                   
                                    
                                    <p align="right" >
                                        <strong>
                                            Price
                                        </strong>
                                    </p>

                                    
                                </li>
                                <li>
                                    
                                        @foreach(session('cart') as $id => $details)
                                            <p align="left" style="float:left;">
                                                
                                                <img src="{{asset('Uploads/Products/'.$details['item_image'].'') }}" width="15px" > {{$details['item_name']}}
                                               
                                            
                                            </p></br>
                                            <p align="left" style="float:left;">
                                                
                                               Days: {{$details['days']}}
                                               
                                            
                                            </p>
                                            
                                            <p align="right" >
                                                {{$details['item_quantity']}} X    {{$details['item_price']}} x  {{$details['days']}}
                                                : {{$details['item_quantity'] *    $details['item_price'] *  $details['days']}}
                                            </p>

                                          <p> 20 % of cost for deposite : <strong style="font-size:20px;font-family: 'Balsamiq Sans', cursive;">रु {{$details['deposite_amount']}} for each</strong> Product Value is {{ $deposite }}</p>


                                          <?php $delivery_charges = $delivery_charges + $details['delivery_charges'] ?>
                                        @endforeach
                                         <p align="left" style="float:left;color:#000066;">
                                             Delivery Charges
                                         </p>
                                         <p align="right" style="color:#000066" >
                                            <?php echo $delivery_charges?>  /-
                                          </p>
                                </li>
                                    <li>  <hr>
                                        <p align="left" style="float:left;">
                                            SubTotal: 
                                        </p>
                                        <p align="right" >
                                            <i class="fas fa-rupee-sign " ></i>  {{$total+$deposite +$delivery_charges}}  
                                        </p>
                                    
                                       
                                      
                                        <hr>
                                    </li>

                                    <li>
                                        <p align="left" style="float:left;">
                                            Service Charge: 
                                        </p>
                                        <h4 align="right" >
                                            <i class="fas fa-rupee-sign " ></i>  <strong>
                                            <?php $service_charge = (15 / 100) * $total ?>
                                              {{ ceil($service_charge)     }}</strong> 
                                        </h4>
                                    </li> 
                                
                                    <li>
                                        <p align="left" style="float:left;">
                                            Total: 
                                        </p>
                                        <h4 align="right" >
                                            <i class="fas fa-rupee-sign " ></i>  <strong>
                                              {{ $total +ceil($service_charge) + $deposite + $delivery_charges     }}</strong> 
                                        </h4>
                                    </li>    
                                    @endif

                                    <button onclick="Continue()" class="btaobtn btaobtn-outline-dark px-2 py-2">Continue</button>
                    
                        </ul>
                
                </div>
             </div>
         </div> 
                          

           
         
  
</section>
       
   
      
      
   @if ($errors->any())
          <script>
        $(document).ready(function () {
    
      $('#centralModalfailure').modal('show');
    
      });
      </script>
   
@endif
   








  <!-- Central Modal Medium Failure -->
  <div class="modal fade" id="centralModalfailure" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-danger" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <p class="heading lead">Error</p>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <div class="text-center">
          <i class="fas fa-exclamation-circle fa-4x mb-3 animated rotateIn"></i>
          <h3 style="color: red"> Some Errors are Found! </h3>
         <ul align="left"  >
           @foreach ($errors->all() as $error)
               
                             <li  class="text-danger">{{ $error }}</li>
             
             
              
                
               
              
          
            @endforeach
           
            
            </ul>
        </div>
      </div>

      <!--Footer-->
      <div class="modal-footer justify-content-center">
          <p   class="close" data-dismiss="modal" aria-label="Close"  >
        <button  class="btaobtn btaobtn-danger">Try Again<i class="far fa-gem ml-1 text-white"></i></button>
        </p>
        
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!-- Central Modal Medium Failure-->

 
      
      
      
      
 
@endsection