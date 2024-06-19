<?php

class FileController {
    function upload () : string {
        if ($_FILES['productImage']['error'] === 0) {
            print_r($_FILES['productImage']);
            $fileName = pathinfo($_FILES['productImage']['name'])['filename'];
            $extension = pathinfo($_FILES['productImage']['name'])['extension'];

            $newFileName = md5($fileName.uniqid()).".".$extension;

            $tmpFile = $_FILES['productImage']['tmp_name'];
            move_uploaded_file($tmpFile, ImgDir."/productImage/$newFileName");

            return $newFileName;
        } else {
            dd("File upload failed");
        }
    }
    function delete ($image_path) : void {
        unlink(ImgDir."/productImage/".$image_path);
    }
}