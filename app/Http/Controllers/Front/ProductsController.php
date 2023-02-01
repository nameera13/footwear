<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsFilter;
use App\Models\ProductsAttributes;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\User;
use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\OrdersProduct;
use Session;
use DB;
use Auth;


class ProductsController extends Controller
{
    /* -------------- Listing -------------- */
    public function listing(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();            
           /* echo "<pre>"; print_r($data); die;*/
            $url = $data['url'];
            $_GET['sort'] = $data['sort'];
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if($categoryCount>0){
                /* Get Category Details */
                $categoryDetails = Category::categoryDetails($url);
                $categoryProducts = Product::whereIn('category_id',$categoryDetails['catIds'])->where('status',1);
                
                /* checking for Dynamic Filters */

                $productFilters = ProductsFilter::productFilters();
                foreach ($productFilters as $key => $filter) {
                    // if filter is selected
                    if(isset($filter['filter_column']) && isset($data[$filter['filter_column']]) && !empty($filter['filter_column']) && !empty($data[$filter['filter_column']])){
                        $categoryProducts->whereIn($filter['filter_column'],$data[$filter['filter_column']]);
                    }
                }                
                
                /* checking for sort */
                if(isset($_GET['sort']) && !empty($_GET['sort'])){
                    if($_GET['sort']=="product_latest"){
                        $categoryProducts->orderby('products.id','Desc');
                    }else if($_GET['sort']=="price_lowest"){
                        $categoryProducts->orderby('product_price','Asc');
                    }else if($_GET['sort']=="price_highest"){
                        $categoryProducts->orderby('product_price','Desc');
                    }else if($_GET['sort']=="name_a_z"){
                        $categoryProducts->orderby('product_name','Asc');
                    }else if($_GET['sort']=="name_z_a"){
                        $categoryProducts->orderby('product_name','Desc');
                    }
                }

                /* checking for Size */
                if(isset($data['size']) && !empty($data['size'])){
                    $productIds = ProductsAttributes::select('product_id')->whereIn('size',$data['size'])->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                } 
                
                /* checking for Color */
                if(isset($data['color']) && !empty($data['color'])){
                    $productIds = Product::select('id')->whereIn('product_color',$data['color'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                } 

                /* checking for price */
                // if(isset($data['price']) && !empty($data['price'])){
                //    $implodePrices = implode('-',$data['price']);
                //    $explodePrices = explode('-',$implodePrices);
                //    $min = reset($explodePrices);
                //    $max = end($explodePrices);

                //    $productIds = Product::select('id')->whereBetween('product_price',[$min,$max])->pluck('id')->toArray();
                //    $categoryProducts->whereIn('products.id',$productIds);

                // } 

                $productIds = array();
                if(isset($data['price']) && !empty($data['price'])){
                    foreach($data['price'] as $key => $price){
                        $priceArr = explode("-",$price);
                        if(isset($priceArr[0]) && isset($priceArr[1])){
                            $productIds[] = Product::select('id')->whereBetween('product_price',[$priceArr[0],$priceArr[1]])->pluck('id')->toArray();

                        }

                    }
                    $productIds = array_unique(array_flatten($productIds));
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                $categoryProducts =  $categoryProducts->paginate(3);
                // echo "Category exists"; die;
                return view('front.products.ajax_products_listing')->with(compact('categoryDetails','categoryProducts','url'));
            }else{
                abort(404);
            }

        }else{
            $url = Route::getFacadeRoot()->current()->uri();
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if($categoryCount>0){
                /* Get Category Details */
                $categoryDetails = Category::categoryDetails($url);
                $categoryProducts = Product::whereIn('category_id',$categoryDetails['catIds'])->where('status',1);
                
                /* checking for sort */
                if(isset($_GET['sort']) && !empty($_GET['sort'])){
                    if($_GET['sort']=="product_latest"){
                        $categoryProducts->orderby('products.id','Desc');
                    }else if($_GET['sort']=="price_lowest"){
                        $categoryProducts->orderby('product_price','Asc');
                    }else if($_GET['sort']=="price_highest"){
                        $categoryProducts->orderby('product_price','Desc');
                    }else if($_GET['sort']=="name_a_z"){
                        $categoryProducts->orderby('product_name','Asc');
                    }else if($_GET['sort']=="name_z_a"){
                        $categoryProducts->orderby('product_name','Desc');
                    }
                }

                                                                
                $categoryProducts =  $categoryProducts->paginate(3);
                // echo "Category exists"; die;
                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','url'));
            }else{
                abort(404);
            }
        }

        
    }

    /* -------------- Detail -------------- */
    public function detail($id)
    {
        $productDetails = Product::with(['section','category','attributes'=>function($query){
            $query->where('stock','>',0)->where('status',1);
        },'images'])->find($id)->toArray();
        $categoryDetails = Category::CategoryDetails($productDetails['category']['url']);        

        /* Set Session for Recently Viewd Products */
        if(empty(Session::get('session_id'))){
            $session_id = md5(uniqid(rand(),true));
        }else{ 
            $session_id = Session::get('session_id');   
        }

        Session::put('session_id',$session_id);

        /* Insert Product in table if not already exists */
        $countRecentlyViewedProducts = DB::table('recently_viewed_products')->where(['product_id'=>$id,'session_id'=>$session_id])->count();
        if($countRecentlyViewedProducts==0){
            DB::table('recently_viewed_products')->insert(['product_id'=>$id,'session_id'=>$session_id]);

        } 

        /* Get Recently Viewed Products Ids */
        $recentProductIds = DB::table('recently_viewed_products')->select('product_id')->where('product_id','!=',$id)->where('session_id',$session_id)->inRandomOrder()->get()->take(6)->pluck('product_id'); 

        $recentlyViewedProducts = Product::with('category')->whereIn('id',$recentProductIds)->get()->toArray();
        // dd($recentlyViewedProducts);

        /* Get Group Products (Product Colors) */
        $groupProducts = array();
        if(!empty($productDetails['group_code'])){
            $groupProducts = Product::select('id','product_image')->where('id','!=',$id)->where(['group_code'=>$productDetails['group_code'],'status'=>1])->get()->toArray();
            // dd($groupProducts); 

        }
        
        $totalStock = ProductsAttributes::where('product_id',$id)->sum('stock');
        // dd($productDetails);

        
        return view('front.products.detail')->with(compact('productDetails','categoryDetails','totalStock','groupProducts','recentlyViewedProducts'));
    }

    /* --------------  Get Product Price -------------- */
    public function getProductPrice(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            $getDiscountAttributePrice = Product::getDiscountAttributePrice($data['product_id'],$data['size']);
            
            // echo"<pre>"; print_r($getDiscountAttributePrice); die;
            return $getDiscountAttributePrice;
        }
    }

    /* -------------- Cart Add -------------- */
    public function cartAdd(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
           /* echo "<pre>"; print_r($data); die;*/

            /* check Product Stock is available or not */
            $getProductStock = ProductsAttributes::isStockAvailable($data['product_id'],$data['size']);
            if($getProductStock<$data['quantity']){
                return redirect()->back()->with('error_message','Required  Quantity is not available');
            }

            /* Generate Session Id if not exists */
            $session_id = Session::get('session_id');
            if(empty($session_id)){
                $session_id = Session::getId();
                Session::put('session_id',$session_id);
            }

            /* Check Product if already exists in the User Cart */
            if(Auth::check()){
                /* User is Logged in */
                $user_id = Auth::user()->id;
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'user_id'=>$user_id])->count();


            }else{
                /* User is not Logged in */
                $user_id = 0;
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'session_id'=>$session_id])->count();
                
            }

            /* Save Product in Carts Table */
            $item = new Cart;
            $item->session_id = $session_id;
            $item->user_id = $user_id;
            $item->product_id = $data['product_id'];
            $item->size = $data['size'];
            $item->quantity = $data['quantity'];
            $item->save();

            return redirect()->back()->with('message','Product has been added in Cart! <a style="text-decoration:underline !important" href="/cart">View Cart</a>');
        }
    }

    /* -------------- Cart -------------- */
    public function cart()
    {
        $getCartItems = Cart::getCartItems();
        // dd($getCartItems);
        return view('front.products.cart')->with(compact('getCartItems'));
    }

    /* -------------- Cart Update -------------- */
    public function cartUpdate(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
           /* echo "<pre>"; print_r($data); die;*/

            /* Get Cart Details */
            $cartDetails = Cart::find($data['cartid']);

            /* Get Available Product Stock */
            $availableStock = ProductsAttributes::select('stock')->where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['size']])->first()->toArray();
            
            // echo "<pre>"; print_r($availableStock); die;

            /* Check if desired Stock from user is available */
            if($data['qty']>$availableStock['stock']){
                $getCartItems = Cart::getCartItems();
                return response()->json([
                    'status'=>false,
                    'message'=>'Product Stock is not available',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                    'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                ]);
            }

            /* Check if product size is available */
            $availableSize = ProductsAttributes::where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['size'],'status'=>1])->count();
            if($availableSize==0){
                $getCartItems = Cart::getCartItems();
                return response()->json([
                    'status'=>false,
                    'message'=>'Product Size is not available. Please remove this Product and choose another one!',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                    'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                ]);
            }

            /* Update Qty */
            Cart::where('id',$data['cartid'])->update(['quantity'=>$data['qty']]);
            $getCartItems = Cart::getCartItems();
            $totalCartItems = totalCartItems();
            Session::forget('couponAmount');
            Session::forget('couponCode');
            return response()->json([
                'status'=>true,
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
            ]);
        }
    }

    /* -------------- Cart Delete -------------- */
    public function cartDelete(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            Session::forget('couponAmount');
            Session::forget('couponCode');
           /* echo "<pre>"; print_r($data); die;*/
            Cart::where('id',$data['cartid'])->delete();
            $getCartItems = Cart::getCartItems();
            $totalCartItems = totalCartItems();
            return response()->json([  
                'totalCartItems'=>$totalCartItems,             
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
            ]);
        }
    }

    /* -------------- Apply Coupon -------------- */
    public function applyCoupon(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            Session::forget('couponAmount');
            Session::forget('couponCode');
           $getCartItems = Cart::getCartItems();
            /* echo "<pre>"; print_r($getCartItems); die; */
           $totalCartItems = totalCartItems();
           $couponCount = Coupon::where('coupon_code',$data['code'])->count();
           if($couponCount==0){
                return response()->json([  
                    'status'=>false,
                    'totalCartItems'=>$totalCartItems,  
                    'message'=>'The Coupon is not Valid!',           
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                    'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                ]);
           }else{
                /* "Check for other Coupon Conditions" */
                
                /* Get Coupon Details */
                $couponDetails = Coupon::where('coupon_code',$data['code'])->first();

                /* Check if Coupon is Active */
                if($couponDetails->status==0){
                    $message = "The Coupon is not active";
                }

                /* Check if Coupon is expired */
                $expiry_date = $couponDetails->expiry_date;
                $current_date = date('Y-m-d');
                if($expiry_date < $current_date){
                    $message = "The Coupon is expired!";
                }

                /* Check if Coupon is from selected categories */
                /*Get all selected categories from coupon */
                $catArr = explode(",",$couponDetails->categories);

                /* Check if any cart item not being to coupon category*/
                $total_amount = 0;
                foreach ($getCartItems as $key => $item) {
                    if(!in_array($item['product']['category_id'],$catArr)){
                        $message = "This coupon code is not for one of the selected products.";
                    }
                    $attrPrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                    $total_amount = $total_amount + ($attrPrice['final_price']*$item['quantity']);
                }
                /* Check if coupon is from selected users */
                /* Get all selected users from coupon and convert to array */                
                if(isset($categoryDetails->users) && !empty($couponDetails->users)){    
                    $usersArr = explode(",",$couponDetails->users);

                    if(count($usersArr)){
                        /* Get User Id's of all selected users */
                        foreach ($usersArr as $key => $user) {
                            $getUserId = User::select('id')->where('email',$user)->first()->toArray();
                            $usersId[] = $getUserId['id'];
                        }
                        /* Check if any Cart item not belong to coupon user */
                        foreach ($getCartItems as $item) {                           
                            if(!in_array($item['user_id'],$usersId)){
                                $message = "This coupon code is not for you. Try with valid coupon code!";
                            }                            
                        }
                    }
                }
                
                /* if error message is there */
                if(isset($message)){
                    return response()->json([  
                        'status'=>false,
                        'totalCartItems'=>$totalCartItems,  
                        'message'=>$message,           
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                        'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                    ]);
                }else{
                    /* Coupon code is Correct */

                    /* Check if Coupon Amount type is Fixed or Percentage */
                    if($couponDetails->amount_type=="Fixed"){
                        $couponAmount = $couponDetails->amount;
                    }else{
                        $couponAmount = $total_amount * ($couponDetails->amount/100);
                    }

                    $grandTotal = $total_amount - $couponAmount;


                    /* Add Coupon Code & Amount in Session Variable */
                    Session::put('couponAmount',$couponAmount);
                    Session::put('couponCode',$data['code']);

                    $message= "Coupon Code successfully applied. You are availing discount!";

                    return response()->json([  
                        'status'=>true,
                        'totalCartItems'=>$totalCartItems, 
                        'couponAmount'=>$couponAmount, 
                        'grandTotal'=>$grandTotal,    
                        'message'=>$message,           
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                        'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                    ]);
                }
           }

        }
    }

    /* -------------- Checkout -------------- */
    public function checkout(Request $request)
    {
        $deliveryAddresses = DeliveryAddress::deliveryAddresses();
        $getCartItems = Cart::getCartItems();

        if(count($getCartItems)==0){
            $message = "Shopping Cart is empty! Please add products to checkout";
            return redirect('cart')->with('error_message',$message);
        }

        if($request->isMethod('post')){
            $data = $request->all();

            /* Delivery Address Validation */
            if(empty($data['addressid'])){
                $message = "Please select Delivery Address!";
                return redirect()->back()->with('error_message',$message);
            }

            /* Payment Method Validation */
            if(empty($data['payment_gateway'])){
                $message = "Please select Payment Method!";
                return redirect()->back()->with('error_message',$message);
            }

            /* Payment Method Validation */
            if(empty($data['accept'])){
                $message = "Please agree to T&C!";
                return redirect()->back()->with('error_message',$message);
            }

            $deliveryAddress = DeliveryAddress::where('id',$data['addressid'])->first()->toArray();

            /* Set Payment Method as COD if Cod is selected from user otherwise set as prepaid  */
            if($data['payment_gateway']=="COD"){
                $payment_method = "COD";
                $order_status = "New";
            }else{
                $payment_method = "Prepaid";
                $order_status = "Pending";
            }

            // DB::beginTransactions();

            /* Calculate Grand TOtal */
            $total_price = 0;
            foreach($getCartItems as $item){
                $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']); 
                $total_price = $total_price + ($getDiscountAttributePrice['final_price'] * $item['quantity']);                                        
            }   

            /* Calculate Shippng Charges */
            $shipping_charges = 0;

            /* Calculate Grand Total */
            $grand_total = $total_price + $shipping_charges - Session::get('couponAmount');

            /* Insert Grand Total in Session Variable */
            Session::put('grand_total',$grand_total);

            /* Insert Order Details */
            $order = new Order;
            $order->user_id = Auth::user()->id;
            $order->firstname = $deliveryAddress['firstname'];
            $order->lastname = $deliveryAddress['lastname'];
            $order->address = $deliveryAddress['address'];
            $order->city = $deliveryAddress['city'];
            $order->state = $deliveryAddress['state'];
            $order->country = $deliveryAddress['country'];
            $order->pincode = $deliveryAddress['pincode'];
            $order->mobile = $deliveryAddress['mobile'];
            $order->email = Auth::user()->email;
            $order->shipping_charges = $shipping_charges;
            $order->coupon_code = Session::get('couponCode');
            $order->coupon_amount = Session::get('couponAmount');
            $order->order_status = $order_status;
            $order->payment_method = $payment_method;
            $order->payment_gateway = $data['payment_gateway'];
            $order->grand_total = $grand_total;
            $order->save();
            $order_id = DB::getPdo()->lastInsertId();

            foreach($getCartItems as $item){
                $cartItem = new OrdersProduct;
                $cartItem->order_id = $order_id;
                $cartItem->user_id = Auth::user()->id;
                $getProductDetails = Product::select('product_code','product_name','product_color')->where('id',$item['product_id'])->first()->toArray();

                // dd($getProductDetails);
                $cartItem->product_id = $item['product_id'];
                $cartItem->product_code = $getProductDetails['product_code'];
                $cartItem->product_name = $getProductDetails['product_name'];
                $cartItem->product_color = $getProductDetails['product_color'];
                $cartItem->product_size = $item['size'];
                $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                $cartItem->product_price = $getDiscountAttributePrice['final_price'];
                $cartItem->product_qty = $item['quantity'];
                $cartItem->save();
            }

            /* Insert Order Id in Session Variable */
            Session::put('order_id',$order_id);

            DB::commit();
            
            return redirect('thanks');
        }
        
        return view('front.products.checkout')->with(compact('deliveryAddresses','getCartItems'));
    }


    /* -------------- Thanks -------------- */
    public function thanks()
    {
        if(Session::has('order_id')){
            /* Empty the cart */
            Cart::where('user_id',Auth::user()->id)->delete();
            return view('front.products.thanks');
        }else{
            return redirect('cart');
        }
    }
}
