<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ShoeController;
use App\Http\Controllers\AccessoryController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\Discount\DiscountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentOptionController;
use App\Http\Controllers\SpecialOfferController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\SiteSettings\HelpCenterController;
use App\Http\Controllers\SiteSettings\SiteSettingsController;
use App\Http\Controllers\User\CustomerController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GeneralSettings;
use App\Http\Controllers\DiscountController as DiscountControllerCoupon;
use App\Http\Controllers\HomeSliderController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\FAQAnswerController;
use App\Http\Controllers\LiveChatController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Customer2Controller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// For login - No authentication required
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('reset-pass', [AuthController::class, 'resetMyPassword']);
Route::get('verify-token/{token}', [AuthController::class, 'verifyToken'])->name('reset.password.get');
Route::post('reset-pass-submit', [AuthController::class, 'submitResetPassword'])->name('reset.password.post');

Route::post('admin/login', [AuthController::class, 'adminLogin']);

// Protected routes - Requires authentication
Route::middleware(['auth:sanctum'])->group(function () {
    // For logout
    Route::post('logout', [AuthController::class, 'logout']);

    // For profile stuff
    Route::get('user/me', [UserController::class, 'me']);
    Route::post('user/update', [UserController::class, 'updateInfo']);

    Route::get('user/orders', [UserController::class, 'orders']);
    Route::get('user/orders/{id}', [UserController::class, 'ordersDetail']);

    // address
    Route::get('user/address', [UserController::class, 'address']);
    Route::post('user/address/store', [UserController::class, 'addressStore']);
    Route::post('user/address/update', [UserController::class, 'addressUpdate']);
    Route::post('user/address/delete', [UserController::class, 'addressDelete']);

    Route::get('user/wishlist', [UserController::class, 'wishlist']);
    Route::post('user/wishlist/store', [UserController::class, 'wishlistStore']);
    Route::delete('user/wishlist/delete/{id}', [UserController::class, 'wishlistDestroy']);

    // For admin only
    Route::middleware(['admin'])->group(function () {
        // For custom controller functions
        // Getting archived Announcements
        Route::get('announcements/archived', [AnnouncementController::class, 'getArchived']);
        Route::get('discounts/archived', [DiscountController::class, 'getArchived']);

        // For api resources
        Route::apiResources([
            'sites-settings' => SiteSettingsController::class,
            'help-centers' => HelpCenterController::class,
            'announcements' => AnnouncementController::class,
            'discounts' => DiscountController::class,
            'promotions' => PromotionController::class,
            'shoes' => ShoeController::class,
            //'couriers' => CourierController::class,
            'customers' => CustomerController::class,
            'special-offers' => SpecialOfferController::class,
            'orders' => OrderController::class,
            //'payment-options' => PaymentOptionController::class
        ]);

        Route::post('customers/{id}/suspend', [CustomerController::class, 'suspend']);
    });

});

// Your existing protected routes
Route::apiResources([
    'accessories' => AccessoryController::class,
    'variants' => ProductVariantController::class,
    'images' => ProductImageController::class,
]);

// Read-only Discount routes for 'customer'
Route::apiResource('discounts', DiscountController::class)->only([
    'index', 'show',
]);

// Read-only Promotion routes for 'customer'
Route::apiResource('discounts', PromotionController::class)->only([
    'index', 'show',
]);

Route::apiResource('shoes', ShoeController::class)->only([
    'index', 'show'
]);

Route::get('mix-and-match', [ShoeController::class, 'mixAndMatch']);

/* carts */

Route::get('/carts', '\App\Http\Controllers\CartController@index');

Route::post('/carts/store', [
    'uses' => '\App\Http\Controllers\CartController@store',
    'as' => 'carts.store'
]);

Route::post('/carts/{id}/update',
    ['as' => 'carts.update',
        'uses' => '\App\Http\Controllers\CartController@update']
);

Route::delete('/carts/{id}/delete',
    ['as' => 'carts.delete',
        'uses' => '\App\Http\Controllers\CartController@destroy']
);


Route::apiResource('couriers', CourierController::class)->only([
    'index', 'show'
]);

Route::apiResource('special-offers', SpecialOfferController::class)->only([
    'index', 'show'
]);

// Route::apiResource('orders', OrderController::class)->only([
//     'index', 'show'
// ]);

Route::get('shoes/{shoe}/variants', [ShoeController::class, 'getVariants']);
Route::get('shoes/{shoe}/images', [ShoeController::class, 'getImages']);
Route::get('accessories/{accessory}/images', [AccessoryController::class, 'getImages']);

/* OTP */
Route::post('/otp/verify', [
    'uses' => '\App\Http\Controllers\OTPController@verify',
    'as' => 'api.otp.verify'
]);

/* Checkout */
Route::post('/checkout', [
    'uses' => '\App\Http\Controllers\CheckoutController@processCheckout',
    'as' => 'api.checkout.process'
]);

Route::post('products/review', [ShoeController::class, 'addReview']);

Route::post('checkout/use_coupon', [CheckoutController::class, 'useCoupon']);

Route::get('homesliders', [HomeSliderController::class, 'fetchSlides']);

Route::get('recommended_products', [ShoeController::class, 'getMostSoldProducts']);

Route::post('log-activity', [ActivityLogController::class, 'logActivity']);
Route::get('get-activity', [ActivityLogController::class, 'getActivity']);

/* LIVE CHAT */
Route::get('chat/check/{user_id}', [LiveChatController::class, 'customerCheck']);
Route::post('chat/start_chat/{user_id}', [LiveChatController::class, 'customerStartChat']);
Route::get('chat/open_chat/{user_id}', [LiveChatController::class, 'customerOpenChat']);
Route::post('chat/send_chat/{user_id}', [LiveChatController::class, 'customerSendChat']);
/* LIVE CHAT */

/* ADMIN */
/* will add auth / middlewares afterwards */

Route::get('admin/me/{id}', [RoleController::class, 'me']);

// display products
Route::get('admin/products', [ShoeController::class, 'index']);
Route::post('admin/products/store', [ShoeController::class, 'store']);
Route::get('admin/products/view/{id}', [ShoeController::class, 'show']);
Route::post('admin/products/update/{id}', [ShoeController::class, 'update']);
Route::delete('admin/products/delete/{id}', [ShoeController::class, 'destroy']);

Route::get('admin/product/types', [ShoeController::class, 'getTypes']);
Route::post('admin/product/types/store', [ShoeController::class, 'typesStore'])->name('admin.product_types.store');
Route::post('admin/product/types/update/{id}', [ShoeController::class, 'typesUpdate'])->name('admin.product_types.update');
Route::delete('admin/product/types/delete/{id}', [ShoeController::class, 'typesDelete'])->name('admin.product_types.delete');

Route::get('admin/product/categories', [ShoeController::class, 'getCategories']);
Route::post('admin/product/categories/store', [ShoeController::class, 'categoriesStore'])->name('admin.product_categories.store');
Route::post('admin/product/categories/update/{id}', [ShoeController::class, 'categoriesUpdate'])->name('admin.product_categories.update');
Route::delete('admin/product/categories/delete/{id}', [ShoeController::class, 'categoriesDelete'])->name('admin.product_categories.delete');

Route::get('admin/product/brands', [ShoeController::class, 'getBrands']);
Route::post('admin/product/brands/store', [ShoeController::class, 'brandsStore'])->name('admin.product_brands.store');
Route::post('admin/product/brands/update/{id}', [ShoeController::class, 'brandsUpdate'])->name('admin.product_brands.update');
Route::delete('admin/product/brands/delete/{id}', [ShoeController::class, 'brandsDelete'])->name('admin.product_brands.delete');

Route::get('admin/product/sizes', [ShoeController::class, 'getSizes']);
Route::post('admin/product/sizes/store', [ShoeController::class, 'sizesStore'])->name('admin.product_sizes.store');
Route::post('admin/product/sizes/update/{id}', [ShoeController::class, 'sizesUpdate'])->name('admin.product_sizes.update');
Route::delete('admin/product/sizes/delete/{id}', [ShoeController::class, 'sizesDelete'])->name('admin.product_sizes.delete');

Route::get('admin/product/colors', [ShoeController::class, 'getColors']);
Route::post('admin/product/colors/store', [ShoeController::class, 'colorsStore'])->name('admin.product_colors.store');
Route::post('admin/product/colors/update/{id}', [ShoeController::class, 'colorsUpdate'])->name('admin.product_colors.update');
Route::delete('admin/product/colors/delete/{id}', [ShoeController::class, 'colorsDelete'])->name('admin.product_colors.delete');

Route::get('all-payments', [PaymentOptionController::class, 'getAllpayments']);

Route::get('admin/role-permissions', [RoleController::class, 'index']);
Route::post('admin/role-permissions/store', [RoleController::class, 'store']);
Route::get('admin/role-permissions/view/{id}', [RoleController::class, 'show']);
Route::post('admin/role-permissions/update/{id}', [RoleController::class, 'update']);
Route::delete('admin/role-permissions/delete/{id}', [RoleController::class, 'destroy']);

Route::get('admin/orders', [OrderController::class, 'index']);
Route::get('admin/orders/{id}', [OrderController::class, 'show']);
Route::post('admin/orders/{id}/status', [OrderController::class, 'updateStatus']);
Route::post('admin/orders/{id}/tracking', [OrderController::class, 'updateTracking']);
Route::post('admin/orders/{id}/payment', [OrderController::class, 'updatePayment']);

Route::get('admin/couriers', [CourierController::class, 'index']);
Route::post('admin/couriers/create', [CourierController::class, 'store'])->name('admin.couriers.store');
Route::post('admin/couriers/edit/{id}', [CourierController::class, 'update'])->name('admin.couriers.update');
Route::delete('admin/couriers/destroy/{id}', [CourierController::class, 'destroy'])->name('admin.couriers.delete');

Route::get('admin/payment-options', [PaymentOptionController::class, 'index']);
Route::post('admin/payment-options/create', [PaymentOptionController::class, 'store'])->name('admin.payment_options.store');
Route::post('admin/payment-options/edit/{id}', [PaymentOptionController::class, 'update'])->name('admin.payment_options.update');
Route::delete('admin/payment-options/destroy/{id}', [PaymentOptionController::class, 'destroy'])->name('admin.payment_options.delete');

Route::get('admin/sales', [CheckoutController::class, 'salesOrder']);
Route::get('admin/statistics', [CheckoutController::class, 'statistics']);
Route::get('admin/get_sales_report', [CheckoutController::class, 'getSalesReport']);
Route::get('admin/get_sales_report_v2', [CheckoutController::class, 'getSalesReportV2']);
Route::get('admin/product_performance_report', [CheckoutController::class, 'getProductPerformanceReport']);
Route::get('admin/get_most_sold_products_chart', [CheckoutController::class, 'getMostSoldProductsChart']);
Route::get('admin/customer_behavior', [ActivityLogController::class, 'generateCustomerBehaviorReport']);

Route::get('admin/general-settings', [GeneralSettings::class, 'generalSettings']);
Route::post('admin/general-settings/update/web-config', [GeneralSettings::class, 'updateWebConfig']);
Route::post('admin/general-settings/update/basic-info', [GeneralSettings::class, 'updateBasicInfo']);

Route::get('admin/discount_coupons', [DiscountControllerCoupon::class, 'index']);
Route::post('admin/discount_coupons/create', [DiscountControllerCoupon::class, 'store'])->name('admin.discount_coupons.store');
Route::post('admin/discount_coupons/edit/{id}', [DiscountControllerCoupon::class, 'update'])->name('admin.discount_coupons.update');
Route::delete('admin/discount_coupons/destroy/{id}', [DiscountControllerCoupon::class, 'destroy'])->name('admin.discount_coupons.delete');

Route::get('admin/home_slider', [HomeSliderController::class, 'index']);
Route::post('admin/home_slider/create', [HomeSliderController::class, 'store'])->name('admin.home_slider.store');
Route::post('admin/home_slider/edit/{id}', [HomeSliderController::class, 'update'])->name('admin.home_slider.update');
Route::delete('admin/home_slider/destroy/{id}', [HomeSliderController::class, 'destroy'])->name('admin.home_slider.delete');

Route::get('admin/faqs', [FAQController::class, 'index']);
Route::post('admin/faqs/create', [FAQController::class, 'store'])->name('admin.faqs.store');
Route::post('admin/faqs/edit/{id}', [FAQController::class, 'update'])->name('admin.faqs.update');
Route::delete('admin/faqs/destroy/{id}', [FAQController::class, 'destroy'])->name('admin.faqs.delete');

Route::get('admin/faq_answers', [FAQAnswerController::class, 'index']);
Route::post('admin/faq_answers/create', [FAQAnswerController::class, 'store'])->name('admin.faq_answers.store');
Route::post('admin/faq_answers/edit/{id}', [FAQAnswerController::class, 'update'])->name('admin.faq_answers.update');
Route::delete('admin/faq_answers/destroy/{id}', [FAQAnswerController::class, 'destroy'])->name('admin.faq_answers.delete');

Route::get('admin/chat/list', [LiveChatController::class, 'adminListChats']);
Route::get('admin/chat/open/{id}', [LiveChatController::class, 'adminOpenChat']);
Route::post('admin/chat/send/{id}', [LiveChatController::class, 'adminSendChat']);

Route::get('admin/customer', [Customer2Controller::class, 'index']);
Route::post('admin/customer/create', [Customer2Controller::class, 'store'])->name('admin.customer.store');
Route::post('admin/customer/edit/{id}', [Customer2Controller::class, 'update'])->name('admin.customer.update');
Route::delete('admin/customer/destroy/{id}', [Customer2Controller::class, 'destroy'])->name('admin.customer.delete');
Route::post('admin/customer/{id}/suspend', [Customer2Controller::class, 'suspend']);

Route::get('admin/admin_account', [Customer2Controller::class, 'indexAdmin']);
Route::post('admin/admin_account/create', [Customer2Controller::class, 'storeAdmin'])->name('admin.admin_account.store');
Route::post('admin/admin_account/edit/{id}', [Customer2Controller::class, 'updateAdmin'])->name('admin.admin_account.update');
Route::delete('admin/admin_account/destroy/{id}', [Customer2Controller::class, 'destroyAdmin'])->name('admin.admin_account.delete');
Route::post('admin/admin_account/{id}/suspend', [Customer2Controller::class, 'suspendAdmin']);
/* ADMIN */