$(document).ready(function(){

    /*------ Update Admin Password ------*/
        $("#current_password").keyup(function(){
            var current_password = $("#current_password").val();
            // alert(current_password);
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/admin/check-admin-password',
                data:{current_password:current_password},
                success:function(resp){
                    if(resp=="false"){
                        $("#check_password").html("<font color='red'>Current Password is Incorrect!</font>");
                    }else if(resp=="true"){
                        $("#check_password").html("<font color='green'>Current Password is Correct!</font>");
                    }
                },error:function(){
                    alert('Error');
                }
            });
        })

    /*------ Update Banner Status ------*/
        $(document).on("click",".updateBannerStatus",function(){
            var status = $(this).children("i").attr("status");
            var banner_id = $(this).attr("banner_id");
        
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/admin/update-banner-status',
                data:{status:status,banner_id:banner_id},
                success:function(resp){
                    if(resp['status']==0)
                    {
                        $("#banner-"+banner_id).html("<i style='font-size: 18px; margin-left:15px;' class='far fa-bookmark' status='inactive' ></i>")
                    }
                    else if(resp['status']==1)
                    {
                        $("#banner-"+banner_id).html("<i style='font-size: 18px; margin-left:15px;' class='fas fa-bookmark' status='active' ></i>")
                    }
                    
                },error:function(){
                    alert("Error");
                }
                
            })

        });


    /*------ Update Section Status ------*/
        $(document).on("click",".updateSectionStatus",function(){
            var status = $(this).children("i").attr("status");
            var section_id = $(this).attr("section_id");

            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/admin/update-section-status',
                data:{status:status,section_id:section_id},
                success:function(resp){
                    if(resp['status']==0)
                    {
                        $("#section-"+section_id).html("<i style='font-size: 18px; margin-left:15px;' class='far fa-bookmark' status='inactive' ></i>")
                    }
                    else if(resp['status']==1)
                    {
                        $("#section-"+section_id).html("<i style='font-size: 18px; margin-left:15px;' class='fas fa-bookmark' status='active' ></i>")
                    }
                    
                },error:function(){
                    alert("Error");
                }
                
            })

        });

    /*------ Update Category Status ------*/
        $(document).on("click",".updateCategoryStatus",function(){
            var status = $(this).children("i").attr("status");
            var category_id = $(this).attr("category_id");
        
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/admin/update-category-status',
                data:{status:status,category_id:category_id},
                success:function(resp){
                    if(resp['status']==0)
                    {
                        $("#category-"+category_id).html("<i style='font-size: 18px; margin-left:15px;' class='far fa-bookmark' status='inactive' ></i>")
                    }
                    else if(resp['status']==1)
                    {
                        $("#category-"+category_id).html("<i style='font-size: 18px; margin-left:15px;' class='fas fa-bookmark' status='active' ></i>")
                    }
                    
                },error:function(){
                    alert("Error");
                }
                
            })

        });

    /*------ Update Product Status ------*/
        $(document).on("click",".updateproductStatus",function(){
            var status = $(this).children("i").attr("status");
            var product_id = $(this).attr("product_id");
        
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/admin/update-product-status',
                data:{status:status,product_id:product_id},
                success:function(resp){
                    if(resp['status']==0)
                    {
                        $("#product-"+product_id).html("<i style='font-size: 18px; margin-left:15px;' class='far fa-bookmark' status='inactive' ></i>")
                    }
                    else if(resp['status']==1)
                    {
                        $("#product-"+product_id).html("<i style='font-size: 18px; margin-left:15px;' class='fas fa-bookmark' status='active' ></i>")
                    }
                    
                },error:function(){
                    alert("Error");
                }
                
            })

        });

    /*------ Update Attributes Status ------*/
        $(document).on("click",".updateAttributesStatus",function(){
            var status = $(this).children("i").attr("status");
            var attribute_id = $(this).attr("attribute_id");
        
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/admin/update-attribute-status',
                data:{status:status,attribute_id:attribute_id},
                success:function(resp){
                    if(resp['status']==0)
                    {
                        $("#attribute-"+attribute_id).html("<i style='font-size: 18px; margin-left:15px;' class='far fa-bookmark' status='inactive' ></i>")
                    }
                    else if(resp['status']==1)
                    {
                        $("#attribute-"+attribute_id).html("<i style='font-size: 18px; margin-left:15px;' class='fas fa-bookmark' status='active' ></i>")
                    }
                    
                },error:function(){
                    alert("Error");
                }
                
            })

        });

    /*------ Update Filter Status ------*/
        $(document).on("click",".updateFilterStatus",function(){
            var status = $(this).children("i").attr("status");
            var filter_id = $(this).attr("filter_id");
        
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/admin/update-filter-status',
                data:{status:status,filter_id:filter_id},
                success:function(resp){
                    if(resp['status']==0)
                    {
                        $("#filter-"+filter_id).html("<i style='font-size: 18px; margin-left:15px;' class='far fa-bookmark' status='inactive' ></i>")
                    }
                    else if(resp['status']==1)
                    {
                        $("#filter-"+filter_id).html("<i style='font-size: 18px; margin-left:15px;' class='fas fa-bookmark' status='active' ></i>")
                    }
                    
                },error:function(){
                    alert("Error");
                }
                
            })

        });

    /*------ Update Filter Value Status ------*/
        $(document).on("click",".updateFilterValueStatus",function(){
            var status = $(this).children("i").attr("status");
            var filter_id = $(this).attr("filter_id");
        
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/admin/update-filter-value-status',
                data:{status:status,filter_id:filter_id},
                success:function(resp){
                    if(resp['status']==0)
                    {
                        $("#filter-"+filter_id).html("<i style='font-size: 18px; margin-left:15px;' class='far fa-bookmark' status='inactive' ></i>")
                    }
                    else if(resp['status']==1)
                    {
                        $("#filter-"+filter_id).html("<i style='font-size: 18px; margin-left:15px;' class='fas fa-bookmark' status='active' ></i>")
                    }
                    
                },error:function(){
                    alert("Error");
                }
                
            })

        });

    /*------ Update Image Status ------*/
        $(document).on("click",".updateImageStatus",function(){
            var status = $(this).children("i").attr("status");
            var image_id = $(this).attr("image_id");
        
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/admin/update-image-status',
                data:{status:status,image_id:image_id},
                success:function(resp){
                    if(resp['status']==0)
                    {
                        $("#image-"+image_id).html("<i style='font-size: 18px; margin-left:15px;' class='far fa-bookmark' status='inactive' ></i>")
                    }
                    else if(resp['status']==1)
                    {
                        $("#image-"+image_id).html("<i style='font-size: 18px; margin-left:15px;' class='fas fa-bookmark' status='active' ></i>")
                    }
                    
                },error:function(){
                    alert("Error");
                }
                
            })

        });

    /*------ Update Coupon Status ------*/
        $(document).on("click",".updateCouponStatus",function(){
            var status = $(this).children("i").attr("status");
            var coupon_id = $(this).attr("coupon_id");
        
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/admin/update-coupon-status',
                data:{status:status,coupon_id:coupon_id},
                success:function(resp){
                    if(resp['status']==0)
                    {
                        $("#coupon-"+coupon_id).html("<i style='font-size: 18px; margin-left:15px;' class='far fa-bookmark' status='inactive' ></i>")
                    }
                    else if(resp['status']==1)
                    {
                        $("#coupon-"+coupon_id).html("<i style='font-size: 18px; margin-left:15px;' class='fas fa-bookmark' status='active' ></i>")
                    }
                    
                },error:function(){
                    alert("Error");
                }
                
            })

        });  

    /*------ Update User Status ------*/
        $(document).on("click",".updateUserStatus",function(){
            var status = $(this).children("i").attr("status");
            var user_id = $(this).attr("user_id");
        
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/admin/update-user-status',
                data:{status:status,user_id:user_id},
                success:function(resp){
                    if(resp['status']==0)
                    {
                        $("#user-"+user_id).html("<i style='font-size: 18px; margin-left:15px;' class='far fa-bookmark' status='inactive' ></i>")
                    }
                    else if(resp['status']==1)
                    {
                        $("#user-"+user_id).html("<i style='font-size: 18px; margin-left:15px;' class='fas fa-bookmark' status='active' ></i>")
                    }
                    
                },error:function(){
                    alert("Error");
                }
                
            })

        });  

    /*------ call datatable class------*/

        $('#pagination').DataTable({
            pagingType: 'full_numbers',
        });

    /*------ Add remove Attributes ------*/

        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div><div style="height:10px;"></div><input type="text" name="size[]" placeholder="Size" style="width: 120px;" />&nbsp;<input type="text" name="sku[]" placeholder="SKU" style="width: 120px;" />&nbsp;<input type="text" name="price[]" placeholder="Price" style="width: 120px;" />&nbsp;<input type="text" name="stock[]" placeholder="Stock" style="width: 120px;" />&nbsp;<a href="javascript:void(0);" class="remove_button">Remove</a></div>'; //New input field html 
        var x = 1; //Initial field counter is 1
        
        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){ 
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });
        
        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });

    /*------ Show Filters on selection of Category ------*/
        $("#category_id").on('change',function(){
            var category_id = $(this).val();

            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'category-filters',
                data:{category_id:category_id},
                success:function(resp){
                    $(".loadFilters").html(resp.view);
                    
                }

            });
        });
    /*------ Show/Hide Coupon field for Manual/Automatic ------*/
        $("#ManualCoupon").click(function(){
            $("#couponField").show();
        });

        $("#AutomaticCoupon").click(function(){
            $("#couponField").hide();
        });
    
});
