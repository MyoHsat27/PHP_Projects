<?php
$uriArr = parse_url($_SERVER['REQUEST_URI']);
$path = $uriArr['path'];

const Routes = [
  // User Auth Routes
    "/login" => "AuthController@loginView",
    "/logout" => "AuthController@logout",
    "/logout-admin" => "AuthController@logoutAdmin",
    "/user-login" => ["post","AuthController@login"],
    "/user-signup" => ["post","AuthController@signUp"],

    // User Product Routes
    "/" => "HomeController@index",
    "/shop" => "ShopController@index",
    "/products" => "ProductController@productsView",
    "/product" => "ProductController@productView",

    // User Profile Routes
    "/profile" => "ProfileController@profileView",
    "/profile-edit" => ["post", "ProfileController@profileEdit"],
    "/profile-update-default-address" => ['put', "ProfileController@updateAddress"],

    "/address" => "AddressController@addressView",
    "/address-create" => ['post', "AddressController@createAddress"],
    "/address-create-ajax" => ['post', "AddressController@createAddressAjax"],
    "/address-edit" => "AddressController@updateView",
    "/address-update" => ['put', "AddressController@updateAddress"],
    "/address-delete" => ['delete', "AddressController@deleteAddress"],

    "/orders" => "OrderController@orderView",
    "/order" => "OrderController@orderNowView",
    "/order-create" => ['post',"OrderController@createOrder"],

    "/cart" => "CartController@cartView",
    "/cart-add" => ['post', "CartController@addCart"],
    "/cart-remove" => ['delete', "CartController@removeCart"],
    "/cart-remove-all" => ['delete', "CartController@removeAllCart"],
    "/nonactive-cart-remove" => ['delete', "CartController@removeNonActiveCart"],
    "/nonacitve-cart-remove-all" => ['delete', "CartController@removeAllNonactiveCart"],

    "/wishlist" => "WishlistController@wishlistView",
    "/wishlist-add" => ['post', "WishlistController@addWishlist"],
    "/wishlist-remove" => ['delete',"WishlistController@removeWishlist"],

  // Admin Routes
  "/admin/product" => "ProductController@index",
    "/admin/product-create" => "ProductController@createView",
    "/admin/product-store" => ["post","ProductController@create"],
    "/admin/product-edit" => "ProductController@updateView",
    "/admin/product-update" => ["put","ProductController@update"],
    "/admin/product-delete" => ["delete","ProductController@delete"],
    "/admin/product-detail" => "ProductController@detailView",

  "/admin/stock" => "StockController@index",
    "/admin/stock-edit" => "StockController@updateView",
    "/admin/stock-update" => ["put","StockController@update"],
    "/admin/stock-detail" => "StockController@detailView",

  "/admin/category" => "CategoryController@index",
    "/admin/category-create" => "CategoryController@createView",
    "/admin/category-store" => ["post","CategoryController@create"],
    "/admin/category-edit" => "CategoryController@updateView",
    "/admin/category-update" => ["put","CategoryController@update"],
    "/admin/category-delete" => ["delete","CategoryController@delete"],

  "/admin/discount" => "DiscountController@index",
    "/admin/discount-create" => "DiscountController@createView",
    "/admin/discount-store" => ["post","DiscountController@create"],
    "/admin/discount-edit" => "DiscountController@updateView",
    "/admin/discount-update" => ["put","DiscountController@update"],
    "/admin/discount-add" => "DiscountController@addDiscountView",
    "/admin/discount-added" => ["post","DiscountController@addDiscount"],
    "/admin/discount-detail" => "DiscountController@detailView",
    "/admin/discount-delete" => ["delete","DiscountController@delete"],

    "/admin/location" => "LocationController@index",
    "/admin/location-create" => "LocationController@createView",
    "/admin/location-store" => ["post","LocationController@create"],
    "/admin/location-edit" => "LocationController@updateView",
    "/admin/location-update" => ["put","LocationController@update"],
    "/admin/location-detail" => "LocationController@detailView",

  "/admin/order" => "OrderController@index",

];

if (array_key_exists($path, Routes) && is_array(Routes[$path]) && checkRequestMethod(Routes[$path][0])) {
    controller(Routes[$path][1]);
} elseif (array_key_exists($path, Routes) && !is_array(Routes[$path])) {
    controller(Routes[$path]);
} else {
    view("404");
}