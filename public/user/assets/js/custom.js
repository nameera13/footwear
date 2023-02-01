$(document).ready(function(){
    $("#getPrice").change(function(){
        var size = $(this).val();
        var product_id = $(this).attr("product_id");
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'/get-product-price',
            type:'Post',
            data:{size:size,product_id:product_id},
            success:function(resp){
                // alert(resp['final_price']);
                if(resp['discount']>0){
                    $(".getAttributePrice").html("<s id='ComparePrice-product-template'><span class='money'>Rs."+resp['product_price']+"</span></s><span class='product-price__price product-price__price-product-template product-price__sale product-price__sale--single'><span id='ProductPrice-product-template'><span class='money'>Rs."+ resp['final_price']+"</span></span></span>");
                }else{                    
                    $(".getAttributePrice").html("<span class='product-price__price product-price__price-product-template product-price__sale product-price__sale--single'><span id='ProductPrice-product-template'><span class='money'>Rs."+$resp['final_price']+"</span></span></span>");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    
    /*------ Update Cart Item Quantity ------*/
    $(document).on('click','.UpdateCartItem',function(){
        if($(this).hasClass('qtyBtn plus')){
            // Get Quantity
            var quantity = $(this).data('qty');
            // increase the quantity by 1
            new_qty = parseInt(quantity) + 1;
            
        }
        if($(this).hasClass('qtyBtn minus')){
            // Get Quantity
            var quantity = $(this).data('qty');
            // check qty is atleast 1 
            if(quantity<=1){
                alert("Item quantity must be 1 or greater!");
                return false;
            }
            // increase the quantity by 1
            new_qty = parseInt(quantity) - 1;
            
        }
        var cartid = $(this).data('cartid');
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{cartid:cartid,qty:new_qty},
            url:'/cart/update',
            type:'post',
            success:function(resp){
                $(".totalCartItems").html(resp.totalCartItems);
                if(resp.status==false){
                    alert(resp.message);
                }   
                $("#appendCartItems").html(resp.view);
                $("#appendHeaderCartItems").html(resp.headerview);
            },error:function(){
                alert("Error");
            }
        });
    });
    

    /*------ Delete Cart Item Quantity ------*/
    $(document).on('click','.deleteCartItem',function(){
        var cartid = $(this).data('cartid');
        var result = confirm("Are you sure to delete this Cart Item?");
        if(result){
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{cartid:cartid},
                url:'/cart/delete',
                type:'post',
                success:function(resp){
                    $(".totalCartItems").html(resp.totalCartItems);                   
                    $("#appendCartItems").html(resp.view);
                    $("#appendHeaderCartItems").html(resp.headerview);
                },error:function(){
                    alert("Error");
                }
            });
        }
    });


    /*------ Apply Coupon ------*/
    $("#ApplyCoupon").submit(function(){
        var user = $(this).attr("user");
        /*alert(user);*/
        if(user==1){
            // do nothing

        }else{
            alert("Please Login to Apply Coupon!");
            return false;
        }
        var code = $("#code").val();
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            data:{code:code},
            url:'/apply-coupon',
            success:function(resp){
                if(resp.message!=""){
                    alert(resp.message);
                }
                $(".totalCartItems").html(resp.totalCartItems);                   
                $("#appendCartItems").html(resp.view);
                $("#appendHeaderCartItems").html(resp.headerview);
                if(resp.couponAmount>0){
                    $(".couponAmount").text("Rs."+resp.couponAmount);
                }else{
                    $(".couponAmount").text("Rs.0");
                }
                if(resp.grandTotal>0){
                    $(".grandTotal").text("Rs."+resp.grandTotal);
                }
            },error:function(){
                alert("Error");
            }
           
        });
    });


    /*------ Edit Delivery Address ------*/
    $(document).on('click','.editAddress',function(){
        var addressid = $(this).data("addressid");
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{addressid:addressid},
            url:'/get-delivery-address',
            type:'post',
            success:function(resp){
                $("#delivery-address").removeClass("collapse");
                $(".deliveryText").text("Edit Delivery Address");
                $('[name=delivery_id]').val(resp.address['id']);
                $('[name=delivery_firstname]').val(resp.address['firstname']);
                $('[name=delivery_lastname]').val(resp.address['lastname']);
                $('[name=delivery_address]').val(resp.address['address']);
                $('[name=delivery_city]').val(resp.address['city']);
                $('[name=delivery_state]').val(resp.address['state']);
                $('[name=delivery_country]').val(resp.address['country']);
                $('[name=delivery_pincode]').val(resp.address['pincode']);
                $('[name=delivery_mobile]').val(resp.address['mobile']);
            },error:function(){
                alert("Error");
            }
        });
    });


    /*------ Save Delivery Address ------*/
    $(document).on('submit',"#addressAddEditForm",function(){
        var formdata = $("#addressAddEditForm").serialize();
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },            
            url:'/save-delivery-address',
            type:'post',
            data:formdata,
            success:function(resp){                
                // alert(data);
                if(resp.type=="error"){
                    $.each(resp.errors,function(i,error){
                        $("#delivery-"+i).attr('style','color:red');
                        $("#delivery-"+i).html(error);
                    setTimeout(function(){
                        $("#delivery-"+i).css({
                            'display':'none'
                        });
                    },9000);
                    });
                }else{
                    $("#deliveryAddresses").html(resp.view);
                }
                
            },error:function(){
                alert("Error"); 
            }
        });
    });


    /*------ Remove Delivery Address ------*/
    $(document).on('click','.removeAddress',function(){
        if(confirm("Are you sure to remove this?")){
            var addressid = $(this).data("addressid");
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },            
                url:'/remove-delivery-address',
                type:'post',
                data:{addressid:addressid},
                success:function(resp){
                    $("#deliveryAddresses").html(resp.view);
                },error:function(){
                    alert("Error");
                }
            });
        }
    });

});




function get_filter(class_name){
    var filter = [];
    $('.'+class_name+':checked').each(function(){
        filter.push($(this).val());
    });
    return filter;
}