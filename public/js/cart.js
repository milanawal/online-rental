 
/* Add to Cart, Quantity_Modify, Delete_Cart, Clear_All_Cart_Data Starts Here*/
$(document).ready(function () {

    $('.add-to-cart-btn').click(function (e) {
        console.log('sdfdsf');
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#showloading').html('<div id="spinner"  align="center"><div class="spinner-border fast"  style="width: 3rem; height: 3rem;color:black;"  role="status"><span class="sr-only">Loading...</span></div></div>');
        ;
        var product_id = $(this).closest('.product_data').find('.product_id').val();
        var quantity = $(this).closest('.product_data').find('.quantity').val();
        var days = $(this).closest('.product_data').find('.days').val();
        console.log(days);

        $.ajax({
            url: "/add-to-cart",
            method: "POST",
            data: {
                'quantity': quantity,
                'product_id': product_id,
                'days': days,
            },
            success: function (response) {
                //window.alert(response.quantity);
                alertify.set('notifier','position','top-right');
                console.log(response);
                if(response.quantity!=undefined)
                {
                    $('#msg_diverr2').show();
                    $('#triggererrors').show();
                    $('#triggererrors').append(response.quantity);
                }else if(response.start_date!=undefined){
                    $('#msg_diverr2').show();
                    $('#triggererrors').show();
                    $('#triggererrors').append(response.start_date);
                }else if(response.end_date!=undefined){
                    $('#msg_diverr2').show();
                    $('#triggererrors').show();
                    $('#triggererrors').append(response.end_date);
                }
                else
                {
                     alertify.success(response.status);
                     window.location.replace("/cart");
                }
              
                $('#showloading').html('');
                setTimeout(function()
                {
                  
                    $('#triggererrors').html('');
                    $('#msg_diverr2').hide();

                },3000);
             
              
               
               
            },error:function (response) {
                console.log(response);
            }
        });
    });

    $('.book-now-btn').click(function (e) {
        
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#showloading').html('<div id="spinner"  align="center"><div class="spinner-border fast"  style="width: 3rem; height: 3rem;color:black;"  role="status"><span class="sr-only">Loading...</span></div></div>');

        var product_id = $(this).closest('.product_data').find('.product_id').val();
        var quantity = $(this).closest('.product_data').find('.quantity').val();
        var start_date = $(this).closest('.product_data').find('.start_date').val();
        var end_date = $(this).closest('.product_data').find('.end_date').val();

        $.ajax({
            url: "/add-to-cart",
            method: "POST",
            data: {
                'quantity': quantity,
                'product_id': product_id,
                'start_date': start_date,
                'end_date': end_date,
            },
            success: function (response) {
                //window.alert(response.quantity);
                alertify.set('notifier','position','top-right');
                    
                    console.log(response);
                if(response.quantity!=undefined)
                {
                    $('#msg_diverr2').show();
                    $('#triggererrors').show();
                    $('#triggererrors').append(response.quantity);
                }else if(response.start_date!=undefined){
                    $('#msg_diverr2').show();
                    $('#triggererrors').show();
                    $('#triggererrors').append(response.start_date);
                }else if(response.end_date!=undefined){
                    $('#msg_diverr2').show();
                    $('#triggererrors').show();
                    $('#triggererrors').append(response.end_date);
                }
                else
                {
                     alertify.success(response.status);
                     window.location.replace("/confirm-rental");
                }
              
                $('#showloading').html('');
                setTimeout(function()
                {
                  
                    $('#triggererrors').html('');
                    $('#msg_diverr2').hide();

                },3000);
             
              
               
               
            },
        });
    });

    /* Modify the Quantity of an item starts here */
        $('.modify_quantity').click(function (e) {
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var product_id = $(this).closest('.cart-product-quantity').find('.product_id').val();
            var quantity = $(this).closest('.cart-product-quantity').find('.quantity').val();

            $.ajax({
                url: "/modify_quantity",
                method: "POST",
                data: {
                    'quantity': quantity,
                    'product_id': product_id,
                },
                success: function (response) {
                     
                //    window.alert(response.quantity);
                    alertify.set('notifier','position','top-right');
                    alertify.success(response.status);
                    location.reload(true);
                  //  alertify.success(response.quantity);
                   
                },
            });
        });

    /* Modify the Quantity of an item Ends  here */
        

    
});
  
/* Add to Cart, Quantity_Modify, Delete_Cart, Clear_All_Cart_Data Ends Here*/
 