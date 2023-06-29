
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

$facech = curl_init('https://australiaeast.api.cognitive.microsoft.com/face/v1.0/detect');
curl_setopt($facech, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($facech, CURLOPT_POSTFIELDS, $facedata_string);
curl_setopt($facech, CURLOPT_RETURNTRANSFER, true);
curl_setopt($facech, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Ocp-Apim-Subscription-Key: cc231bd1ce2e43a2b4a80c1acc88f1cb')
);

$faceresult = curl_exec($facech);

curl_close ($facech);

$facejson = json_decode($faceresult, true);
//troubleshooting debug
//var_dump(json_decode($faceresult));
error_log($faceresult);

//crop 
$width=$facejson['0']['faceRectangle']['width'];
$height=$facejson['0']['faceRectangle']['height'];
$x=$facejson['0']['faceRectangle']['left'];
$y=$facejson['0']['faceRectangle']['top'];
$image="/var/www/html/uploads/".$newname;
$target_file = "/var/www/html/uploads/".$newname;

//find size of one quarter of image
$headslices=$height/4;
error_log("heightslices::::".$headslices);


//start crop, crop forehead
$middlefacetop=$y-30;
$middlefaceheight=$headslices+30;

$dest = imagecreatetruecolor($width, $middlefaceheight);
$src = imagecreatefromjpeg($image);
imagecopyresampled($dest, $src, 0, 0, $x, $middlefacetop, $width, $middlefaceheight, $width, $middlefaceheight);
imagejpeg($dest, $target_file . "_cropforehead.jpg", 100);

// echo memory used
error_log("memory used3:".memory_get_usage());

//crop cheeks

$middlefacetop=($y+30)+$headslices;
$middlefaceheight=($headslices*2)-30;

$dest = imagecreatetruecolor($width, $middlefaceheight);
$src = imagecreatefromjpeg($image);
imagecopyresampled($dest, $src, 0, 0, $x, $middlefacetop, $width, $middlefaceheight, $width, $middlefaceheight);
imagejpeg($dest, $target_file . "_croplcheeks.jpg", 100);

//crop chin

$middlefacetop=$y+($headslices*3);
$middlefaceheight=$headslices;

$dest = imagecreatetruecolor($width, $middlefaceheight);
$src = imagecreatefromjpeg($image);
imagecopyresampled($dest, $src, 0, 0, $x, $middlefacetop, $width, $middlefaceheight, $width, $middlefaceheight);
imagejpeg($dest, $target_file . "_cropchin.jpg", 100);

//image is cut into 4 pieces
$count=0;
echo '<article class="therapistsArea" style="font-family:Baskerville;">';

while($count <= 2){
$count++;
#ai
if($count==1){
$url="https://www.lasemedics.com.au/uploads/".$newname."_cropforehead.jpg";
echo "<br/><div style='background-color: #b3e0ff;'>Skincare Tips for scanned forehead</div>";
}elseif($count==2){
$url="https://www.lasemedics.com.au/uploads/".$newname."_croplcheeks.jpg";
echo "<br/><div style='background-color: #b3e0ff;'>Skincare Tips for scanned cheeks</div>";
}elseif($count==3){
$url="https://www.lasemedics.com.au/uploads/".$newname."_cropchin.jpg";
echo "<br/><div style='background-color: #b3e0ff;'>Skincare Tips for scanned chin</div>";
}


$data = array("Url" => $url);
$data_string = json_encode($data);

$ch = curl_init('https://facedetect3.cognitiveservices.azure.com/customvision/v3.0/Prediction/7782aa90-2b24-4cae-93d7-a2aad84ed802/classify/iterations/Iteration2/url');
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

if ($json['predictions']['0']['probability'] > 0.20 && $json['predictions']['0']['tagName'] == "congestion")
{
 $detectedconcerns=1;
 echo "<center><br/><b> ".round(($json['predictions']['0']['probability']*100),0)."% .Congestion</b> Click <a href='https://www.lasemedics.com.au/skin/oily-acne-skin.php' style='color:blue;'>here to continue reading</a>.
<br/>
<iframe width='100%' height='315' src='https://www.youtube.com/embed/gmk-bwuTL4c' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/>
</center>";

}elseif ($json['predictions']['0']['probability'] > 0.20 && $json['predictions']['0']['tagName'] == "hormonal")
{
 $detectedconcerns=1;
 echo "<center><br/><b> ".round(($json['predictions']['0']['probability']*100),0)."% .Hormonal Breakouts.</b> Click <a href='https://www.lasemedics.com.au/skin/acne.php'style='color:blue;'>here to learn more about Hormonal Breakouts</a>.
<br/><iframe width='100%' height='315' src='https://www.youtube.com/embed/MrCm5e-3N9U' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/>
<b>Recommended day time routine:</b>
<br/>
<a target='_blank' style='color:blue;' href='https://www.amazon.com.au/gp/offer-listing/B014SAB948/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B014SAB948&linkCode=am2&tag=lasemedics-22&linkId=282c2b573ab9d9cf5b1d24d2fb67b8d6'>Cosrx Acne Pimple Master Patch 24Patches*4Sheet</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B014SAB948' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<br/>

</center>";
} elseif ($json['predictions']['0']['probability'] > 0.20 && $json['predictions']['0']['tagName'] == "pigmentation")
{
 $detectedconcerns=1;
 echo "<center><br/><b> ".round(($json['predictions']['0']['probability']*100),0)."% .Pigmentation/brownspots.</b> Click <a href='https://www.lasemedics.com.au/skin/pigmentation.php' style='color:blue;'>here to continue reading</a>.
<br/>
<iframe width='100%' height='315' src='https://www.youtube.com/embed/teK4HSNxeN4' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/>
<b>Recommended day time routine:</b>
<a target='_blank' style='color:blue;' href='https://www.amazon.com.au/gp/offer-listing/B00PL3DK26/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B00PL3DK26&linkCode=am2&tag=lasemedics-22&linkId=54e2196e3511f894c7169d79d2b1b78b'>20% Vitamin C Serum - Made in Canada - Certified Organic + 11% Hyaluronic Acid + Vitamin E Moisturizer + Collagen Boost - Reverse Skin Aging, Remove Sun Spots, Wrinkles and Dark Circles, Excellent for Sensitive Skin + Includes Pump &amp; Dropper 60 ml</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B00PL3DK26' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<br/>
</center>";
} elseif ($json['predictions']['0']['probability'] > 0.20 && $json['predictions']['0']['tagName'] == "redblem")
{
 $detectedconcerns=1;
 echo "<center><br/><b> ".round(($json['predictions']['0']['probability']*100),0)."% .Redness/rosacea.</b> Click <a href='https://www.lasemedics.com.au/skin/sensitive-or-sensitized.php' style='color:blue;'>here to continue reading</a>.
<br/>
<iframe width='100%' height='315' src='https://www.youtube.com/embed/nwwrBCwKyQM' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/>
<br/>
<b>Recommended day time routine:</b>
<br/><a target='_blank' style='color:blue;' href='https://www.amazon.com.au/gp/offer-listing/B001B8B6BC/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B001B8B6BC&linkCode=am2&tag=lasemedics-22&linkId=1f6edc04abf56e67cb1492b3874a2f6e'>Dermalogica Ultracalming Cleanser 8.4 oz</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B001B8B6BC' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<br/>

</center>";
} elseif ($json['predictions']['0']['probability'] > 0.20 && $json['predictions']['0']['tagName'] == "enlargedpores")
{
 $detectedconcerns=1;
 echo "<center><br/><b> ".round(($json['predictions']['0']['probability']*100),0)."% .Enlarged pores</b> Click <a href='https://www.lasemedics.com.au/skin/look-younger.php'style='color:blue;'>here to continue reading</a>.
<br/>
<iframe width='100%' height='315' src='https://www.youtube.com/embed/1pxs35XmBX8' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/>
</center>";
}


if ($json['predictions']['1']['probability'] > 0.20 && $json['predictions']['1']['tagName'] == "congestion")
{
 $detectedconcerns=1;
 echo "<center><br/><b> ".round(($json['predictions']['1']['probability']*100),0)."% .Congestion</b> Click <a href='https://www.lasemedics.com.au/skin/oily-acne-skin.php' style='color:blue;'>here to continue reading</a>.
<br/>
<iframe width='100%' height='315' src='https://www.youtube.com/embed/gmk-bwuTL4c' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/>

</center>";

}elseif ($json['predictions']['1']['probability'] > 0.20 && $json['predictions']['1']['tagName'] == "hormonal")
{
 $detectedconcerns=1;
 echo "<center><br/><b> ".round(($json['predictions']['1']['probability']*100),0)."% .Hormonal Breakouts.</b> Click <a href='https://www.lasemedics.com.au/skin/acne.php' style='color:blue;'>here to continue reading</a>.
<iframe width='100%' height='315' src='https://www.youtube.com/embed/MrCm5e-3N9U' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/>
<b>Recommended day time routine:</b>
<br/>
<a target='_blank' style='color:blue;' href='https://www.amazon.com.au/gp/offer-listing/B014SAB948/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B014SAB948&linkCode=am2&tag=lasemedics-22&linkId=282c2b573ab9d9cf5b1d24d2fb67b8d6'>Cosrx Acne Pimple Master Patch 24Patches*4Sheet</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B014SAB948' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<br/>
</center>";
} elseif ($json['predictions']['1']['probability'] > 0.20 && $json['predictions']['1']['tagName'] == "pigmentation")
{
 $detectedconcerns=1;
 echo "<center><br/><b> ".round(($json['predictions']['1']['probability']*100),0)."% .Pigmentation/brownspots.</b> Click <a href='https://www.lasemedics.com.au/skin/pigmentation.php' style='color:blue;'>here to continue reading</a>.
<br/>
<iframe width='100%' height='315' src='https://www.youtube.com/embed/teK4HSNxeN4' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/>
<br/>
<b>Recommended day time routine:</b>
<a target='_blank' style='color:blue;' style='color:blue;' style='color:blue;' href='https://www.amazon.com.au/gp/offer-listing/B00PL3DK26/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B00PL3DK26&linkCode=am2&tag=lasemedics-22&linkId=54e2196e3511f894c7169d79d2b1b78b'>20% Vitamin C Serum - Made in Canada - Certified Organic + 11% Hyaluronic Acid + Vitamin E Moisturizer + Collagen Boost - Reverse Skin Aging, Remove Sun Spots, Wrinkles and Dark Circles, Excellent for Sensitive Skin + Includes Pump &amp; Dropper 60 ml</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B00PL3DK26' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<br/>

</center>";
} elseif ($json['predictions']['1']['probability'] > 0.20 && $json['predictions']['1']['tagName'] == "redblem")
{
 $detectedconcerns=1;
 echo "<center><br/><b> ".round(($json['predictions']['1']['probability']*100),0)."% .Redness/rosacea.</b> Click <a href='https://www.lasemedics.com.au/skin/sensitive-or-sensitized.php' style='color:blue;'>here to continue reading</a>.
<br/>
<iframe width='100%' height='315' src='https://www.youtube.com/embed/nwwrBCwKyQM' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/>
<br/>
<b>Recommended day time routine:</b>
<br/><a target='_blank' style='color:blue;' style='color:blue;' href='https://www.amazon.com.au/gp/offer-listing/B001B8B6BC/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B001B8B6BC&linkCode=am2&tag=lasemedics-22&linkId=1f6edc04abf56e67cb1492b3874a2f6e'>Dermalogica Ultracalming Cleanser 8.4 oz</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B001B8B6BC' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<br/>


</center>";
} elseif ($json['predictions']['1']['probability'] > 0.20 && $json['predictions']['1']['tagName'] == "enlargedpores")
{
 $detectedconcerns=1;
 echo "<center><br/><b> ".round(($json['predictions']['1']['probability']*100),0)."% .Enlarged pores</b> Click <a href='https://www.lasemedics.com.au/skin/look-younger.php' style='color:blue;'>here to continue reading</a>.
<br/>
<iframe width='100%' height='315' src='https://www.youtube.com/embed/1pxs35XmBX8' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/>
</center>";
}

if ($detectedconcerns==0)
{
echo '<center><br/>We have not detected any skin conditions, things to try:
<br/>Try not to have anything with patterns in the background and no make up on. 
';
}



}//end while
}//end if post

 echo '
<br/>
</article>

<center>
<div style="color:red;font-size:12px;">
<br/><br/>DISCLAIMER: This app is designed to inform you and enhance your general knowledge. This is not intended to replace face to face skin consultations with your therapists or doctors. You should consult your doctor before making any lifestyle or diet changes or if you are concerned about your skin. This app does not diagnose or recognize medical skin concerns such as irregular skin moles or skin cancers. If you decide to apply any of the information in this application you are taking full responsibility for your actions. We are not responsible for any direct or indirect, punitive, special, incidental or any consequential damages that arise as a direct or indirect result of applying any part of this material which is provided in this application for educational purposes only and is without warranties.
</center>

<br/><br/>

<center>
<script>(function(t,e,o,n){var s,c,r;t.SMCX=t.SMCX||[],e.getElementById(n)||(s=e.getElementsByTagName(o),c=s[s.length-1],r=e.createElement(o),r.type="text/javascript",r.async=!0,r.id=n,r.src=["https:"===location.protocol?"https://":"http://","widget.surveymonkey.com/collect/website/js/HRofRwGvRD5WSxgzxsGVaGNJBFr_2BDh1tVxB0xKnPoEGqZ5qdPGL02xgPG5IqZquT.js"].join(""),c.parentNode.insertBefore(r,c))})(window,document,"script","smcx-sdk");</script><a style="font: 12px Helvetica, sans-serif; color: #999; text-decoration: none;" href=https://www.surveymonkey.com> Create your survey with SurveyMonkey </a></center>
</article>

';


//remove uploaded file
unlink( "/var/www/html/uploads/".$newname);
unlink( "/var/www/html/uploads/".$newname."_cropforehead.jpg");
unlink( "/var/www/html/uploads/".$newname."_cropchin.jpg");
unlink( "/var/www/html/uploads/".$newname."_croplcheeks.jpg");

//imagedestroy($dest);
imagedestroy($src);
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

</head>

<body>
<div class="button"><a href="https://www.lasemedics.com.au/detection_skin2_mobile.php">GO BACK <br/> << </a> </div>
<br/><br/><br/>

</body>
</html>
