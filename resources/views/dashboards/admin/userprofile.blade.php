@extends('layouts.admin')
@section('title') ORS @endsection
@section('keywords') Home,About,Contact,Car @endsection
@section('description') Write some descripton about the webpage @endsection
@section('content')
<div align="center" style="background:#1CD5E8;padding:20px;">
  <h3  class="black-text" style="font-weight:bold;"><a href="{{url('admin-dash')}}">Admin Dashboard</a></h3>
  <a href="{{url('admin-all-users')}}" class="btn btn-outline-dark" style="color:white">Back</a> 
@if (session('status'))
  <div class="alert alert-danger" role="alert">
      {{ session('status') }}
  </div>
  @endif
  

</div>


 

<div class="container py-2">
   <p align="left">
    <i class="fas fa-edit"></i> User Location
   </p>
     
    <!--Grid column-->
    <div class="col-md-12 mb-4">

        <!--Card-->
        <div class="card">

        <!--Card content-->
        <div class="card-body">
            <h3>Current User:{{$user->profile->first_name}} {{$user->profile->last_name}}</h3>
        

            <form action="{{url('admin/verify-profile',$user->id)}}" method="POST" enctype="multipart/form-data">
                           {{ csrf_field() }}
                           <h3 class="py-3">Profile</h3>
                                   <div class="card">
                                       
                                       <div class="card-body">
                                                  <div class="row "  >
                                                       <div class="col-md-12">
                                                        
                                                       </div>
                                                       <div class="col-md-4">
                                                           <div class="form-group">
                                                            <label> First Name</label>
                                                           <input type="text" value="{{$user->profile->first_name??''}}" readonly name="first_name" class="form-control">
                                                           </div>
                                                       </div>
                           
                                                       <div class="col-md-4">
                                                           <div class="form-group">
                                                            <label> Last Name</label>
                                                           <input type="text" value="{{$user->profile->last_name??''}}" readonly name="last_name"   class="form-control">
                                                           </div>
                                                       </div>
                                                       
                                                       <div class="col-md-4">
                                                           
                                                           <div class="form-group">
                                                           <label> Citizenship</label>
                                                           <input type="file" name="citizenship" class="form-control">
                                                           </div>
                                                       </div>

                                                   </div>

                                                   <div class="row "  >
                                                       <div class="col-md-12">
                                                        
                                                       </div>
                                                       <div class="col-md-6">
                                                           <div class="form-group">
                                                            <label> Address1 ( Door No/Street: )</label>
                                                           <input type="text" value="{{$user->profile->address_1??''}}" readonly name="address_1" class="form-control">
                                                           </div>
                                                       </div>
                           
                                                       <div class="col-md-6">
                                                           <div class="form-group">
                                                            <label> Address2 ( LandMark/Nearby )</label>
                                                           <input type="text" value="{{$user->profile->address_2??''}}" readonly name="address_2"   class="form-control">
                                                           </div>
                                                       </div>
                                                      
                                                   </div>
                                                   <div class="row">
                                                       <div class="col-md-4">
                                                           <div class="form-group">
                                                            <label> City</label>
                                                           <input type="text" value="{{$user->profile->city??''}}"  readonly name="city" class="form-control">
                                                           </div>
                                                       </div>
                                                       <div class="col-md-4">
                                                           <div class="form-group">
                                                            <label>State</label>
                                                           <input type="text" value="{{$user->profile->state??''}}" readonly  name="state" class="form-control">
                                                           </div>
                                                       </div>
                                                       <div class="col-md-4">
                                                           <div class="form-group">
                                                            <label>Pincode</label>
                                                           <input type="text" value="{{$user->profile->pincode??''}}" readonly  name="pincode" class="form-control">
                                                           </div>
                                                       </div>
                                                       <div class="col-md-4">
                                                        <div class="form-group">
                                                         <label>District</label>
                                                        <input type="text" value="{{$user->profile->country??''}}" readonly name="district" class="form-control">
                                                        </div>
                                                    </div>
                                                       <div class="col-md-4">
                                                           <div class="form-group">
                                                            <label>Mobile No</label>
                                                           <input type="text" value="{{$user->profile->mobile_1??''}}" readonly name="mobile_1" class="form-control">
                                                           </div>
                                                       </div>
                           
                                                       <div class="col-md-4">
                                                           <div class="form-group">
                                                            <label>Alternative Mobile No</label>
                                                           <input type="text" value="{{$user->profile->mobile_2??''}}" readonly   name="mobile_2" class="form-control">
                                                           </div>
                                                       </div>
                                                       
                           
                           
                                                       <div class="col-md-12">
                                                           <div class="form-group">
                                                                   <button type="submit" class="btn btn-success btn-lg"> Verify Profile    </button>
                                                           </div>
                                                       </div>
                                                       </div>
                                       </div>
                                    </div>
                           </form>


        </div>

    </div>
    <!--/.Card-->

</div>
<!--Grid column-->

</div>
<hr>
@endsection