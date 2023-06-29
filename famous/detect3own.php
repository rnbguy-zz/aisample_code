
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

$ch = curl_init('https://facedetect3.cognitiveservices.azure.com/customvision/v3.0/Prediction/9d558df3-ca2e-43f1-adba-fdfaa1977b1b/classify/iterations/Iteration20/url');
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

if ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "angelinajolie")
{
 $detectedconcerns=1;
 echo "<center> <br/><br><h1 style='font-size:40px;background-color:blue;color:white;'>".round(($json['predictions']['0']['probability']*100-10),0)."% . You look like or have a similar style to the <b>Tutorials Below</b></h1>
<br/><iframe width='560' height='315' src='https://www.youtube.com/embed/GDcQJ32zmvg' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/><br/><iframe width='560' height='315' src='https://www.youtube.com/embed/0o7PSalCqbI' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>

</center>
";
}
elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "arianagrande")
{
 $detectedconcerns=1;
 echo "<center> <br/><br><h1 style='font-size:40px;background-color:blue;color:white;'>".round(($json['predictions']['0']['probability']*100-10),0)."% . You look like or have a similar style to the <b>Tutorials Below</b></h1>
<br/><iframe width='560' height='315' src='https://www.youtube.com/embed/IrEGB2bz2HU' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/><br/><iframe width='560' height='315' src='https://www.youtube.com/embed/bCdETAW4-N4' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>

</center>
";
}
elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "aubreyplaza")
{
 $detectedconcerns=1;
 echo "<center> <br/><br><h1 style='font-size:40px;'>You look like or have a similar style to <b>Aubrey Plaza</b></h1><br/></center>";
} elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "edsheeran")
{
 $detectedconcerns=1;
 echo "<center> <br/><br><h1 style='font-size:40px;'>You look like or have a similar style to <b>Ed Sheeran</b></h1><br/></center>";
} elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "emmastone")
{
 $detectedconcerns=1;
 echo "
<center> <br/><br><h1 style='font-size:40px;background-color:blue;color:white;'>".round(($json['predictions']['0']['probability']*100-10),0)."% . You look like or have a similar style to the <b>Tutorials Below</b></h1>
<br/><iframe width='560' height='315' src='https://www.youtube.com/embed/QzwemV__2JQ' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/><br/><iframe width='560' height='315' src='https://www.youtube.com/embed/lRhKCZOixcQ' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>

</center>
";

} elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "ryang")
{
 $detectedconcerns=1;
 echo "<center> <br/><br><h1 style='font-size:40px;'>You look like or have a similar style to <b>Ryan Gosling</b></h1>
<br/>
</center>";
} elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "kimkard")
{
 $detectedconcerns=1;
 echo "
<center> <br/><br><h1 style='font-size:40px;background-color:blue;color:white;'>".round(($json['predictions']['0']['probability']*100-10),0)."% . You look like or have a similar style to the <b>Tutorials Below</b></h1>
<br/><iframe width='560' height='315' src='https://www.youtube.com/embed/BwPh8WbYDAU' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/><br/><iframe width='560' height='315' src='https://www.youtube.com/embed/naJT0PEw2vw' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>

</center>
";
} elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "katemiddleton")
{
 $detectedconcerns=1;
 echo "<center> <br/><br><h1 style='font-size:40px;'>You look like or have a similar style to <b>Kate Middleton</b></h1><br/></center>";
} elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "salenag")
{
 $detectedconcerns=1;
 echo "<center> <br/><br><h1 style='font-size:40px;'>You look like or have a similar style to <b>Selena Gomez</b></h1><br/></center>";
} elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "leo")
{
 $detectedconcerns=1;
 echo "<center> <br/><br><h1 style='font-size:40px;'>You look like or have a similar style to <b>Leonardo DiCaprio</b></h1><br/></center>";
} elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "rihanna")
{
 $detectedconcerns=1;
 echo "<center> <br/><br><h1 style='font-size:40px;'>You look like or have a similar style to <b>Rihanna</b></h1><br/></center>";
} elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "zaynm")
{
 $detectedconcerns=1;
 echo "<center> <br/><br><h1 style='font-size:40px;'>You look like or have a similar style to <b>Zayn Malik</b></h1><br/></center>";
} elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "meganfox")
{
 $detectedconcerns=1;
 echo "<center> <br/><br><h1 style='font-size:40px;'>You look like or have a similar style to <b>Megan Fox</b></h1><br/></center>";
} elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "emmawatson")
{
$detectedconcerns=1;
 echo "
<center> <br/><br><h1 style='font-size:40px;background-color:blue;color:white;'>".round(($json['predictions']['0']['probability']*100-10),0)."% . You look like or have a similar style to the <b>Tutorials Below</b></h1>
<br/><iframe width='560' height='315' src='https://www.youtube.com/embed/CFxFyHT1vDk' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/><br/><iframe width='560' height='315' src='https://www.youtube.com/embed/u4nG7FDE71A' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>

</center>";
}elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "kateb")
{
 $detectedconcerns=1;
 echo "
<center> <br/><br><h1 style='font-size:40px;background-color:blue;color:white;'>".round(($json['predictions']['0']['probability']*100-10),0)."% . You look like or have a similar style to the <b>Tutorials Below</b></h1>
<br/><iframe width='560' height='315' src='https://www.youtube.com/embed/YqC5loCFMtk' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/><br/><iframe width='560' height='315' src='https://www.youtube.com/embed/pch9SgDODbg' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>

</center>";
}

elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "gina")
{
 $detectedconcerns=1;
 echo "
<center> <br/><br><h1 style='font-size:40px;background-color:blue;color:white;'>".round(($json['predictions']['0']['probability']*100-10),0)."% . You look like or have a similar style to the <b>Tutorials Below</b></h1>
<br/><iframe width='560' height='315' src='https://www.youtube.com/embed/aEbjzkvgxog' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/><br/><iframe width='560' height='315' src='https://www.youtube.com/embed/u6cjrg0HVf8' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>

</center>
";
}

if ($detectedconcerns==0)
{
echo '<center><br/><b>We have not detected any lookalikes try to not have anything with patterns in the background.</b> ';
}

}//end if post

 echo '
<br/>
</article>

<center>
<div style="color:red;font-size:14px;">
<br/><br/>Notice of Non-Affiliation and Disclaimer: The author of the app is not affiliated, associated, endorsed by, or in any way officially connected with any of the celebrities mentioned in this app.
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

<br><center><img src="img/chilling.jpg"></center>
<br/><br/><br/>
<font color="black" size="2"><br/>DISCLAIMER: This app is designed by qualified beauty therapists to inform you and enhance your general knowledge. This is not intended to replace face to face skin consultations with your therapists or doctors. You should consult your doctor before making any lifestyle or diet changes or if you are concerned about your skin. This app does not diagnose or recognize medical skin concerns such as irregular skin moles or skin cancers. If you decide to apply any of the information in this application you are taking full responsibility for your actions. We are not responsible for any direct or indirect, punitive, special, incidental or any consequential damages that arise as a direct or indirect result of applying any part of this material which is provided in this application for educational purposes only and is without warranties.</font>

<br><br/><b><div class="button" style="width:70%;"><a href="./detection_skin2_mobile.php" style="text-decoration: none;"> << GO BACK</a> </div></b> </label>
<br/><br/>
</body>
</html>
