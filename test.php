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
    //echo 'Folder created successfully';
} else {
   // echo 'Folder creation failed';
}

$remotePath = $remote_folder.'/image.png';

$img = str_replace(' ', '+', $newBase64);
$data = base64_decode($img);

if (ftp_put($conn, $remotePath, $data, FTP_BINARY)) {
//    echo "Image saved as  on FTP server";
	$response = ['newBase64' => $newBase64];
	echo json_encode($response);

} else {
 //   echo 'Image upload failed';
	echo json_encode(['newBase64' => 'error']);
}

ftp_close($conn);



?>