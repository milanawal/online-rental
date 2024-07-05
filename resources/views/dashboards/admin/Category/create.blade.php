@extends('layout')
@section('title') ORS @endsection
@section('keywords')   @endsection
@section('description')   @endsection
@section('content')
<div align="center" style="background:#1CD5E8;padding:20px;"> 
         <h3  class="black-text" style="font-weight:bold;"><a href="{{url('admin-dash')}}">Admin Dashboard</a></h3>

        <p class="white-text" style="font-weight:bold;"> 

            <a href="{{url('admin-products')}}" class="badge badge-pill btn-outline-green     px-3 py-2">  <i class="fas fa-file-powerpoint"></i>  &nbsp; Show All Products</a> 
        
            <a href="{{url('admin-add-product')}}" class="badge badge-pill btn-dark disabled  px-3 py-2">   <i class="fas fa-plus"></i>  &nbsp; Add New Product</a> 
            <a href="{{url('admin-bin-products')}}" class="badge badge-pill btn-outline-danger px-3 py-2"><i class="fas fa-dumpster"></i> Recycle Bin</a>

        </p>
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif
  

</div>

 

<div class="container py-5">
    <p align="left">
        <i class="fas fa-plus"></i> Add New Category
   </p>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
              <form method="POST" action="{{url('admin-store-category')}}" enctype="multipart/form-data">
                  @csrf
              
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                      <div class="row" style="padding: 30px;">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label> Category Name</label>
                                  <input type="text" class="form-control" name="name"  placeholder="Enter Name">
                              </div>
                          </div>
                          
                         
                          <div class="col-md-12">
                              <div class="form-group">
                              <button type="submit" class="btaobtn btaobtn-success">Save</button>
                              </div>
                          </div>



                      </div>



                  </div>
                
                              </form>

              </div>
        </div>
    </div>
</div>
<hr>
@endsection