<?php

function getFileupload($file) {
    // allow maximum is 20MB
    $folder =__SITE_PATH."/upload/document";
    $size = 20 * 1024*1024;
    $allow_type = array('application/pdf', 'application/msword');
    $datecreated = date('YmdHis');
    if ($_FILES[$file]["error"] == 0)
        if ($_FILES[$file]["size"] < $size) {
            $file_type = $_FILES[$file]["type"];
            if (!in_array($file_type, $allow_type))
                return NULL;
            move_uploaded_file($_FILES[$file]["tmp_name"], $folder . '/' . $datecreated . "_" . $_FILES[$file]["name"]);
            //echo "Upload success";
            return $datecreated . "_" . $_FILES[$file]["name"];
        }
        else
            return;
}

?>
