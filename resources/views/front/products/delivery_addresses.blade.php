@if(count($deliveryAddresses)>0)
    <div class="create-ac-content bg-light-gray padding-20px-all">
        <fieldset>                
            <h2 class="login-title mb-3">Select a Delivery Addresses</h2>                                 
                @foreach($deliveryAddresses as $address)
                    <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                        <!-- <label for="input-lastname">Last Name <span class="required-f">*</span></label> -->
                        <input type="radio" id="address{{ $address['id'] }}" name="addressid" value="{{ $address['id'] }}">
                        <label class="control-label">{{ ucfirst($address['firstname']) }}&nbsp;{{ucfirst( $address['lastname']) }},{{ $address['address'] }},
                            {{ $address['city'] }},{{ $address['state'] }},{{ $address['country'] }}({{ $address['mobile'] }})
                        </label>
                        <a href="javascript:;" data-addressid="{{ $address['id'] }}" class="editAddress">Edit Address</a>&nbsp;&nbsp;|&nbsp;
                        <a href="javascript:;" data-addressid="{{ $address['id'] }}" class="removeAddress">Remove</a>
                    </div>                                        
                @endforeach
        </fieldset>
    </div>
@endif
    <div class="customer-box customer-coupon">
        <h3 class="font-15 xs-font-13"><i class="icon anm anm-gift-l"></i>  <a href="#delivery-address" class="text-white text-decoration-underline deliveryText" data-toggle="collapse">Add New Address</a></h3>
        <div id="delivery-address" class="collapse coupon-checkout-content">            
            <div class="create-ac-content bg-light-gray padding-20px-all"> 
                <p id="delivery-error"></p>                         
                <form id="addressAddEditForm" action="javascript:;" method="post">
                    @csrf                    
                    <fieldset>
                        <h2 class="login-title mb-3">Billing details</h2>
                        <input type="hidden" name="delivery_id" id="delivery_id">
                        <div class="row">
                            <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                <label for="delivery_firstname">First Name <span class="required-f">*</span></label>
                                <input name="delivery_firstname" value="" id="delivery_firstname" type="text">
                                <p id="delivery-delivery_firstname"></p>
                            </div>
                            <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                <label for="delivery_lastname">Last Name <span class="required-f">*</span></label>
                                <input name="delivery_lastname" value="" id="delivery_lastname" type="text">
                                <p id="delivery-delivery_lastname"></p>
                            </div>
                        </div>                        
                    </fieldset>
                    <fieldset>
                        <div class="row">                                    
                            <div class="form-group col-md-12 col-lg-12 col-xl-12 required">
                                <label for="delivery_address">Address <span class="required-f">*</span></label>
                                <input name="delivery_address" value="" id="delivery_address" type="text">
                                <p id="delivery-delivery_address"></p>
                            </div>
                        </div>
                        <div class="row">                                    
                            <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                <label for="delivery_city">City <span class="required-f">*</span></label>
                                <input name="delivery_city" value="" id="delivery_city" type="text">
                                <p id="delivery-delivery_city"></p>
                            </div>
                            <div class="form-group col-md-6 col-lg-6 col-xl-6">
                                <label for="delivery_state">State <span class="required-f">*</span></label>
                                <input name="delivery_state" value="" id="delivery_state" type="text">
                                <p id="delivery-delivery_state"></p>
                            </div>
                        </div>
                        <div class="row">                                   
                            <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                <label for="delivery_country">Country <span class="required-f">*</span></label>
                                <!-- <select name="delivery_country" id="delivery_country">
                                    <option value=""> --- Please Select --- </option>
                                    <option value="244">Aaland Islands</option>
                                    <option value="1">Afghanistan</option>
                                    <option value="2">Albania</option>
                                    <option value="3">Algeria</option>
                                    <option value="4">American Samoa</option>
                                    <option value="5">Andorra</option>
                                    <option value="6">Angola</option>
                                </select> -->                                
                                <input name="delivery_country" value="" id="delivery_country" type="text">
                                <p id="delivery-delivery_country"></p>
                            </div>
                            <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                <label for="delivery_pincode">Pin Code <span class="required-f">*</span></label>
                                <input name="delivery_pincode" value="" id="delivery_pincode" type="text">
                                <p id="delivery-delivery_pincode"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 col-lg-12 col-xl-12 required">
                                <label for="delivery_mobile">Mobile <span class="required-f">*</span></label>
                                <input name="delivery_mobile" value="" id="delivery_mobile" type="tel">
                                <p id="delivery-delivery_mobile"></p>
                            </div>
                        </div>                                
                    </fieldset>
                        <div class="order-button-payment">
                            <!-- <button class="btn" type="submit">Save</button> -->
                            <input type="submit" class="btn" value="save">
                        </div>
                    <fieldset>
                        <div class="row" style="margin-top:30px;">
                            <div class="form-group col-md-12 col-lg-12 col-xl-12">
                                <label for="input-company">Order Notes <span class="required-f">*</span></label>
                                <textarea class="form-control resize-both" rows="3"></textarea>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>        
        </div>
    </div>

                  
 