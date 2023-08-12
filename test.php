<?php 

require 'test2.php';

$newBase64 = returnBase64($_POST['base64String']);

$ftp_server = 'dedi5317.your-server.de';
$ftp_user = 'memorb_0';
$ftp_pass = 'bjFMfgz7G9e951KL';

$conn = ftp_ssl_connect($ftp_server);

if (!$conn) {
    die('Could not connect to the FTP server');
}

$login = ftp_login($conn, $ftp_user, $ftp_pass);
if (!$login) {
    die('FTP login failed');
}

$unique_folder = generateRandomString();

$remote_folder = $unique_folder;

if (ftp_mkdir($conn, $remote_folder)) {

	// Decode base64 data
	$imageData = base64_decode($newBase64);

	// Specify the file path to save the image
	$uniqueImageName =  generateRandomString();

	$localFilePath = $uniqueImageName.'.png';

	// Save the image data to the file
	file_put_contents($localFilePath, $imageData);

	$remotePath = "{$remote_folder}/{$uniqueImageName}.png";

	if (ftp_put($conn, $remotePath, $localFilePath, FTP_BINARY)) {

		unlink($localFilePath);
		$response = ['newBase64' => $newBase64];
		echo json_encode($response);

	} else {
	 //  echo 'Image upload failed';
		echo json_encode(['newBase64' => 'error']);
	}


} else {
   // echo 'Folder creation failed';
}

ftp_close($conn);

?>