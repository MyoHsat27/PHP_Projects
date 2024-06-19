<?php
require_once ModelDir."/Wishlist.php";
class WishlistController {
    // View Function
    public function wishlistView(): void {
        view("user/wishlist");
    }

    // Operation Functions
    public function checkWish($productId, $userId): bool {
        $wishlist = new Wishlist();
        $result = $wishlist->checkWish($productId, $userId);
        if ($result) {
            return true;
        }
        return false;
    }

    public function addWishlist(): void {
        if (checkCustomerLogin()) {
            $productId = $_POST['productId'];
            $userId = $_POST['userId'];

            $wishlist = new Wishlist();
            $result = $wishlist->create($productId, $userId);

            if ($result) {
                redirectBack("Added to wishlist successfully", "wishlist-add-success");
            }
        } else {
            redirectBack("Login to Process", "login-to-process");
        }
    }
    public function removeWishlist(): void {
        if (checkCustomerLogin()) {
            $productId = $_POST['productId'];
            $userId = $_POST['userId'];

            $wishlist = new Wishlist();
            $result = $wishlist->remove($productId, $userId);

            if ($result) {
                redirectBack("Removed from wishlist successfully", "wishlist-remove-success");
            }
        } else {
            redirectBack("Login to Process", "login-to-process");
        }
    }






}