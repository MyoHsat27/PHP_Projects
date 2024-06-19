<?php
require_once ModelDir."/Category.php";

class CategoryController {
    private object $category;

    public function __construct() {
        $this->category = new Category();
    }

    // View Functions
    public function index () : void {
        view("admin/category/category");
    }
    public function createView () : void {
        view("admin/category/create");
    }
    public function updateView () : void {
        $data = $this->category->getId($_GET['id']);
        if ($data) {
            view("admin/category/update", ["data" => $data]);
        } else {
            redirect(route("admin/category"),"No Such Category Item", "error");
        }
    }

    // Operation Functions
    public function create () : void {
        if (!empty($_POST)) {
            $categoryName = $_POST['categoryName'];
            $categoryDescription = $_POST['categoryDescription'];
            $query = $this->category->create($categoryName,$categoryDescription);
            if ($query) {
                redirect(route("admin/category"),"$categoryName category created successfully");
            } else {
                redirectBack("Create Failed", "error");
            }
        }
    }
    public function update () : void {
        if (!empty($_POST)) {
            $categoryId = $_POST['categoryId'];
            $categoryName = $_POST['categoryName'];
            $categoryDescription = $_POST['categoryDescription'];
            $query = $this->category->update($categoryId,$categoryName,$categoryDescription);
            if ($query) {
                redirect(route("admin/category"),"$categoryName category edited successfully");
            } else {
                redirectBack("Update Failed", "error");
            }
        }
    }
    public function delete () : void {
        if (!empty($_POST)) {
            $categoryId = $_POST['categoryId'];
            $categoryName = $_POST['categoryName'];
            $query = $this->category->delete($categoryId);
            if ($query) {
                redirect(route("admin/category"),"$categoryName category deleted successfully");
            } else {
                redirectBack("Delete Failed", "error");
            }
        }
    }

}