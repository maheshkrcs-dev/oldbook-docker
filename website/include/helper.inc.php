<?php

function cleanFileName($file){
    $file = strtolower($file);
    $file = preg_replace('/[^a-z0-9\.\-]/', '-', $file);
    return time() . '-' . $file;
}

function uploadImage($file){

    $targetDir = "assets/images/";

    if(!is_dir($targetDir)){
        mkdir($targetDir, 0777, true);
    }

    /* VALIDATION */
    $allowed = ['image/jpeg','image/png','image/jpg'];

    if(!in_array($file['type'], $allowed)){
        return ['status'=>false,'msg'=>'Only JPG, PNG allowed'];
    }

    if($file['size'] > 2*1024*1024){
        return ['status'=>false,'msg'=>'File too large (max 2MB)'];
    }

    /* GENERATE HASH NAME (PREVENT DUPLICATES) */
    $fileHash = md5_file($file['tmp_name']);
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $fileName = $fileHash . "." . $ext;

    $targetFile = $targetDir . $fileName;

    /* IF FILE ALREADY EXISTS → SKIP UPLOAD */
    if(file_exists($targetFile)){
        return ['status'=>true,'name'=>$fileName];
    }

    /* COMPRESS IMAGE */
    $compressed = compressImage($file['tmp_name'], $targetFile, 70);

    if($compressed){
        return ['status'=>true,'name'=>$fileName];
    }

    return ['status'=>false,'msg'=>'Upload failed'];
}
function compressImage($source, $destination, $quality){

    $info = getimagesize($source);

    if($info['mime'] == 'image/jpeg'){
        $image = imagecreatefromjpeg($source);
        return imagejpeg($image, $destination, $quality);
    }
    elseif($info['mime'] == 'image/png'){
        $image = imagecreatefrompng($source);

        // Convert PNG to JPEG for compression
        imagejpeg($image, $destination, $quality);

        return true;
    }

    return false;
}
?>