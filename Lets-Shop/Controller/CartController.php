<?php
require_once ModelDir."/Cart.php";
require_once ModelDir."/Product.php";

class CartController {

    // View Function
    public function cartView(): void {
        view("user/cart");
    }

    // Operation Functions
    public function addCart(): void {
        if (checkCustomerLogin()) {
            $productId = $_POST['productId'];
            $userId = $_POST['userId'];

            $cart = new Cart();
            $result = $cart->create($productId, $userId);

            if ($result) {
                redirectBack("Added to cart successfully", "cart-add-success");
            }
        } else {
            redirectBack("Login to Process", "login-to-process");
        }

    }
    public function removeCart(): void {
        if (checkCustomerLogin()) {
            $productId = $_POST['productId'];
            $userId = $_POST['userId'];

            $cart = new Cart();
            $result = $cart->remove($productId, $userId);

            if ($result) {
                redirectBack("Removed from cart successfully", "cart-remove-success");
            }
        }
    }
    public function removeAllCart(): void {
        if (checkCustomerLogin()) {
            $cart = new Cart();
            $result = $cart->removeAll($_SESSION['user_id']);
            if ($result) {
                redirectBack("Cleared the cart successfully", "cart-remove-success");
            }
        }
    }
    public function removeNonActiveCart() : void {
        if (checkCustomerLogin()) {
            $productId = $_POST['productId'];
            $userId = $_POST['userId'];

            $cart = new Cart();
            $result = $cart->removeNonActive($productId, $userId);
            if ($result) {
                redirectBack("Remove the non-active product successfully", "cart-remove-success");
            }
        }
    }
    public function removeAllNonactiveCart () : void {
        if (checkCustomerLogin()) {
            $cart = new Cart();
            $cartProducts = $cart->getCartProductsId($_SESSION['user_id']);

            // Get Non-Active Products' ID
            $nonActiveProductIds = [];
            $productObj = new Product();
            foreach ($cartProducts as $cartProduct) {
                $cartProductsInfo = $productObj->getId($cartProduct->product_id);
                if (!$cartProductsInfo->active_sale) {
                    $nonActiveProductIds[] = $cartProduct->product_id;
                }
            }

            $result = false;
            foreach ($nonActiveProductIds as $nonActiveProductId) {
                $result = $cart->removeNonActive($nonActiveProductId, $_SESSION['user_id']);
            }

            if ($result) {
                redirectBack("Cleared the non-available products successfully", "cart-remove-success");
            }
        }
    }


    // Fetching Functions
    public function checkCart($productId, $userId): bool {
        $cart = new Cart();
        $result = $cart->checkCart($productId, $userId);
        if ($result) {
            return true;
        }
        return false;
    }
}