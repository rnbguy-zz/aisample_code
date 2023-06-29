<html>
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-38968523-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-38968523-2');
</script>

        <link rel="stylesheet" type="text/css" href="../css/reset.css">
        <link rel="stylesheet" type="text/css" href="../css/main.css">

<style>
body {
  color: blue;
  font-size: 45px;
  line-height: 1.6;
}
</style>
<!-- Snap Pixel Code -->
<script type='text/javascript'>
(function(e,t,n){if(e.snaptr)return;var a=e.snaptr=function()
{a.handleRequest?a.handleRequest.apply(a,arguments):a.queue.push(arguments)};
a.queue=[];var s='script';r=t.createElement(s);r.async=!0;
r.src=n;var u=t.getElementsByTagName(s)[0];
u.parentNode.insertBefore(r,u);})(window,document,
'https://sc-static.net/scevent.min.js');

snaptr('init', '5c8024ba-98b4-49ed-bc60-e85fca24cd9e', {
'user_email': '__INSERT_USER_EMAIL__'
});

snaptr('track', 'PAGE_VIEW');

</script>
<!-- End Snap Pixel Code -->
</head>
<body>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
error_log($target_file);
//rename file to avoid cache issues
$newname = time(). basename($_FILES["fileToUpload"]["name"]);

$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
	//echo "path:".$_FILES["fileToUpload"]["tmp_name"];
        $uploadOk = 1;
	error_log("upload SUCCESS");
    } else {
        $uploadOk = 0;
	error_log("failed to upload file");
    }
// Check if file already exists
if (file_exists($target_file)) {
    //Sorry, file already exists
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 15000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded, our engineers are working on this.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir.$newname)) {
        echo "";
	error_log("move SUCCESS");
    } else {
        echo "Sorry, there was an error scanning your file.".$_FILES["fileToUpload"]["tmp_name"]."<br/>";
    }
}


}//end form action

// echo memory used
error_log("memory used:".memory_get_usage());

?>

<?php

#facedetect
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
$filename = "/var/www/html/uploads/".$newname;
$exif = exif_read_data($filename, 0, true);

#shrink large images
$image="/var/www/html/uploads/".$newname;
$target_file = "/var/www/html/uploads/".$newname;
list($width, $height) = getimagesize($image);
$modwidth = 500;
$diff = $width / $modwidth;
$modheight = $height / $diff;
$dest = imagecreatetruecolor($modwidth, $modheight);
$src = imagecreatefromjpeg($image);
imagecopyresampled($dest, $src, 0, 0, 0, 0, $modwidth, $modheight, $width, $height);
imagejpeg($dest, $target_file, 100);

// echo memory used copy resampled
error_log("memory used2:".memory_get_usage());
if($width > $height)
{
//rotate some files
$rotate = imagerotate($src, 270, 0);
imagejpeg($rotate, $filename, 90);
imagedestroy($rotate);
}

imagedestroy($src);

#faceai
$faceurl="https://www.lasemedics.com.au/uploads/".$newname;
$facedata = array("Url" => $faceurl);
$facedata_string = json_encode($facedata);

//image is cut into 4 pieces
$count=0;
echo '<article class="therapistsArea" style="font-family:Baskerville;">';

$url="https://www.lasemedics.com.au/uploads/".$newname;

$data = array("Url" => $url);
$data_string = json_encode($data);


$ch = curl_init('https://facedetect3.cognitiveservices.azure.com/customvision/v3.0/Prediction/34186295-ad2b-47a1-9973-9be4676b4af0/classify/iterations/Iteration2/url');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Prediction-Key: 986e6462a14c466d8c1fb25e3d614d60')
);

$result = curl_exec($ch);

curl_close ($ch);


$json = json_decode($result, true);
//troubleshooting debug
//var_dump(json_decode($result));

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
$detectedconcerns=0;

//echo $json['predictions']['0']['tagName']."<br/>";
//echo $_POST['item']."<br/>";

if ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['probability'] < 0.71 && $json['predictions']['0']['tagName'] == $_POST['item'])
{
 $detectedconcerns=1;
 echo "<br/><br/><center><b>Your drawing, item or acting looks ".round($json['predictions']['0']['probability']*100,0)."% like a ".$_POST['item'].". You came in 5TH PLACE!!!";
}
elseif ($json['predictions']['0']['probability'] > 0.70 && $json['predictions']['0']['probability'] < 0.91 && $json['predictions']['0']['tagName'] == $_POST['item'])
{
 $detectedconcerns=1;
 echo "<br/><br/><center><b>Your drawing, item or acting looks ".round($json['predictions']['0']['probability']*100,0)."% like a ".$_POST['item'].". You came in 2ND PLACE!!!";
}
elseif ($json['predictions']['0']['probability'] > 0.90 && $json['predictions']['0']['tagName'] == $_POST['item'])
{
 $detectedconcerns=1;
 echo "<br/><br/><center><b>NICE!! Your drawing, item or acting looks ".round($json['predictions']['0']['probability']*100,0)."% like a ".$_POST['item'].". You came in 1ST PLACE!!!";
} 

if ($detectedconcerns==0)
{
echo '<center><br/><b>Other players won!!</b> ';
}

}//end if post

 echo '
<br/>
</article>

<center>
<div style="color:red;font-size:14px;">
</div>
</center>

<br/><br/>

</article>

';


//remove uploaded file
unlink( "/var/www/html/uploads/".$newname);

//imagedestroy($dest);
//imagedestroy($src);
//imagedestroy($image);

$vars = array_keys(get_defined_vars());
for ($i = 0; $i < sizeOf($vars); $i++) {
    unset($$vars[$i]);
}
unset($vars,$i);

flush();
gc_collect_cycles();
ob_flush();


// echo memory used
error_log("memory used4:".memory_get_usage());

}

?>
<br><center>
<center><br><br/><b><div class="button" style="width:70%;"><a href="https://www.lasemedics.com.au/detectl.php" onclick='handleOutboundLinkClicks(event)' style="text-decoration: none;color:white;">PLAY AGAIN </a> </div> </b> </center>
<br/><br/><br/>


</body>
</html>
