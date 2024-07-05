@extends('layout')
@section('title') ORS @endsection
@section('keywords') Home,About,Contact,Car @endsection
@section('description') Write some descripton about the webpage @endsection
@section('content')
<div align="center" style="background:#1CD5E8;padding:20px;"> 
    <h3  class="black-text" style="font-weight:bold;"><a href="{{url('admin-dash')}}">User Dashboard</a></h3>

<p class="white-text" style="font-weight:bold;"> 
    <a href="{{url('admin-products')}}" class="badge badge-pill btn-green   disabled px-3 py-2">  <i class="fas fa-file-powerpoint"></i>  &nbsp; Show All Products</a> 
        
    <a href="{{url('rent-add-product')}}" class="badge badge-pill btn-outline-dark   px-3 py-2">   <i class="fas fa-plus"></i>  &nbsp; Add New Product</a> 
    <a href="{{url('admin-bin-products')}}" class="badge badge-pill btn-outline-danger px-3 py-2"><i class="fas fa-dumpster"></i> Recycle Bin</a>

</p>
@if (session('status'))
  <div class="alert alert-danger" role="alert">
      {{ session('status') }}
  </div>
  @endif
  
  

</div>

@if (session('warningstatus'))

<script>
            $(document).ready(function () {

        $('#centralModalWarning').modal('show');

        });
        </script>
@endif

<div class="container py-5">
    <p align="left">
        <i class="fas fa-file-powerpoint"></i> All Products
   </p>
     
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                           
                            <th>Name</th>
                            <th>Description</th>
                            <th>Images</th>
                            <th>Price</th>
                            <th>Show/Hide</th>
                            <th>Action</th>
    
                        </thead>
                        <tbody>
                            @foreach ($Products as $item)
                            <tr>
    
                                <td>{{$item->name}}</td>
                                <td>{{$item->description}}</td>
                             
    
                                <td>
                                <img src="{{asset('Uploads/Products/'.$item->image1)}}" width="50px;"  alt="{{$item->image1}}" />
                                <img src="{{asset('Uploads/Products/'.$item->image2)}}" width="50px;"  alt="{{$item->image2}}" />
                                <img src="{{asset('Uploads/Products/'.$item->image3)}}" width="50px;"  alt="{{$item->image3}}" />
                                <img src="{{asset('Uploads/Products/'.$item->image4)}}" width="50px;"  alt="{{$item->image4}}" />
    
    
                                </td>
                                <td>{{$item->price}}</td>
    
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
                                <a href="{{url('my-products-edit/'.$item->id)}}" class="badge badge-pill btn-primary px-3 py-2">Edit</a>
                                <a href="{{url('my-products-delete/'.$item->id)}}" class="badge badge-pill btn-danger px-3 py-2">Delete</a>
    
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
            {{ $Products->links()}}</p>
        </div>
</div>
   
<hr>

<div class="modal fade" id="centralModalWarning" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-danger" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <p class="heading lead">Warning</p>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <div class="text-center">
          <i class="fas fa-exclamation-circle fa-4x mb-3 animated rotateIn"></i>
          <h3 style="color: red"> <?php echo session('warningstatus')?></h3>
        
        </div>
      </div>

    </div>
    <!--/.Content-->
  </div>
</div>
@endsection