@extends('layout')
@section('title') About Us @endsection
@section('keywords')   @endsection
@section('description') @endsection
@section('content')
<div align="center" style="background:#1CD5E8;padding:20px;">
   <h3  class="black-text" style="font-weight:bold;margin-top:15px;">
      About Us
   </h3>
   <p class="white-text" style="font-weight:bold;">Online Rental System</p>
</div>
<div class="container-fluid" style="background:white;font-family: 'Balsamiq Sans', cursive;">
   <div class="row px-5">
      <div   class="col-md-12 ">
         <div align="center" style="margin:20px">
               <img src="{{url('assets/img/about-us.jpg')}}" class="img-fluid">
         </div>
         <p style="text-align: justify;">Welcome to Online Rental System, the premier online rental system designed to connect individuals and businesses with the resources they need. Our platform is built on the principles of convenience, security, and community, providing a seamless way to rent and list products across a wide range of categories.
</p>
      </div>
</div>
</div>
@endsection