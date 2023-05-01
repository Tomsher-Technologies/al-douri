<?php

use App\Http\Controllers\Api\V2\AddressController;
use App\Http\Controllers\Api\V2\AuthController;
use App\Http\Controllers\Api\V2\BannerController;
use App\Http\Controllers\Api\V2\BrandController;
use App\Http\Controllers\Api\V2\BusinessSettingController;
use App\Http\Controllers\Api\V2\CartController;
use App\Http\Controllers\Api\V2\CategoryController;
use App\Http\Controllers\Api\V2\ChatController;
use App\Http\Controllers\Api\V2\CheckoutController;
use App\Http\Controllers\Api\V2\ClubpointController;
use App\Http\Controllers\Api\V2\ColorController;
use App\Http\Controllers\Api\V2\ConfigController;
use App\Http\Controllers\Api\V2\CurrencyController;
use App\Http\Controllers\Api\V2\CustomerController;
use App\Http\Controllers\Api\V2\DeliveryBoyController;
use App\Http\Controllers\Api\V2\FileController;
use App\Http\Controllers\Api\V2\FilterController;
use App\Http\Controllers\Api\V2\FlashDealController;
use App\Http\Controllers\Api\V2\GeneralSettingController;
use App\Http\Controllers\Api\V2\HomeCategoryController;
use App\Http\Controllers\Api\V2\LanguageController;
use App\Http\Controllers\Api\V2\OrderController;
use App\Http\Controllers\Api\V2\PasswordResetController;
use App\Http\Controllers\Api\V2\PaymentTypesController;
use App\Http\Controllers\Api\V2\PolicyController;
use App\Http\Controllers\Api\V2\ProductController;
use App\Http\Controllers\Api\V2\ProfileController;
use App\Http\Controllers\Api\V2\PurchaseHistoryController;
use App\Http\Controllers\Api\V2\RefundRequestController;
use App\Http\Controllers\Api\V2\ReviewController;
use App\Http\Controllers\Api\V2\SearchSuggestionController;
use App\Http\Controllers\Api\V2\ShippingController;
use App\Http\Controllers\Api\V2\ShopController;
use App\Http\Controllers\Api\V2\SliderController;
use App\Http\Controllers\Api\V2\StripeController;
use App\Http\Controllers\Api\V2\UserController;
use App\Http\Controllers\Api\V2\WalletController;
use App\Http\Controllers\Api\V2\WishlistController;

Route::group(['prefix' => 'v2/auth', 'middleware' => ['app_language']], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('social-login', [AuthController::class, 'socialLogin']);
    Route::post('password/forget_request', [PasswordResetController::class, 'forgetRequest']);
    Route::post('password/confirm_reset', [PasswordResetController::class, 'confirmReset']);
    Route::post('password/resend_code', [PasswordResetController::class, 'resendCode']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
    Route::post('resend_code', [AuthController::class, 'resendCode']);
    Route::post('confirm_code', [AuthController::class, 'confirmCode']);
});

Route::group(['prefix' => 'v2'], function () {
});

Route::group(['prefix' => 'v2', 'middleware' => ['app_language']], function () {
    Route::prefix('delivery-boy')->group(function () {
        Route::get('dashboard-summary/{id}', [DeliveryBoyController::class, 'dashboard_summary'])->middleware('auth:sanctum');
        Route::get('deliveries/completed/{id}', [DeliveryBoyController::class, 'completed_delivery'])->middleware('auth:sanctum');
        Route::get('deliveries/cancelled/{id}', [DeliveryBoyController::class, 'cancelled_delivery'])->middleware('auth:sanctum');
        Route::get('deliveries/on_the_way/{id}', [DeliveryBoyController::class, 'on_the_way_delivery'])->middleware('auth:sanctum');
        Route::get('deliveries/picked_up/{id}', [DeliveryBoyController::class, 'picked_up_delivery'])->middleware('auth:sanctum');
        Route::get('deliveries/assigned/{id}', [DeliveryBoyController::class, 'assigned_delivery'])->middleware('auth:sanctum');
        Route::get('collection-summary/{id}', [DeliveryBoyController::class, 'collection_summary'])->middleware('auth:sanctum');
        Route::get('earning-summary/{id}', [DeliveryBoyController::class, 'earning_summary'])->middleware('auth:sanctum');
        Route::get('collection/{id}', [DeliveryBoyController::class, 'collection'])->middleware('auth:sanctum');
        Route::get('earning/{id}', [DeliveryBoyController::class, 'earning'])->middleware('auth:sanctum');
        Route::get('cancel-request/{id}', [DeliveryBoyController::class, 'cancel_request'])->middleware('auth:sanctum');
        Route::post('change-delivery-status', [DeliveryBoyController::class, 'change_delivery_status'])->middleware('auth:sanctum');
    });

    Route::prefix('seller')->group(function () {
        Route::get('orders', [SellerController::class, 'getOrderList'])->middleware('auth:sanctum');;
        Route::get('orders/details/{id}', [SellerController::class, 'getOrderDetails'])->middleware('auth:sanctum');
        Route::get('orders/items/{id}', [SellerController::class, 'getOrderItems'])->middleware('auth:sanctum');
    });


    Route::get('get-search-suggestions', [SearchSuggestionController::class, 'getList']);
    Route::get('languages', [LanguageController::class, 'getList']);

    Route::get('chat/conversations', [ChatController::class, 'conversations'])->middleware('auth:sanctum');
    Route::get('chat/messages/{id}', [ChatController::class, 'messages'])->middleware('auth:sanctum');
    Route::post('chat/insert-message', [ChatController::class, 'insert_message'])->middleware('auth:sanctum');
    Route::get('chat/get-new-messages/{conversation_id}/{last_message_id}', [ChatController::class, 'get_new_messages'])->middleware('auth:sanctum');
    Route::post('chat/create-conversation', [ChatController::class, 'create_conversation'])->middleware('auth:sanctum');
    // BannerController
    Route::apiResource('banners', BannerController::class)->only('index');

    Route::get('brands/top',  [BrandController::class, 'top']);
    Route::apiResource('brands', BrandController::class)->only('index');

    Route::apiResource('business-settings',  BusinessSettingController::class)->only('index');

    Route::get('categories/featured', [CategoryController::class, 'featured']);
    Route::get('categories/home', [CategoryController::class, 'home']);
    Route::get('categories/top', [CategoryController::class, 'top']);
    Route::apiResource('categories', CategoryController::class)->only('index');
    Route::get('sub-categories/{id}', [SubCategoryController::class, 'index'])->name('subCategories.index');

    Route::apiResource('colors', ColorController::class)->only('index');

    Route::apiResource('currencies', CurrencyController::class)->only('index');

    Route::apiResource('customers', CustomerController::class)->only('show');

    Route::apiResource('general-settings', GeneralSettingController::class)->only('index');

    Route::apiResource('home-categories', HomeCategoryController::class)->only('index');

    //Route::get('purchase-history/{id}', [PurchaseHistoryController::class,'index'])->middleware('auth:sanctum');
    //Route::get('purchase-history-details/{id}', [PurchaseHistoryDetailController::class,'index'])->name('purchaseHistory.details')->middleware('auth:sanctum');

    Route::get('purchase-history', [PurchaseHistoryController::class, 'index'])->middleware('auth:sanctum');
    Route::get('purchase-history-details/{id}', [PurchaseHistoryController::class, 'details'])->middleware('auth:sanctum');
    Route::get('purchase-history-items/{id}', [PurchaseHistoryController::class, 'items'])->middleware('auth:sanctum');

    Route::get('filter/categories', [FilterController::class, 'categories']);
    Route::get('filter/brands', [FilterController::class, 'brands']);

    Route::get('products/admin', [ProductController::class, 'admin']);
    Route::get('products/seller/{id}', [ProductController::class, 'seller']);
    Route::get('products/category/{id}', [ProductController::class, 'category'])->name('api.products.category');
    Route::get('products/sub-category/{id}', [ProductController::class, 'subCategory'])->name('products.subCategory');
    Route::get('products/sub-sub-category/{id}', [ProductController::class, 'subSubCategory'])->name('products.subSubCategory');
    Route::get('products/brand/{id}', [ProductController::class, 'brand'])->name('api.products.brand');
    Route::get('products/todays-deal', [ProductController::class, 'todaysDeal']);
    Route::get('products/featured', [ProductController::class, 'featured']);
    Route::get('products/best-seller', [ProductController::class, 'bestSeller']);
    Route::get('products/related/{id}', [ProductController::class, 'related'])->name('products.related');

    Route::get('products/featured-from-seller/{id}', [ProductController::class, 'newFromSeller'])->name('products.featuredromSeller');
    Route::get('products/search', [ProductController::class, 'search']);
    Route::get('products/variant/price', [ProductController::class, 'variantPrice']);
    Route::get('products/home', [ProductController::class, 'home']);
    Route::apiResource('products', ProductController::class)->except(['store', 'update', 'destroy']);

    Route::get('cart-summary', [CartController::class, 'summary'])->middleware('auth:sanctum');
    Route::post('carts/process', [CartController::class, 'process'])->middleware('auth:sanctum');
    Route::post('carts/add', [CartController::class, 'add'])->middleware('auth:sanctum');
    Route::post('carts/change-quantity', [CartController::class, 'changeQuantity'])->middleware('auth:sanctum');
    Route::apiResource('carts', CartController::class)->only('destroy')->middleware('auth:sanctum');
    Route::post('carts', [CartController::class, 'getList'])->middleware('auth:sanctum');


    Route::post('coupon-apply', [CheckoutController::class, 'apply_coupon_code'])->middleware('auth:sanctum');
    Route::post('coupon-remove', [CheckoutController::class, 'remove_coupon_code'])->middleware('auth:sanctum');

    Route::post('update-address-in-cart', [AddressController::class, 'updateAddressInCart'])->middleware('auth:sanctum');

    Route::get('payment-types', [PaymentTypesController::class, 'getList']);

    Route::get('reviews/product/{id}', [ReviewController::class, 'index'])->name('api.reviews.index');
    Route::post('reviews/submit', [ReviewController::class, 'submit'])->name('api.reviews.submit')->middleware('auth:sanctum');

    Route::get('shop/user/{id}', [ShopController::class, 'shopOfUser'])->middleware('auth:sanctum');
    Route::get('shops/details/{id}', [ShopController::class, 'info'])->name('shops.info');
    Route::get('shops/products/all/{id}', [ShopController::class, 'allProducts'])->name('shops.allProducts');
    Route::get('shops/products/top/{id}', [ShopController::class, 'topSellingProducts'])->name('shops.topSellingProducts');
    Route::get('shops/products/featured/{id}', [ShopController::class, 'featuredProducts'])->name('shops.featuredProducts');
    Route::get('shops/products/new/{id}', [ShopController::class, 'newProducts'])->name('shops.newProducts');
    Route::get('shops/brands/{id}', [ShopController::class, 'brands'])->name('shops.brands');
    Route::apiResource('shops', ShopController::class)->only('index');

    Route::apiResource('sliders', SliderController::class)->only('index');

    Route::get('wishlists-check-product', [WishlistController::class, 'isProductInWishlist'])->middleware('auth:sanctum');
    Route::get('wishlists-add-product', [WishlistController::class, 'add'])->middleware('auth:sanctum');
    Route::get('wishlists-remove-product', [WishlistController::class, 'remove'])->middleware('auth:sanctum');
    Route::get('wishlists', [WishlistController::class, 'index'])->middleware('auth:sanctum');
    Route::apiResource('wishlists', WishlistController::class)->except(['index', 'update', 'show']);

    Route::get('policies/seller', [PolicyController::class, 'sellerPolicy'])->name('policies.seller');
    Route::get('policies/support', [PolicyController::class, 'supportPolicy'])->name('policies.support');
    Route::get('policies/return', [PolicyController::class, 'returnPolicy'])->name('policies.return');

    // Route::get('user/info/{id}', [UserController::class,'info'])->middleware('auth:sanctum');
    // Route::post('user/info/update', [UserController::class,'updateName'])->middleware('auth:sanctum');
    Route::get('user/shipping/address', [AddressController::class, 'addresses'])->middleware('auth:sanctum');
    Route::post('user/shipping/create', [AddressController::class, 'createShippingAddress'])->middleware('auth:sanctum');
    Route::post('user/shipping/update', [AddressController::class, 'updateShippingAddress'])->middleware('auth:sanctum');
    Route::post('user/shipping/update-location', [AddressController::class, 'updateShippingAddressLocation'])->middleware('auth:sanctum');
    Route::post('user/shipping/make_default', [AddressController::class, 'makeShippingAddressDefault'])->middleware('auth:sanctum');
    Route::get('user/shipping/delete/{address_id}', [AddressController::class, 'deleteShippingAddress'])->middleware('auth:sanctum');

    Route::get('clubpoint/get-list', [ClubpointController::class, 'get_list'])->middleware('auth:sanctum');
    Route::post('clubpoint/convert-into-wallet', [ClubpointController::class, 'convert_into_wallet'])->middleware('auth:sanctum');

    Route::get('refund-request/get-list', [RefundRequestController::class, 'get_list'])->middleware('auth:sanctum');
    Route::post('refund-request/send', [RefundRequestController::class, 'send'])->middleware('auth:sanctum');

    Route::post('get-user-by-access_token', [UserController::class, 'getUserInfoByAccessToken']);

    Route::get('cities', [AddressController::class, 'getCities']);
    Route::get('states', [AddressController::class, 'getStates']);
    Route::get('countries', [AddressController::class, 'getCountries']);

    Route::get('cities-by-state/{state_id}', [AddressController::class, 'getCitiesByState']);
    Route::get('states-by-country/{country_id}', [AddressController::class, 'getStatesByCountry']);

    Route::post('shipping_cost', [ShippingController::class, 'shipping_cost'])->middleware('auth:sanctum');

    // Route::post('coupon/apply', [CouponController::class,'apply'])->middleware('auth:sanctum');


    Route::any('stripe', [StripeController::class, 'stripe']);
    Route::any('/stripe/create-checkout-session', [StripeController::class, 'create_checkout_session'])->name('api.stripe.get_token');
    Route::any('/stripe/payment/callback', [StripeController::class, 'callback'])->name('api.stripe.callback');
    Route::any('/stripe/success', [StripeController::class, 'success'])->name('api.stripe.success');
    Route::any('/stripe/cancel', [StripeController::class, 'cancel'])->name('api.stripe.cancel');

    Route::any('paypal/payment/url', [PaypalController::class, 'getUrl'])->name('api.paypal.url');
    Route::any('paypal/payment/done', [PaypalController::class, 'getDone'])->name('api.paypal.done');
    Route::any('paypal/payment/cancel', [PaypalController::class, 'getCancel'])->name('api.paypal.cancel');

    Route::any('razorpay/pay-with-razorpay', [RazorpayController::class, 'payWithRazorpay'])->name('api.razorpay.payment');
    Route::any('razorpay/payment', [RazorpayController::class, 'payment'])->name('api.razorpay.payment');
    Route::post('razorpay/success', [RazorpayController::class, 'success'])->name('api.razorpay.success');

    Route::any('paystack/init', [PaystackController::class, 'init'])->name('api.paystack.init');
    Route::post('paystack/success', [PaystackController::class, 'success'])->name('api.paystack.success');

    Route::any('iyzico/init', [IyzicoController::class, 'init'])->name('api.iyzico.init');
    Route::any('iyzico/callback', [IyzicoController::class, 'callback'])->name('api.iyzico.callback');
    Route::post('iyzico/success', [IyzicoController::class, 'success'])->name('api.iyzico.success');

    Route::get('bkash/begin', [BkashController::class, 'begin'])->middleware('auth:sanctum');
    Route::get('bkash/api/webpage/{token}/{amount}', [BkashController::class, 'webpage'])->name('api.bkash.webpage');
    Route::any('bkash/api/checkout/{token}/{amount}', [BkashController::class, 'checkout'])->name('api.bkash.checkout');
    Route::any('bkash/api/execute/{token}', [BkashController::class, 'execute'])->name('api.bkash.execute');
    Route::any('bkash/api/fail', [BkashController::class, 'fail'])->name('api.bkash.fail');
    Route::any('bkash/api/success', [BkashController::class, 'success'])->name('api.bkash.success');
    Route::post('bkash/api/process', [BkashController::class, 'process'])->name('api.bkash.process');

    Route::get('nagad/begin', [NagadController::class, 'begin'])->middleware('auth:sanctum');
    Route::any('nagad/verify/{payment_type}', [NagadController::class, 'verify'])->name('app.nagad.callback_url');
    Route::post('nagad/process', [NagadController::class, 'process']);

    Route::get('sslcommerz/begin', [SslCommerzController::class, 'begin']);
    Route::post('sslcommerz/success', [SslCommerzController::class, 'payment_success']);
    Route::post('sslcommerz/fail', [SslCommerzController::class, 'payment_fail']);
    Route::post('sslcommerz/cancel', [SslCommerzController::class, 'payment_cancel']);

    Route::any('flutterwave/payment/url', [FlutterwaveController::class, 'getUrl'])->name('api.flutterwave.url');
    Route::any('flutterwave/payment/callback', [FlutterwaveController::class, 'callback'])->name('api.flutterwave.callback');

    Route::any('paytm/payment/pay', [PaytmController::class, 'pay'])->name('api.paytm.pay');
    Route::any('paytm/payment/callback', [PaytmController::class, 'callback'])->name('api.paytm.callback');

    Route::post('payments/pay/wallet', [WalletController::class, 'processPayment'])->middleware('auth:sanctum');
    Route::post('payments/pay/cod', [PaymentController::class, 'cashOnDelivery'])->middleware('auth:sanctum');
    Route::post('payments/pay/manual', [PaymentController::class, 'manualPayment'])->middleware('auth:sanctum');

    Route::post('offline/payment/submit', [OfflinePaymentController::class, 'submit'])->name('api.offline.payment.submit');

    Route::post('order/store', [OrderController::class, 'store'])->middleware('auth:sanctum');
    Route::get('profile/counters', [ProfileController::class, 'counters'])->middleware('auth:sanctum');
    Route::post('profile/update', [ProfileController::class, 'update'])->middleware('auth:sanctum');
    Route::post('profile/update-device-token', [ProfileController::class, 'update_device_token'])->middleware('auth:sanctum');
    Route::post('profile/update-image', [ProfileController::class, 'updateImage'])->middleware('auth:sanctum');
    Route::post('profile/image-upload', [ProfileController::class, 'imageUpload'])->middleware('auth:sanctum');
    Route::post('profile/check-phone-and-email', [ProfileController::class, 'checkIfPhoneAndEmailAvailable'])->middleware('auth:sanctum');

    Route::post('file/image-upload', [FileController::class, 'imageUpload'])->middleware('auth:sanctum');

    Route::get('wallet/balance', [WalletController::class, 'balance'])->middleware('auth:sanctum');
    Route::get('wallet/history', [WalletController::class, 'walletRechargeHistory'])->middleware('auth:sanctum');
    Route::post('wallet/offline-recharge', [WalletController::class, 'offline_recharge'])->middleware('auth:sanctum');

    Route::get('flash-deals', [FlashDealController::class, 'index']);
    Route::get('flash-deal-products/{id}', [FlashDealController::class, 'products']);

    //Addon list
    Route::get('addon-list', [ConfigController::class, 'addon_list']);
    //Activated social login list
    Route::get('activated-social-login', [ConfigController::class, 'activated_social_login']);

    //Business Sttings list
    Route::post('business-settings', [ConfigController::class, 'business_settings']);
    //Pickup Point list
    Route::get('pickup-list', [ShippingController::class, 'pickup_list']);
});

Route::fallback(function () {
    return response()->json([
        'data' => [],
        'success' => false,
        'status' => 404,
        'message' => 'Invalid Route'
    ]);
});
