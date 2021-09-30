<?php
if (($_FILES["file"]["type"] == "image/pjpeg")
    || ($_FILES["file"]["type"] == "image/jpeg")
    || ($_FILES["file"]["type"] == "image/jpg")
    || ($_FILES["file"]["type"] == "image/png")
    || ($_FILES["file"]["type"] == "image/gif")
) {
    // if (move_uploaded_file($_FILES["file"]["tmp_name"], "comprobantes/".$_FILES['file']['name'])) {
        $temp = explode(".", $_FILES["file"]["name"]);
        $temp2 = getcwd();
        $newfilename = round(microtime(true)) . '-' . rand(10000, 99999) . chr(rand(65, 90)) . '.' . end($temp);
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $temp2 . "/marcadas/comprobantes/" . $newfilename)) {
            //more code here...
            // echo "comprobantes/".$_FILES['file']['name'];
            echo $newfilename;
        } else {
            echo 0;
        }
} else {
    echo 0;
}
