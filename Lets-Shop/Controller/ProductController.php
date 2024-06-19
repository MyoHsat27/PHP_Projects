<?php
require_once ControllerDir."/FileController.php";
require_once ControllerDir."/StockController.php";
require_once ModelDir."/Product.php";
require_once ModelDir."/ProductCategoryRelation.php";

class ProductController {
    private object $product;

    public function __construct() {
        $this->product = new Product();
    }

    // View Functions (Admin View)
    public function index(): void {
        view("admin/product/product");
    }

    public function createView(): void {
        view("admin/product/create");
    }

    public function updateView(): void {
        $data = $this->product->getId($_GET['id']);
        $oldCategories = $this->product->getCategories($_GET['id']);
        $quantity = $this->product->getIdQuantity($_GET['id']);
        if ($data) {
            view("admin/product/update", ["data" => $data, "oldCategories" => $oldCategories, "quantity" => $quantity]);
        } else {
            redirect(route("admin/product"), "No Such Category Item", "error");
        }
    }

    public function detailView(): void {
        $productData = $this->product->getId($_GET['id']);
        $categories = $this->product->getCategories($_GET['id']);
        $quantity = $this->product->getIdQuantity($_GET['id']);
        if ($productData) {
            view("admin/product/detail", ["productData" => $productData, "categories" => $categories, "quantity" => $quantity]);
        } else {
            redirect(route("admin/detail"), "No Such Category Item", "error");
        }
    }

    // View Functions (User View)
    public function productView(): void {
        view("user/product");
    }

    public function productsView(): void {
        view("user/products");
    }

    // Operation Functions

    public function update(): void {
        if (!empty($_POST)) {
            $productId = $_POST['productId'];
            $productName = $_POST['productName'];
            $productCategories = $_POST['productCategories'];
            $productOldCategories = $_POST['productOldCategories'];
            $productDescription = $_POST['productDescription'];
            $productOldImage = $_POST['productOldImage'];
            $productPrice = $_POST['productPrice'];
            $productSale = isset($_POST['productSaleNow']) ? "true" : "false";
            $fileController = new FileController();

            // Delete and Add Category
            $productCategoryRelation = new ProductCategoryRelation();
            if (isset($_POST['productCategories']) && isset($_POST['productOldCategories'])) { // When Old Categories exist
                foreach ($productCategories as $productCategory) { // Adding New Category
                    if (!in_array($productCategory, $productOldCategories)) {
                        $result = $productCategoryRelation->create($productId, $productCategory);
                    }
                }
                foreach ($productOldCategories as $productOldCategory) { // Removing Old Category
                    if (!in_array($productOldCategory, $productCategories)) {
                        $result = $productCategoryRelation->delete($productId, $productOldCategory);
                    }
                }
            } elseif (isset($_POST['productCategories']) && !isset($_POST['productOldCategories'])) { // When Old Categories not exist
                foreach ($productCategories as $productCategory) { // Adding New Category
                    $result = $productCategoryRelation->create($productId, $productCategory);
                }
            } else { // Removing All Category
                foreach ($productOldCategories as $productOldCategory) {
                    $result = $productCategoryRelation->delete($productId, $productOldCategory);
                }
            }

            // Delete Old Image and Add New Image
            if (!empty($productOldImage) && !empty($_FILES['productImage']['name'])) {
                $fileController->delete($productOldImage);
            }
            if (!empty($_FILES['productImage']['name'])) {
                $productNewImage = $fileController->upload();
                $result = $this->product->update($productId, $productName, $productDescription, $productPrice, $productSale, $productNewImage);
            } else {
                $result = $this->product->update($productId, $productName, $productDescription, $productPrice, $productSale, $productOldImage);
            }

            if ($result) {
                redirect(route("admin/product"), "$productName updated successfully");
            } else {
                redirectBack("Product couldn't be updated", "error");
            }
        }
    }

    public function create(): void {
        if (!empty($_POST)) {
            $productName = $_POST['productName'];
            $productCategories = $_POST['productCategories'];
            $productDescription = $_POST['productDescription'];
            $productPrice = $_POST['productPrice'];
            $productStock = $_POST['productStock'];
            $productSale = isset($_POST['productSaleNow']) ? "true" : "false";

            // Stock Control
            $stockController = new StockController();
            $productStockId = $stockController->create($productStock);

            // Image Control
            $fileUpload = new FileController();
            $productImage = $fileUpload->upload();

            $query = $this->product->create($productName, $productDescription, $productPrice, $productStockId, $productSale, $productImage);
            $result = $query['result'];
            $productId = $query['productId'];

            if ($result) {
                // Category Control
                $productCategoryRelation = new ProductCategoryRelation();
                foreach ($productCategories as $productCategory) {
                    $productCategoryRelation->create($productId, $productCategory);
                }
                redirect(route("admin/product"), "$productName product created successfully");
            } else {
                redirectBack("Product couldn't be created");
            }
        }
    }

    public function delete(): void {
        $productId = $_POST['productId'];
        $productImage = $_POST['productImage'];
        $stockId = $_POST['stockId'];

        if (!empty($_POST['productCategories'])) {
            $productCategories = $_POST['productCategories'];
            foreach ($productCategories as $productCategory) {
                $productCategoryRelation = new ProductCategoryRelation();
                $result = $productCategoryRelation->delete($productId, $productCategory);
            }
        }

        $result = $this->product->delete($productId);

        $fileController = new FileController();
        $fileController->delete($productImage);

        $stockController = new StockController();
        $result = $stockController->delete($stockId);

        if ($result) {
            redirect(route("admin/product"), "Product Delete Successfully");
        } else {
            redirectBack("Product Couldn't Delete", "error");
        }
    }
}