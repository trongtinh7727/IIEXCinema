<?php

class UploadHelper
{

    public function uploadFile($file_name,$file)
    {
        $target_dir = SITE_ROOT."/assets/uploads/".$file_name."/";
        $target_file = $target_dir . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $new_file_name =  uniqid($file_name, true) . '.' . $imageFileType;
        $target_file = $target_dir . $new_file_name;
        $res = '../assets/uploads/' .$file_name."/". $new_file_name;
        // Check if image file is a actual image or fake image

        $check = getimagesize($file["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            return 0;
        }
        // check if flie already exists
        if (file_exists($target_file)) {
            return 0;
        }

        // check size
        if ($file["size"] > 500000) {
            echo "Sorry, your file is too large.";
            return 0;
        }

        // check file type
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            return 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                return $res;
            }
        }
    }
}
