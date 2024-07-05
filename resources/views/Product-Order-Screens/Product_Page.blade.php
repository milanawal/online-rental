@extends('layout')
@section('title') Online Rental System @endsection
@section('keywords') Home,About,Contact,Car @endsection
@section('description') Write some descripton about the webpage @endsection
@section('content')
 
<div align="left" class="px-5 py-2" style="background:#1CD5E8;margin-top:5px; ">
 
<p class="my-2 "  style="font-weight:bold; "><a href="{{url('/')}}" class="black-text">Home </a>/ {{$Product->name}} </p>
 

</div>
<link rel="stylesheet" href="{{asset('assets/css/xzoom.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script src="{{ asset('assets/js/srcforimagezoomingeffects.min.js')}}"></script>
<script src="{{ asset('assets/js/xzoom.min.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>





<script>
    $(document).ready(function() {
        $("#main_image, .xzoom-gallery").xzoom({fadeIn:true;fadeOut:true;position:inside;});
        $('#daterange').daterangepicker({
                opens: 'left' // Adjust the calendar to open on the left of the input
            });
    });
</script> 

<style>

    .checked {
      color: orange;
    }
    </style>
<div class="container py-5">
    
  <div class="product_data px-3 py-5  "  >

      <div class="row  d-flex align-items-center ">
          <div class="col-md-4  animated fadeInRight fast" style="width: 100%;">
                  <!-- Main image, on which xzoom will be applied -->
                  <img class="xzoom img-fluid" id="main_image"  src="{{asset('Uploads/Products/'.$Product->image1)}}" xoriginal="{{asset('Uploads/Products/'.$Product->image1)}}" style="width:70%">
                  <!-- Thumbnails -->
                  <br>       <br>
                  @if($Product->image2 == '' && $Product->image3 == '' && $Product->image4 == '')
                  @else
                  <a href="{{asset('Uploads/Products/'.$Product->image1)}}">
                      <img class="xzoom-gallery" width="80" src="{{asset('Uploads/Products/'.$Product->image1)}}">
                  </a>
                   @endif
                  @if($Product->image2 == '')
                  @else
                  <a href="{{asset('Uploads/Products/'.$Product->image2)}}">
                      <img class="xzoom-gallery" width="80" src="{{asset('Uploads/Products/'.$Product->image2)}}" xpreview="{{asset('Uploads/Products/'.$Product->image2)}}">
                  </a>
                  @endif
                  
                    @if($Product->image3 == '')
                  @else
                          <a href="{{asset('Uploads/Products/'.$Product->image3)}}">
                              <img class="xzoom-gallery" width="80" src="{{asset('Uploads/Products/'.$Product->image3)}}">
                          </a>
                    @endif
                    @if($Product->image3 == '')
                    @else
                          <a href="{{asset('Uploads/Products/'.$Product->image4)}}">
                              <img class="xzoom-gallery" width="80" src="{{asset('Uploads/Products/'.$Product->image4)}}">
                          </a>
                  @endif
          </div>


                      <div id="product_data" class="col-md-7 animated fadeInLeft fast">
                          @csrf

                              <h3 style="font-weight:bold;">{{$Product->name}}</h3>
                              <p>Posted by {{ $verified==true?'verified':'unverified' }} user</p>
                            
                              <p>{{$Product->description}}</p>
                              

                                <input type="hidden"   name="product_id"   min=0 value="{{$Product->id}}" required class="form-control product_id">
                                   <p> Price : <strong style="font-size:20px;font-family: 'Balsamiq Sans', cursive;">रु {{$Product->price}}</strong> per/day</p>
                                      <p><?php echo $Product->additional_info;?></p>
                                <p> Cost : <strong style="font-size:20px;font-family: 'Balsamiq Sans', cursive;">रु {{$Product->cost}}</strong> Product Value</p>
                                <!-- <p> 50 % of cost for deposite : <strong style="font-size:20px;font-family: 'Balsamiq Sans', cursive;">रु {{$Product->cost * 50/100}}</strong> Product Value</p> -->

                                <div class="col-md-6" style="margin-left:-20px;">  
                                  <input type="number" class="form-control quantity" name="quantity" max="{{   $Product->quantity }}" min="0" value="{{ $Product->quantity==null || $Product->quantity==0?0:$Product->quantity}}" placeholder="Quantity">
                                </div>
                                <!-- <div class="col-md-6" style="margin-left:-20px;">  
                                  <input type="number" class="form-control days" name="days" placeholder="Days for Rent">
                                </div> -->
                                <div class="col-md-6" style="margin-left:-20px;">  
                                <label><strong>Start Date</strong></label>
                                <!-- <input type="text" class="form-control date" id="daterange" name="daterange" /> -->
                                  <input type="date" class="form-control start_date" name="start_date" placeholder="Date for Rent">
                                </div>
                                <div class="col-md-6" style="margin-left:-20px;">  
                                <label ><strong>End Date</strong></label>
                                <!-- <input type="text" class="form-control date" id="daterange" name="daterange" /> -->
                                  <input type="date" class="form-control end_date" name="end_date" placeholder="Date for Rent">
                                </div>
                              <div class="col-md-12 my-3"  id="changethebuttons">

                              @if((!Auth()->user()) || $Product->quantity==null || $Product->quantity==0 || (!empty(Auth()->user()) && ($Product->owner_id==Auth()->user()->id || Auth()->user()->email_verified==0 || empty(Auth()->user()->profile) || Auth()->user()->profile->verified == 0)))
                              <button class="btaobtn btaobtn-primary px-2 py-2 book-now-btn" disabled >Book</button>

                              @else
                              <button class="btaobtn btaobtn-primary px-2 py-2 book-now-btn" >Book</button>

                              @endif

                                      <!-- <button   class="btaobtn btaobtn-light px-2 py-2 add-to-cart-btn">Add to Cart </button> -->
                                    <div id="showloading"> </div>
                                      <div align="left" class="alert alert-danger" id="msg_diverr2" style="display: none;">
                                          <span id="triggererrors"></span>
                                      </div>
                              </div>

                            </div>


      </div>
  </div>
</div>
<hr>

 
@endsection