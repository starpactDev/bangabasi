<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OTPController;
use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\SellerMiddleware;
use App\Http\Middleware\UserAuthMiddleware;
use App\Http\Controllers\RazorpayController;
use App\Http\Middleware\SuperUserMiddleware;


use App\Http\Middleware\AdminCheckMiddleware;
use App\Http\Controllers\InstantBuyController;
use App\Http\Controllers\Frontend\BlogController;

use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\SaleController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Middleware\CustomRedirectMiddleware;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\TopbarController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ProfileController;

use App\Http\Controllers\Frontend\SidebarController;

use App\Http\Controllers\Backend\AdminBlogController;
use App\Http\Controllers\Backend\AdminLogoController;
use App\Http\Controllers\Backend\AdminUserController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Backend\AdminAboutController;
use App\Http\Controllers\Backend\AdminBrandController;
use App\Http\Controllers\Backend\AdminLoginController;
use App\Http\Controllers\Backend\AdminOrderController;
use App\Http\Controllers\Frontend\Auth\AuthController;
use App\Http\Controllers\Seller\SellerOrderController;
use App\Http\Controllers\Backend\AdminContactController;
use App\Http\Controllers\Backend\AdminHeaderController;
use App\Http\Controllers\Backend\AdminReviewController;
use App\Http\Controllers\Backend\AdminSellerController;
use App\Http\Controllers\Backend\AdminTopbarController;
use App\Http\Controllers\Frontend\NewsletterController;


use App\Http\Controllers\Backend\AdminProductController;
use App\Http\Controllers\Backend\AdminSidebarController;

use App\Http\Controllers\Backend\AdminHomepageController;
use App\Http\Controllers\ShipRocket\ShipRocketController;
use App\Http\Controllers\Backend\AdminDashboardController;
use App\Http\Controllers\Frontend\FilterProductController;
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Backend\AdminCollectionController;
use App\Http\Controllers\SuperUser\SuperUserOrderController;
use App\Http\Controllers\SuperUser\SuperUserProductController;
use App\Http\Controllers\Backend\AdminProductSectionController;
use App\Http\Controllers\Frontend\SellerController as FrontendSellerController;


//Seller Routes
Route::get('/seller', function () {
    return view('seller.index');
})->name('seller_index');

Route::get('/seller/registration', function(){
    return view('seller.registration');
})->name('seller_registration');

Route::get('/seller/login', function(){return view('seller.login');})->name('seller_login');
Route::post('seller/login', [SellerController::class, 'loginSeller'])->name('seller_login_submit');
Route::post('/seller/register', [SellerController::class, 'register'])->name('seller.register');

Route::post('/seller/phone-submit', [SellerController::class, 'processPhoneNumber'])->name('seller.phone.submit');


Route::get('seller/gstverification', [SellerController::class, 'gstverification'])->name('seller_gstverification');
Route::post('seller/gstverify', [SellerController::class, 'submitGstDetails'])->name('seller_gstverify');

Route::get('seller/pickupverification', [SellerController::class, 'showPickupVerification'])->name('seller_pickupverification');
Route::post('seller/pickupverification', [SellerController::class, 'submitPickupAddress'])->name('seller_pickup_submit');

Route::get('seller/bankverification', [SellerController::class, 'showBankVerificationPage'])->name('seller_bankverification');
Route::post('seller/bankverification', [SellerController::class, 'submitBankDetails'])->name('seller_bankverify');

Route::get('seller/sellerverification', [SellerController::class, 'sellerVerification'])->name('seller_sellerverification');
Route::post('seller/details', [SellerController::class, 'storeSellerDetails'])->name('seller_verify');


    Route::get('seller/success', function(){
        return view('seller.success');
    })->name('seller_success');

Route::group(['middleware' =>  [SellerMiddleware::class]], function () {


    Route::get('seller/dashboard', [SellerDashboardController::class, 'dashboard'])->name('seller_dashboard');
    Route::get('/seller/transaction', [SellerOrderController::class, 'transaction'])->name('seller_transaction');

    Route::get('seller/logout', [SellerController::class, 'logout'])->name('seller_logout');
});


//For testing
Route::get('/home', function () {
    return view('test.home');
});
Route::get('/fetch-pincodes/{state}', [ProductController::class, 'fetchPincodes']);
Route::get('/fetch-states', [ProductController::class, 'fetchStates'])->name('fetch.states');


Route::post('/instant-buy', [InstantBuyController::class, 'store'])->name('instant-buy.store');

Route::post('order/createRazorpayOrder', [RazorpayController::class, 'createRazorpayOrder'])->name('order.createRazorpayOrder');
Route::post('order/completePayment', [RazorpayController::class, 'completePayment'])->name('order.completePayment');
Route::post('order/instantcompletePayment', [RazorpayController::class, 'instantcompletePayment'])->name('order.instantcompletePayment');

Route::post('payment/create',[RazorpayController::class,'store'])->name('razorpay.payment.store');
Route::post('payment/failure',[RazorpayController::class,'failure'])->name('razorpay.payment.failure');

// For Frontend
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('products', [ProductController::class, 'index'])->name('user.products');
Route::get('/products/filter', [FilterProductController::class, 'index'])->name('user.products.filter');
Route::get('product-details/{id?}', [ProductController::class, 'detail_index'])->name('user.product.details');
Route::post('/reviews/store', [ProductController::class, 'review_store'])->name('user.product.reviews.store');

Route::get('/search-subcategories', [ProductController::class, 'search'])->name('search.subcategories');

Route::get('/products/sale', [SaleController::class, 'index'])->name('products.sale');

Route::get('/about-us', [AboutController::class, 'index'])->name('about-us');

Route::get('/contact-us', function () {
    return view('contact');
})->name('contact-us');

Route::get('terms', function () {
    return view('termsandcondition');
})->name('terms');

Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
Route::get('/blog/{id?}/{slug?}', [BlogController::class, 'view'])->name('blog');
Route::get('/blogs/tags/{tagName}', [BlogController::class, 'findBlogsWithSameTags'])->name('blogs.tags');

Route::get('/blogs/related/{baseBlogId}', [BlogController::class, 'getRelatedBlogs']);
Route::post('/blog/update-view-count', [BlogController::class, 'updateViewCount'])->name('blogs.updateViewCount');


//indirect route, to be called by ajax
Route::post('/topbars', [TopbarController::class, 'index']);
Route::get('/product-sidebar', [SidebarController::class, 'index'])->name('product.sidebar');

Route::get('/send-otp-form', function () {
    return view('send-otp');
});
Route::post('/send-otp', [OTPController::class, 'sendOTP']);
// Route::get('/product', function () {
//     return view('product');
// });


// Route::get('/checkout', function () {
//     return view('checkout');
// });
Route::get('/status', function () {
    return view('status');
});

// Route::get('/authentication', function () {
//     return view('authentication');
// })->name('login');
Route::post('/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::post('/complete-subscribe', [NewsletterController::class, 'completeSubscription'])->name('newsletter.subscribe_complete');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');

Route::get('/our-sellers', [FrontendSellerController::class, 'index'])->name('sellers.index');
Route::get('/seller/{sellerId}', [FrontendSellerController::class, 'show'])->name('seller.shop');



Route::get('/coming-soon', function () {
    return view('coming_soon');
})->name('coming_soon');

Route::get('/check-auth', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return response()->json([
            'loggedIn' => true,
            'userType' => $user->usertype, // Assuming 'user_type' is the column name
            'isUser' => $user->usertype === 'user' // Check if the user type is 'user'
        ]);
    } else {
        return response()->json(['loggedIn' => false]);
    }
});

Route::post('/send-otp', [AuthController::class, 'sendOTP'])->name('send-otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOTP'])->name('verify-otp');
Route::post('/set-new-password', [AuthController::class, 'setNewPassword'])->name('set-new-password');



//Guest Middleware
Route::middleware(GuestMiddleware::class)->group(function () {

    Route::get('/login', [AuthController::class, 'login'] )->name('login');

    Route::post('/login', [AuthController::class, 'loginTry']);

    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::post('/logout', [AuthController::class, 'logout1'])->name('logout');


//User Middleware
Route::middleware(UserAuthMiddleware::class)->group(function () {
    Route::get('/myprofile', [ProfileController::class, 'index'] )->name('myprofile');
    Route::post('/user/update-profile', [ProfileController::class, 'updateProfile'])->name('user.updateProfile');
    Route::delete('/user-address/{id}', [ProfileController::class, 'address_destroy'])->name('user-address.destroy');
    Route::post('/user-address-save', [ProfileController::class, 'address_store'])->name('user-address.store');
    Route::get('/user-address/{id}/edit', [ProfileController::class, 'address_edit']);
    Route::put('/user-address-update/{id}', [ProfileController::class, 'address_update']);

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
    // Add to wishlist and redirect to wishlist page
    Route::post('/wishlist/add-and-redirect', [WishlistController::class, 'addAndRedirect'])->name('wishlist.addAndRedirect');


    Route::post('/wishlist/delete', [WishlistController::class, 'delete'])->name('wishlist.delete');

    Route::post('/wishlist/addToCart', [WishlistController::class, 'addToCart'])->name('wishlist.addToCart');

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/check-stock', [CartController::class, 'checkStock'])->name('cart.checkStock');
    Route::post('/cart/checkAvailability', [CartController::class, 'checkAvailability'])->name('order.checkAvailability');

    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

    Route::post('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');

    Route::post('/empty-cart', [CartController::class, 'emptyCart'])->name('cart.empty-cart');

    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('/instant-checkout', [CartController::class, 'instantCheckout'])->name('instant_checkout');


    Route::post('/order/place', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::post('instant/order/place', [OrderController::class, 'instantplaceOrder'])->name('order.place.instant');
    Route::get('/myorders',  [OrderController::class, 'myOrder'])->name('myorders');

    Route::post('/cancel-order-item', [OrderController::class, 'cancelOrderItem'])->name('cancelOrderItem');
});


// For Backend
Route::group(['middleware' => [CustomRedirectMiddleware::class]], function () {
    Route::get('admin-login', function () {
        return view('admin.pages.login');
    })->name('admin_login');

    Route::post(
        'admin-login-check',
        [AdminLoginController::class, 'admin_login_check']
    )->name('admin_login_submit');
});


Route::group(['middleware' =>  [AdminCheckMiddleware::class]], function () {

    Route::get('/admin-dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin_dashboard');
    
    //Profile
    Route::get('/admin-profile', [AdminDashboardController::class, 'profile'])->name('admin_profile');
    Route::post('/admin/update-profile', [AdminDashboardController::class, 'updateProfile'])->name('admin.updateProfile');
    Route::get('/admin-user-list', [AdminUserController::class, 'index'])->name('admin_userlist');

    Route::delete('/admin-users/delete/{id}', [AdminUserController::class, 'deleteUser'])->name('deleteUser');


    //category
    Route::get('/admin-category', [CategoryController::class, 'index'])->name('admin_category');
    Route::get('/admin-manage-category-header-images', [CategoryController::class, 'header_images'])->name('admin_category_header_images');
    Route::get('/admin-category-show/{id}', [CategoryController::class, 'show'])->name('admin_category.show');

    Route::post('/admin-category-update/{id}', [CategoryController::class, 'update'])->name('admin_category.update');
    Route::get('/category/{id}', [CategoryController::class, 'destroy'])->name('admin_category.delete');
    Route::get('/category/{id}/images', [CategoryController::class, 'getCategoryImages'])->name('category.images');
    Route::get('/get-image-details/{id}', [CategoryController::class, 'getImageDetails'])->name('image.details');
    //Route::get('/subcategories/{categoryId}', [CategoryController::class, 'getSubCategoriesByCategory'])->name('subcategories.byCategory');

    Route::post('/update-image', [CategoryController::class, 'updateImage'])->name('image.update');
    Route::get('/get-categories', [CategoryController::class, 'getCategories'])->name('categories.list');

    //Collection
    Route::get('/collections', [AdminCollectionController::class, 'index'])->name('admin.collections.index');
    Route::put('/collections/{id}', [AdminCollectionController::class, 'update'])->name('admin.collections.update');
    Route::delete('/collections/{id}', [AdminCollectionController::class, 'destroy'])->name('admin.collections.destroy');
    Route::post('/collections/store', [AdminCollectionController::class, 'store'])->name('admin.collections.store');

    //Product
    //Route::get('/generate-item-code', [AdminProductController::class, 'generateItemCode'])->name('generate.item.code');
    
    //Route::get('/get-categories', [CategoryController::class, 'getCategories'])->name('categories.list');
    //Route::get('/subcategories/{category_id}', [CategoryController::class, 'getSubcategories'])->name('subcategories.fetch');
    //Route::get('/get-products/{subcategory}', [CategoryController::class, 'getProducts'])->name('products.list');
    //Route::get('/product/{id}', [CategoryController::class, 'product_show'])->name('product.show');

    Route::get('/admin-view-all-product-list', [AdminProductController::class, 'view'])->name('admin_viewproduct');
    Route::get('/purchased-products/view-more', [AdminProductController::class, 'viewMore'])->name('purchasedProducts.viewMore');
    
    //Route::get('/admin-add-product', [AdminProductController::class, 'add'])->name('admin_addproduct');
    //Route::post('admin-product-submit',[AdminProductController::class, 'submit'])->name('admin_product_submit');

    //Route::get('/low-stock-products', [AdminProductController::class, 'lowStock'])->name('admin.lowStockProducts');
    //Route::get('/admin/inactive-products', [AdminProductController::class, 'viewInactive'])->name('admin.inactive_products');
    //Route::get('/products/my-products', [AdminProductController::class, 'myProducts'])->name('admin.my_products');
    //Route::get('/admin/products/{id}/info', [AdminProductController::class, 'show'])->name('admin_products.info');
    //Route::get('/admin/products/{id}/edit', [AdminProductController::class, 'edit'])->name('admin_products.edit');
    //Route::get('/admin/products/{id}/edit/images', [AdminProductController::class, 'edit_image'])->name('admin_products.edit_image');
    //Route::delete('/admin/products/{id}', [AdminProductController::class, 'delete'])->name('admin_products.delete');
    //Route::post('/admin/product/update', [AdminProductController::class, 'update'])->name('admin_product_update');
    //Route::post('/admin/product/update/image', [AdminProductController::class, 'update_image'])->name('admin_product_update_image');
    //Route::post('/admin/product-image/store', [AdminProductController::class, 'store_image'])->name('admin_product_image.store');

    //Route::post('/sizes', [AdminProductController::class, 'size_store'])->name('sizes.store');
    //Route::delete('/sizes/{id}', [AdminProductController::class, 'size_destroy'])->name('sizes.delete');
    //Route::get('/sizes', [AdminProductController::class, 'size_index'])->name('sizes.index');

    //Route::get('/admin/product/images/{id}', [AdminProductController::class, 'destroy_image'])->name('admin_product_image.delete');

    //Route::post('/admin/product/status-update/{id}', [AdminProductController::class, 'updateStatus'])->name('admin_product.status_update');
    Route::get('/admin/products/export/excel', [AdminProductController::class, 'exportExcel'])->name('products.export.excel');

    //Product Section
    Route::get('/manage-product-section', [AdminProductSectionController::class, 'index'])->name('admin.product.section');
    Route::get('/manage-products/{section}', [AdminProductSectionController::class, 'manageProducts'])->name('manage.products');
    Route::post('/products/save', [AdminProductSectionController::class, 'saveProducts'])->name('manage.products.save');
    
    // Brands
    Route::get('/brands', [AdminBrandController::class, 'index'])->name('admin.brands.index');
    Route::post('/brand/store', [AdminBrandController::class, 'store'])->name('admin.brands.store');



    Route::put('/brand/{id}', [AdminBrandController::class, 'update'])->name('admin.brand.update');
    Route::delete('/brand/{id}', [AdminBrandController::class, 'destroy'])->name('admin.brand.destroy');
    // Reviews

    Route::get('/review-list', [AdminReviewController::class, 'index'])->name('admin.review.index');
    Route::get('/review/{id}', [AdminReviewController::class, 'destroy'])->name('admin_review.delete');
    Route::post('/reviews', [AdminReviewController::class, 'store'])->name('reviews.store');
    Route::post('/admin/reviews/status-update/{id}', [AdminReviewController::class, 'updateStatus'])->name('admin_review.status_update');

    //Orders
    Route::get('/manage-order-section', [AdminOrderController::class, 'index'])->name('admin_orderlist');
    

    //Transaction
    Route::get('/admin/transaction', [AdminOrderController::class, 'transaction'])->name('admin_transaction');

    Route::get('admin-sellerlist', [AdminSellerController::class, 'index'])->name('admin_sellerlist');
    Route::get('admin-sellerlist/toggle-status/{id}', [AdminSellerController::class, 'toggleStatus'])->name('admin_sellerlist.toggle_status');


    Route::get('/admin/logout',[AdminDashboardController::class, 'logout'])->name('admin_logout');

    //Sale
    Route::get('/admin/sale',[AdminTopbarController::class, 'index'])->name('admin_sale');
    Route::post('/admin/sale/update', [AdminTopbarController::class, 'update'])->name('admin_sale.update');
    Route::post('/admin/discount/update', [AdminTopbarController::class, 'updateDiscount'])->name('admin_discount.update');

    //Sidebar
    Route::get('/admin/sidebar', [AdminSidebarController::class, 'index'])->name('admin_sidebar');
    Route::post('/admin/sidebar/updateText', [AdminSidebarController::class, 'updateText'])->name('admin_sidebar.updateText');
    Route::post('/admin/sidebar/updateFiles', [AdminSidebarController::class, 'updateFiles'])->name('admin_sidebar.updateFiles');

    //Blogs
    Route::get('/admin/blogs', [AdminBlogController::class, 'index'])->name('admin.blogs.index');
    Route::get('/admin/blogs/add', [AdminBlogController::class, 'add'])->name('admin.blogs.add');
    Route::post('/admin/blogs/create', [AdminBlogController::class, 'create'])->name('admin.blogs.create');

    Route::post('/publish-blog/{id}', [AdminBlogController::class, 'publish'])->name('publish.blog');
    Route::post('/toggle-status/{id}', [AdminBlogController::class, 'toggleStatus'])->name('toggle.status');

    Route::get('/admin/blogs/edit/{id}', [AdminBlogController::class, 'edit'])->name('admin.blogs.edit');
    Route::put('/admin/blogs/update/{id}', [AdminBlogController::class, 'update'])->name('admin.blogs.update');
    Route::delete('/admin/blogs/delete/{id}', [AdminBlogController::class, 'delete'])->name('admin.blogs.delete');

    //Logos
    Route::get('admin/logos', [AdminLogoController::class, 'index'])->name('admin.logo.index');
    Route::post('/logos/{id}', [AdminLogoController::class, 'update'])->name('logos.update');

    //Homepage
    Route::get('/admin/homepage', [AdminHomepageController::class, 'index'])->name('admin.homepage');
    Route::post('/admin/homepage/update', [AdminHomepageController::class, 'update'])->name('admin.homepage.update');
    Route::get('/admin/homepage/section-data/{section}', [AdminHomepageController::class, 'getSectionData'])->name('admin.homepage.section.data');
    Route::post('/admin/homepage/update-section', [AdminHomepageController::class, 'updateSection'])->name('admin.homepage.update');

    //Header
    Route::get('/admin/header', [AdminHeaderController::class, 'index'])->name('admin.header');
    Route::post('/admin/header/update', [AdminHeaderController::class, 'update'])->name('admin.header.update');

    //About
    Route::get('/admin/aboutus', [AdminAboutController::class, 'index'])->name('admin.aboutus');
    Route::post('/admin/about/update', [AdminAboutController::class, 'update'])->name('about.update');
    Route::post('/about/stories/update', [AdminAboutController::class, 'updateStories'])->name('about.stories.update');


    //Contact 
    Route::get('/admin/contact', [AdminContactController::class, 'index'])->name('admin.contact');
    Route::get('/admin/contact/{id}', [AdminContactController::class, 'show'])->name('admin.contact.show');

    Route::put('/admin/contact/{id}/respond', [AdminContactController::class, 'respond'])->name('admin.contact.respond');
});




//Seler Pages





//SuperUser Routes
Route::group(['middleware' =>  [SuperUserMiddleware::class]], function () {

    Route::get('/products/my-products', [SuperUserProductController::class, 'myProducts'])->name('admin.my_products');
    Route::get('/products/{id}/info', [SuperUserProductController::class, 'show'])->name('admin_products.info');

    Route::get('/products/add-product', [SuperUserProductController::class, 'add'])->name('superuser_addproduct');
    Route::get('/products/inactive-products', [SuperUserProductController::class, 'viewInactive'])->name('admin.inactive_products');
    Route::get('/low-stock-products', [SuperUserProductController::class, 'lowStock'])->name('superuser.lowStockProducts');
    Route::get('/products/{id}/edit', [SuperUserProductController::class, 'edit'])->name('admin_products.edit');
    Route::get('/products/{id}/edit/images', [AdminProductController::class, 'edit_image'])->name('admin_products.edit_image');
    Route::delete('/products/{id}', [SuperUserProductController::class, 'delete'])->name('admin_products.delete');
    Route::post('/product/update', [SuperUserProductController::class, 'update'])->name('admin_product_update');
    Route::post('/product/update/image', [SuperUserProductController::class, 'update_image'])->name('admin_product_update_image');
    Route::post('/product-image/store', [SuperUserProductController::class, 'store_image'])->name('admin_product_image.store');
    Route::get('/product/images/{id}', [SuperUserProductController::class, 'destroy_image'])->name('admin_product_image.delete');
    Route::post('/product/status-update/{id}', [SuperUserProductController::class, 'updateStatus'])->name('admin_product.status_update');
    Route::get('/generate-item-code', [SuperUserProductController::class, 'generateItemCode'])->name('generate.item.code');

    Route::get('/get-categories', [CategoryController::class, 'getCategories'])->name('categories.list');
    Route::get('/subcategories/{category_id}', [CategoryController::class, 'getSubcategories'])->name('subcategories.fetch');
    Route::get('/get-products/{subcategory}', [CategoryController::class, 'getProducts'])->name('products.list');
    Route::get('/product/{id}', [CategoryController::class, 'product_show'])->name('product.show');



    Route::post('/sizes', [SuperUserProductController::class, 'size_store'])->name('sizes.store');
    Route::delete('/sizes/{id}', [SuperUserProductController::class, 'size_destroy'])->name('sizes.delete');
    Route::get('/sizes', [SuperUserProductController::class, 'size_index'])->name('sizes.index');

    Route::get('/subcategories/{categoryId}', [CategoryController::class, 'getSubCategoriesByCategory'])->name('subcategories.byCategory');


    Route::post('/product-submit',[SuperUserProductController::class, 'submit'])->name('admin_product_submit');


    Route::get('/orders/my-orders', [SuperUserOrderController::class, 'myOrders'])->name('admin.my_order');
    Route::get('/orders/{id}', [SuperUserOrderController::class, 'show'])->name('superuser_orders.show');
    Route::post('/orders/initiate', [SuperUserOrderController::class, 'initiateOrder'])->name('superuser_orders.initiate');
    Route::get('/orders/shiprocket/show', [SuperUserOrderController::class, 'shiprocketShowOrder'])->name('superuser_orders.shiprocket.show');

});

Route::get('/test-order', [SuperUserOrderController::class, 'createAdHocOrder'])->name('test_order');
Route::get('/submit-primary-location', [SuperUserOrderController::class, 'submitPrimaryLocation'])->name('submit.primary.location');

Route::get('/fetch-pickup-locations', [SuperUserOrderController::class, 'fetchPickupLocations'])->name('fetch_pickup_locations');
Route::get('/shiprocket/login', [SuperUserOrderController::class, 'shipRocketlogin'])->name('shiprocket.login');

//ShipRocket

Route::post('/shiprocket/serviceability', [ShipRocketController::class, 'serviceAbility'])->name('shiprocket.serviceability');
Route::get('shiprocket/fetch-order', [ShipRocketController::class, 'fetchOrder'])->name('shiprocket.fetch-order');
Route::get('shiprocket/fetch-shipment', [ShipRocketController::class, 'fetchShipment'])->name('shiprocket.fetch-shipment');
Route::get('shiprocket/fetch-tracking', [ShipRocketController::class, 'fetchTracking'])->name('shiprocket.fetch-tracking');


Route::get('/test-shiprocket/serviceability', function () {
    $baseUrl = config('shiprocket.base_url');
    $apiToken = config('shiprocket.api_token');

    // Define sample pin codes for testing
    $queryParams = [
        'pickup_postcode' => '700001', // Example pickup pin code 713205
        'delivery_postcode' => '722122', // Example delivery pin code
        'cod' => 1, // Set to 1 for COD serviceability check
        'weight' => 1.5, // Example weight
    ];

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiToken,
    ])->get('{$baseUrl}/courier/serviceability/', $queryParams);

    if ($response->failed()) {
        return response()->json([
            'error' => 'Failed to fetch data from Shiprocket',
            'details' => $response->json(),
        ], $response->status());
    }

    return response()->json($response->json());
});