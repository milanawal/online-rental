@extends('layout')
@section('title') ORS @endsection
@section('keywords') Home,About,Contact,Car @endsection
@section('description') Write some descripton about the webpage @endsection
@section('content')
<div align="center" style="background:#1CD5E8;padding:20px;"> 
    <h3  class="black-text" style="font-weight:bold;"><a href="{{url('admin-dash')}}">Admin Dashboard</a></h3>

<p class="white-text" style="font-weight:bold;"> 
    <a href="{{url('admin-products')}}" class="badge badge-pill btn-green   disabled px-3 py-2">  <i class="fas fa-file-powerpoint"></i>  &nbsp; Show All Categories</a> 
        
    <a href="{{url('admin-add-category')}}" class="badge badge-pill btn-outline-dark   px-3 py-2">   <i class="fas fa-plus"></i>  &nbsp; Add New Category</a> 
    <a href="{{url('admin-bin-category')}}" class="badge badge-pill btn-outline-danger px-3 py-2"><i class="fas fa-dumpster"></i> Recycle Bin</a>

</p>
@if (session('status'))
  <div class="alert alert-danger" role="alert">
      {{ session('status') }}
  </div>
  @endif
  

</div>

 

<div class="container py-5">
    <p align="left">
        <i class="fas fa-file-powerpoint"></i> All Categories
   </p>
     
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                           
                            <th>Name</th>
                            
                            <th>Status</th>
                            <th>Action</th>
    
                        </thead>
                        <tbody>
                            @foreach ($categories as $item)
                            <tr>
    
                                <td>{{$item->name}}</td>
                                
    
                                <td>
                                             <?php
                                                if( $item->status==1)
                                                {
                                                    echo '<p class="badge badge-pill btn-success"><i class="fas fa-check "></i></p>';
                                                }
                                                else
                                                {
                                                    echo '<p class="badge badge-pill btn-danger"><i class="fas fa-times"></i></p>';
                                                }
                                             ?>
                                </td>
                                <td>
                                <a href="{{url('admin-category-edit/'.$item->id)}}" class="badge badge-pill btn-primary px-3 py-2">Edit</a>
                                <a href="{{url('admin-category-delete/'.$item->id)}}" class="badge badge-pill btn-danger px-3 py-2">Delete</a>
    
                                </td>
                        </tr>
                            @endforeach
     
                        </tbody>
    
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <br>
            <p  align="center">
            {{ $categories->links()}}</p>
        </div>
</div>
   
<hr>
@endsection