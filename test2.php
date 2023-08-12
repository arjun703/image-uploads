<?php

function generateRandomString(){
    $length = 50;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}


function returnBase64($base64Image){

    // Decode base64 image
    $decodedImage = base64_decode($base64Image);

    // Create image resource from decoded data
    $originalImage = imagecreatefromstring($decodedImage);

    // Original image dimensions
    $originalWidth = imagesx($originalImage);
    $originalHeight = imagesy($originalImage);

    // Border size (adjust as needed)
    $borderSize = 30;

    // New image dimensions with border
    $newWidth = $originalWidth + 2 * $borderSize;
    $newHeight = $originalHeight + 2 * $borderSize;

    // Create new image with border
    $newImage = imagecreatetruecolor($newWidth, $newHeight);

    // Allocate white color
    $whiteColor = imagecolorallocate($newImage, 255, 255, 255);

    // Fill the new image with white background
    imagefill($newImage, 0, 0, $whiteColor);

    // Copy the original image onto the new image with border
    imagecopy(
        $newImage,         // Destination image
        $originalImage,    // Source image
        $borderSize,       // Destination X-coordinate (border offset)
        $borderSize,       // Destination Y-coordinate (border offset)
        0,                 // Source X-coordinate (start from left)
        0,                 // Source Y-coordinate (start from top)
        $originalWidth,    // Width of the portion to copy
        $originalHeight    // Height of the portion to copy
    );

    // Start buffering the output
    ob_start();

    // Output the new image as PNG and capture the output
    imagepng($newImage);

    // Get the captured output
    $imageData = ob_get_contents();

    // Clean up the buffer
    ob_end_clean();

    // Encode the modified image data as base64
    $newBase64Image = base64_encode($imageData);

    // // Send the new base64 image string in the response
    // header('Content-Type: application/json');
    // $response = ['newBase64' => $newBase64Image];
    // echo json_encode($response);

    // Free up memory
    imagedestroy($originalImage);
    imagedestroy($newImage);

    return $newBase64Image;

}

?>