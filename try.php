<?php
function deleteFiles($dir)
{
    // loop through the files one by one
    foreach(glob($dir . '/*') as $file){
        // check if is a file and not sub-directory
        if(is_file($file)){
            // delete file
            unlink($file);
        }
    }
}
?>