<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\FilterController;
use App\Http\Controllers\Admin\CouponsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\Front\AddressController;
use App\Http\Controllers\Front\OrderController;

use App\Models\Category;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* ------------------ Admin Routes ------------------ */

Route::prefix('admin')->group(function(){
    Route::get('/login',[AdminController::class,'index'])->name('login_form');
    Route::post('/login/owner',[AdminController::class,'login'])->name('admin.login');
    Route::get('/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard')->middleware('admin');
    Route::get('/logout',[AdminController::class,'logout'])->name('admin.logout')->middleware('admin');
    Route::get('/register',[AdminController::class,'registerform'])->name('register_form');
    Route::post('/register/create',[AdminController::class,'register'])->name('admin.register');

    /* ----- Update Admin Password ----- */
    Route::match(['get','post'],'update-admin-password',[AdminController::class,'updateAdminPassword']);
    Route::post('check-admin-password',[AdminController::class,'checkAdminPassword']);

    /* ----- Update Admin Details ----- */
    Route::match(['get','post'],'update-admin-details',[AdminController::class,'updateAdminDetails']);
    Route::get('/delete-admin-image/{id}',[AdminController::class,'deleteAdminImage'])->name('delete-admin-image');

    /* ----- Banners ----- */
    Route::get('/allbanners',[BannerController::class,'index'])->name('allbanners');
    Route::post('update-banner-status',[BannerController::class,'updateBannerStatus']);
    Route::get('/addbanner',[BannerController::class,'create'])->name('addbanner');
    Route::post('/storebanner',[BannerController::class,'store'])->name('storebanner');
    Route::get('/editbanner/{id}',[BannerController::class,'edit'])->name('editbanner');
    Route::post('/updatebanner',[BannerController::class,'update'])->name('updatebanner');
    Route::get('/deletebanner/{id}',[BannerController::class,'destroy'])->name('deletebanner');

    /* ----- Sections ----- */
    Route::get('/sections',[SectionController::class,'sections'])->name('sections');
    Route::post('update-section-status',[SectionController::class,'updateSectionStatus']);
    Route::get('/addsection',[SectionController::class,'create'])->name('addsection');
    Route::post('/storesection',[SectionController::class,'store'])->name('storesection');
    Route::get('/editsection/{id}',[SectionController::class,'edit'])->name('editsection');
    Route::post('/updatesection',[SectionController::class,'update'])->name('updatesection');
    Route::get('/deletesection/{id}',[SectionController::class,'destroy'])->name('deletesection');
    
    /* ----- Categories ----- */
    Route::get('/categories',[CategoryController::class,'categories'])->name('categories');  
    Route::post('update-category-status',[CategoryController::class,'updateCategoryStatus']);
    Route::get('/addcategory',[CategoryController::class,'create'])->name('addcategory');   
    Route::post('/storecategory',[CategoryController::class,'store'])->name('storecategory');
    Route::get('/editcategory/{id}',[CategoryController::class,'edit'])->name('editcategory');
    Route::post('/updatecategory',[CategoryController::class,'update'])->name('updatecategory');
    Route::get('/deletecategory/{id}',[CategoryController::class,'destroy'])->name('deletecategory');
    Route::get('/delete-category-image/{id}',[CategoryController::class,'deleteCategoryImage'])->name('delete-category-image');
    Route::get('/append-categories-level',[CategoryController::class,'appendCategoryLevel'])->name('append-categories-level');

    /* ----- Products ----- */
    Route::get('/products',[ProductController::class,'products'])->name('products');  
    Route::post('update-product-status',[ProductController::class,'updateProductStatus']);
    Route::get('/deleteproduct/{id}',[ProductController::class,'destroy'])->name('deleteproduct');
    Route::match(['GET','POST'],'add-edit-product/{id?}',[ProductController::class,'addEditProduct']);
    Route::get('/delete-product-image/{id}',[ProductController::class,'deleteProductImage'])->name('delete-product-image');
    Route::get('/delete-product-video/{id}',[ProductController::class,'deleteProductVideo'])->name('delete-product-video');

    /* ----- Attributes ----- */
    Route::match(['get','post'],'add-edit-attributes/{id}',[ProductController::class,'addAttributes']);
    Route::post('update-attribute-status',[ProductController::class,'updateAttributeStatus']);
    Route::get('/deleteattribute/{id}',[ProductController::class,'deteteAttribute'])->name('deleteattribute');
    Route::match(['get','post'],'edit-attributes/{id}',[ProductController::class,'editAttributes']);

     /* ----- Filters ----- */
    Route::get('/filters',[FilterController::class,'filters'])->name('filters');
    Route::get('/filters-values',[FilterController::class,'filtersvalues'])->name('filters-values');
    Route::post('update-filter-status',[FilterController::class,'updateFilterStatus'])->name('update-filter-status');
    Route::post('update-filter-value-status',[FilterController::class,'updateFilterValueStatus']);
    Route::match(['get','post'],'add-edit-filter/{id?}',[FilterController::class,'addEditFilter']);
    Route::match(['get','post'],'add-edit-filter-value/{id?}',[FilterController::class,'addEditFilterValue']);
    Route::get('/deletefilter/{id}',[FilterController::class,'destroy'])->name('deletefilter');
    Route::post('category-filters',[FilterController::class,'categoryFilters'])->name('category-filters');


    /* ----- Images ----- */
    Route::match(['get','post'],'add-images/{id}',[ProductController::class,'addImages']);
    Route::post('update-image-status',[ProductController::class,'updateImageStatus']);
    Route::get('/deleteimage/{id}',[ProductController::class,'deteteImage'])->name('deleteimage');

    /* ----- Coupons ----- */
    Route::get('/coupons',[CouponsController::class,'coupons'])->name('coupons');
    Route::post('update-coupon-status',[CouponsController::class,'updateCouponStatus']);
    Route::match(['GET','POST'],'add-edit-coupon/{id?}',[CouponsController::class,'addEditCoupon']);
    Route::get('/deletecoupon/{id}',[CouponsController::class,'destroy'])->name('deletecoupon');

    /* ----- Users ----- */
    Route::get('/users',[UserController::class,'users'])->name('users');
    Route::post('update-user-status',[UserController::class,'updateUserStatus']);

    /* ----- Orders ----- */
    Route::get('order',[OrdersController::class,'orders'])->name('order');
    Route::get('order/{id}',[OrdersController::class,'orderDetails']);
    Route::post('update-order-status',[OrdersController::class,'updateOrderStatus']);
    Route::post('update-order-item-status',[OrdersController::class,'updateOrderItemStatus']);

});

/* ------------------ End Admin Routes ------------------ */


/* ------------------ Seller Routes ------------------ */

Route::prefix('seller')->group(function(){
    
    Route::get('/login',[SellerController::class,'index'])->name('seller_login_form');
    Route::post('/login/owner',[SellerController::class,'login'])->name('seller.login');
    Route::get('/dashboard',[SellerController::class,'dashboard'])->name('seller.dashboard')->middleware('seller');
    Route::get('/logout',[SellerController::class,'logout'])->name('seller.logout')->middleware('seller');
    Route::get('/register',[SellerController::class,'registerform'])->name('seller_register_form');
    Route::post('/register/create',[SellerController::class,'register'])->name('seller.register');
});

/* ------------------ End Seller Routes ------------------ */

/* ------------------ Front Routes ------------------ */


// Route::controller(IndexController::class)->group(function(){
//     Route::get('/', 'index');
// }); 

Route::namespace('front')->group(function(){
    Route::get('/',[IndexController::class,'index']);

    /* ----- Listing Categories Routes ----- */
    $catUrls = Category::select('url')->where('status',1)->get()->pluck('url')->toArray();
    foreach ($catUrls as $key => $url) {
        Route::match(['get','post'],'/'.$url,[ProductsController::class,'listing']);
    }

    /* ----- Product Detail Page ----- */
    Route::get('/product/{id}',[ProductsController::class,'detail']);

    /* ----- Get Product Attribute Price ----- */
    Route::post('get-product-price',[ProductsController::class,'getProductPrice']);

    /* ----- Add to Cart ----- */
    Route::post('cart/add',[ProductsController::class,'cartAdd']);

    /* ----- Cart Route ----- */
    Route::get('/cart',[ProductsController::class,'cart']);
    
    /* ----- Update Cart Item Quantity ----- */
    Route::post('cart/update',[ProductsController::class,'cartUpdate']);

    /* ----- Delete Cart ----- */
    Route::post('cart/delete',[ProductsController::class,'cartDelete']);

    Route::group(['middleware'=>['auth']],function(){

        /* ----- Apply Code ----- */
        Route::post('/apply-coupon',[ProductsController::class,'applyCoupon']);

        /* ----- Checkout ----- */
        Route::match(['GET','POST'],'/checkout',[ProductsController::class,'checkout']);

        /* ----- Get Delivery Address ----- */
        Route::post('get-delivery-address',[AddressController::class,'getDeliveryAddress']);

        /* ----- Save Delivery Address ----- */
        Route::post('save-delivery-address',[AddressController::class,'saveDeliveryAddress']);

        /* ----- Remove Delivery Address ----- */
        Route::post('remove-delivery-address',[AddressController::class,'removeDeliveryAddress']);

        /* ----- Thanks ----- */
        Route::get('thanks',[ProductsController::class,'thanks']);

        /* ----- User Orders ----- */
        Route::get('orders/{id?}',[OrderController::class,'orders']);

    });

});


/* ------------------ End Front Routes ------------------ */


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
