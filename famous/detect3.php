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
a {
  color: blue;
  font-size: 25px;
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

$ch = curl_init('https://facedetect3.cognitiveservices.azure.com/customvision/v3.0/Prediction/9d558df3-ca2e-43f1-adba-fdfaa1977b1b/classify/iterations/Iteration21/url');
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
 echo "
<center> <br/><br><h1 style='font-size:40px;background-color:blue;color:white;'> You have ".round(($json['predictions']['0']['probability']*100-10),0)."%  similarity to the look in this video.</b></h1>
<br/><h2>The Angelina Jolie Look Tutorial</h2>
<br/><br/><iframe width='560' height='315' src='https://www.youtube.com/embed/0o7PSalCqbI' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/><br/><h1 style='font-size:40px;background-color:orange;color:white;'>Score higher with the above video. <br/> Make-up used in this look:<h1>
<br/>- <a target='_blank' onclick='handleOutboundLinkClicks(event)' href='https://www.amazon.com.au/gp/offer-listing/B07Q89C5Q6/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B07Q89C5Q6&linkCode=am2&tag=lasemedics-22&linkId=de446bbc123b6cb9eee1795ca187608d'>Maybelline New York Instant Age Rewind Eraser Dark Circles Treatment Concealer, Light Honey, 0.2 fl. oz.</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B07Q89C5Q6' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<br/>- <a target='_blank' onclick='handleOutboundLinkClicks(event)' href='https://www.amazon.com.au/gp/offer-listing/B07QGZ5HTM/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B07QGZ5HTM&linkCode=am2&tag=lasemedics-22&linkId=9b8d2be0659071bcb976f9226fa02921'>Maybelline City Mini Eyeshadow Palette - Downtown Sunrise</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B07QGZ5HTM' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<br/>- <a target='_blank' onclick='handleOutboundLinkClicks(event)' href='https://www.amazon.com.au/gp/offer-listing/B0169YYBYQ/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B0169YYBYQ&linkCode=am2&tag=lasemedics-22&linkId=7b76cb57eb0c446a157c03bf81101f4d'>Maybelline Master Contour Face Contouring Palette - Light/Medium</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B0169YYBYQ' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<br/>
</center>
";
}
elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "arianagrande")
{
 $detectedconcerns=1;
 echo "
<center> <br/><br><h1 style='font-size:40px;background-color:blue;color:white;'> You have ".round(($json['predictions']['0']['probability']*100-10),0)."%  similarity to the look in this video.</b></h1>
<br/><h2>The Ariana Grande Look Tutorial</h2>
<br/><iframe width='560' height='315' src='https://www.youtube.com/embed/IrEGB2bz2HU' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/><br/><h1 style='font-size:40px;background-color:orange;color:white;'>Score higher with the above video. <br/> Make-up used in this look:<h1>
<br/>- <a target='_blank' onclick='handleOutboundLinkClicks(event)' href='https://www.amazon.com.au/gp/offer-listing/B079NRPHK2/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B079NRPHK2&linkCode=am2&tag=lasemedics-22&linkId=1bec09805d5666538ff32a93054ecb30'>Tatcha The Silk Canvas</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B079NRPHK2' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<br/>- <a target='_blank' onclick='handleOutboundLinkClicks(event)' href='https://www.amazon.com.au/gp/offer-listing/B07H67H5LG/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B07H67H5LG&linkCode=am2&tag=lasemedics-22&linkId=8a29d1fcc2750105c0d94e4771ae1256'>L'Oreal Paris Makeup Infallible up to 24HR Fresh Wear Liquid Longwear Foundation, Lightweight, Breathable, Natural Matte Finish, Medium-Full Coverage, Sweat &amp; Transfer Resistant, Linen, 1 fl. oz.</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B07H67H5LG' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<br/>- <a target='_blank' onclick='handleOutboundLinkClicks(event)' href='https://www.amazon.com.au/gp/offer-listing/B00TUPJQUG/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B00TUPJQUG&linkCode=am2&tag=lasemedics-22&linkId=aaabc30900da58b6a8b674c7268adf64'>Tarte Shape Tape Contour Concealer - Light</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B00TUPJQUG' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
</center>
";
}
elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "aubreyplaza")
{
 $detectedconcerns=1;
 echo "<center> <br/><br><h1 style='font-size:40px;'>You look like or have a similar style to <b>Aubrey Plaza</b></h1><br/></center>";
} elseif ($json['predictions']['0']['probability'] > 0.70 && $json['predictions']['0']['tagName'] == "edsheeran")
{
 $detectedconcerns=1;
 echo "<center> <br/><br><h1 style='font-size:40px;'>You look like or have a similar style to <b>Ed Sheeran</b></h1><br/></center>";
} elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "emmastone")
{
 $detectedconcerns=1;
 echo "
<center> <br/><br><h1 style='font-size:40px;background-color:blue;color:white;'> You have ".round(($json['predictions']['0']['probability']*100-10),0)."%  similarity to the look in this video.</b></h1>
<br/><h2>The Emma Stone Look Tutorial</h2>
<br/><iframe width='560' height='315' src='https://www.youtube.com/embed/Nc8IwbbcAIE' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/><br/><h1 style='font-size:40px;background-color:orange;color:white;'>Score higher with the above video. <br/> Make-up used in this look:<h1>
<br/>- <a target='_blank' onclick='handleOutboundLinkClicks(event)' href='https://www.amazon.com.au/gp/offer-listing/B00VF6NTB0/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B00VF6NTB0&linkCode=am2&tag=lasemedics-22&linkId=ede41107cafcd1deb0efbc302fee7332'>NARS All Day Luminous Weightless Foundation for Women, 1.5 Vallauris/Medium, 30ml</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B00VF6NTB0' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<br/>- <a target='_blank' onclick='handleOutboundLinkClicks(event)' href='https://www.amazon.com.au/gp/offer-listing/B013CWTB9S/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B013CWTB9S&linkCode=am2&tag=lasemedics-22&linkId=33c130bfd8cf908677bcc244757139a6'>NARS Soft Velvet Loose Powder - Flesh (Fair) 10g/0.35oz</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B013CWTB9S' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<br/>- <a target='_blank' onclick='handleOutboundLinkClicks(event)' href='https://www.amazon.com.au/gp/offer-listing/B00E1Z29V8/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B00E1Z29V8&linkCode=am2&tag=lasemedics-22&linkId=5c3888507e2225dd6a0c6201ce8bac20'>NARS Brow Gel - Oural, 7 ml</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B00E1Z29V8' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
</center>
";

} elseif ($json['predictions']['0']['probability'] > 0.70 && $json['predictions']['0']['tagName'] == "ryang")
{
 $detectedconcerns=1;
 echo "<center> <br/><br><h1 style='font-size:40px;'>You look like or have a similar style to <b>Ryan Gosling</b></h1>
<br/>
</center>";
} elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "kimkard")
{
 $detectedconcerns=1;
 echo "
<center> <br/><br><h1 style='font-size:40px;background-color:blue;color:white;'> You have ".round(($json['predictions']['0']['probability']*100-10),0)."%  similarity to the look in this video.</b></h1>
<br/><iframe width='560' height='315' src='https://www.youtube.com/embed/Bj9vBXhJR38' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/><br/><h1 style='font-size:40px;background-color:orange;color:white;'>Score higher with the above video. <br/> Make-up used in this look:<h1>
<br/>Make-up Toolkit to pull this off coming soon.. stay tuned.
</center>
";
} elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "katemiddleton")
{
 $detectedconcerns=1;
 echo "<center> <br/><br><h1 style='font-size:40px;'>You look like or have a similar style to <b>Kate Middleton</b></h1><br/></center>";
} elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "salenag")
{
 $detectedconcerns=1;
 echo "
<center>
<center> <br/><br><h1 style='font-size:40px;background-color:blue;color:white;'> You have ".round(($json['predictions']['0']['probability']*100-10),0)."%  similarity to the look in this video.</b></h1>
<iframe width='560' height='315' src='https://www.youtube.com/embed/DehkIe3dGe0' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/><br/><h1 style='font-size:40px;background-color:orange;color:white;'>Score higher with the above video. <br/> Make-up used in this look:<h1>
<br/>Make-up Toolkit to pull this off coming soon.. stay tuned.
";
} elseif ($json['predictions']['0']['probability'] > 0.70 && $json['predictions']['0']['tagName'] == "leo")
{
 $detectedconcerns=1;
 echo "<center> <br/><br><h1 style='font-size:40px;'>You look like or have a similar style to <b>Leonardo DiCaprio</b></h1><br/></center>";
} elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "rihanna")
{
 $detectedconcerns=1;
 echo "<center> <br/><br><h1 style='font-size:40px;'>You look like or have a similar style to <b>Rihanna</b></h1><br/></center>";
} elseif ($json['predictions']['0']['probability'] > 0.70 && $json['predictions']['0']['tagName'] == "zaynm")
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
<center> <br/><br><h1 style='font-size:40px;background-color:blue;color:white;'> You have ".round(($json['predictions']['0']['probability']*100-10),0)."%  similarity to the look in this video.</b></h1>
<br/><iframe width='560' height='315' src='https://www.youtube.com/embed/JtDpIz59SJw' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/><h2>The Emma Watson Look Tutorial</h2>
<br/><br/><h1 style='font-size:40px;background-color:orange;color:white;'>Score higher with the above video. <br/> Make-up used in this look:<h1>
<br/>- <a target='_blank' onclick='handleOutboundLinkClicks(event)' href='https://www.amazon.com.au/gp/offer-listing/B077631CNZ/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B077631CNZ&linkCode=am2&tag=lasemedics-22&linkId=d2f6f7b26d477747588e2b24b8875256'>Garnier Nutrisse Permanent Hair Colour 7N Natural Nude Dark Blonde</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B077631CNZ' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<br/>- <a target='_blank' onclick='handleOutboundLinkClicks(event)' href='https://www.amazon.com.au/gp/offer-listing/B000NYDZMS/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B000NYDZMS&linkCode=am2&tag=lasemedics-22&linkId=e0d2c51b8f69d13c09f017f541a4e589'>Nose and Scar Wax - Fair</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B000NYDZMS' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<br/>- <a target='_blank' onclick='handleOutboundLinkClicks(event)' href='https://www.amazon.com.au/gp/offer-listing/B07VXNX72T/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B07VXNX72T&linkCode=am2&tag=lasemedics-22&linkId=b4fe9622e19d71d20f61b1879236727b'>Glue Stick Glu Stik 8g, 2 Pack, (30840251)</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B07VXNX72T' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<br/>- <a target='_blank' onclick='handleOutboundLinkClicks(event)' href='https://www.amazon.com.au/gp/offer-listing/B075G8CCXM/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B075G8CCXM&linkCode=am2&tag=lasemedics-22&linkId=458a27689963ec593cae39c3f8dc81f3'>Matte Eyeshadow 09 Orange Vibe</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B075G8CCXM' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
</center>
";
}elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "kateb")
{
 $detectedconcerns=1;
 echo "
<center> <br/><br><h1 style='font-size:40px;background-color:blue;color:white;'> You have ".round(($json['predictions']['0']['probability']*100-10),0)."%  similarity to the look in this video.</b></h1>
<br/><h2>The Kate Bosworth Look Tutorial</h2>
<br/><iframe width='560' height='315' src='https://www.youtube.com/embed/YqC5loCFMtk' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/><br/><h1 style='font-size:40px;background-color:orange;color:white;'>Score higher with the above video. <br/> Make-up used in this look:<h1>
<br/>- <a target='_blank' onclick='handleOutboundLinkClicks(event)' href='https://www.amazon.com.au/gp/offer-listing/B07BH91YGQ/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B07BH91YGQ&linkCode=am2&tag=lasemedics-22&linkId=d9bef64cd2a9cd4593a3e54195b99233'>Koh Gen Do Maifanshi Aqua Foundation SPF25 -  123 (Warm) 30ml/1.01oz</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B07BH91YGQ' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<Br/>- <a target='_blank' onclick='handleOutboundLinkClicks(event)' href='https://www.amazon.com.au/gp/offer-listing/B005VSYAS4/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B005VSYAS4&linkCode=am2&tag=lasemedics-22&linkId=19dfb1bb8f36917d09709a8a036a684a'>Laura Mercier Secret Camouflage -  SC-3 Medium with Yellow or Pink Skin, 5.92 g</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B005VSYAS4' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<Br/>- <a target='_blank' onclick='handleOutboundLinkClicks(event)' href='https://www.amazon.com.au/gp/offer-listing/B07Q2P4F67/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B07Q2P4F67&linkCode=am2&tag=lasemedics-22&linkId=e053680eb48ec3654bf3fa96e0afb225'>Tarte Shape Tape Contour Concealer (Light Medium Honey)</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B07Q2P4F67' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<Br/>- <a target='_blank' onclick='handleOutboundLinkClicks(event)' href='https://www.amazon.com.au/gp/offer-listing/B071CZD1ST/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B071CZD1ST&linkCode=am2&tag=lasemedics-22&linkId=7db539158a5bb4b1a5a8fadb7243f33f'>Suqqu Framing Eyebrow Liquid Pen Eyebrow Brushes Color 02 Brown Japan</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B071CZD1ST' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
</center>
";
}

elseif ($json['predictions']['0']['probability'] > 0.40 && $json['predictions']['0']['tagName'] == "gina")
{
 $detectedconcerns=1;
 echo "
<center> <br/><br><h1 style='font-size:40px;background-color:blue;color:white;'> You have ".round(($json['predictions']['0']['probability']*100-10),0)."%  similarity to the look in this video.</b></h1>
<br/><iframe width='560' height='315' src='https://www.youtube.com/embed/WWWV7mtrGe0' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
<br/><h2>The Eva Longoria Look Tutorial</h2>
<br/><br/><h1 style='font-size:40px;background-color:orange;color:white;'>Score higher with the above video. <br/> Make-up used in this look:<h1>
<br/>- <a target='_blank' onclick='handleOutboundLinkClicks(event)' href='https://www.amazon.com.au/gp/offer-listing/B00PFCTOFK/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B00PFCTOFK&linkCode=am2&tag=lasemedics-22&linkId=80e35d421f09fa40343aaeb0a423132e'>L'OREAL Infallible ProMatte Foundation Liquid 108 Caramel Beige 1 fl. oz. 30 ml</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B00PFCTOFK' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<Br/>- <a target='_blank' onclick='handleOutboundLinkClicks(event)' href='https://www.amazon.com.au/gp/offer-listing/B01DPA6T38/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B01DPA6T38&linkCode=am2&tag=lasemedics-22&linkId=1756f3a5c7ff931234dc987c66a78846'>L'Oreal Paris Infallible Pro Glow Foundation 208 Sun Beige 30ml</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B01DPA6T38' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<br/>- <a target='_blank' onclick='handleOutboundLinkClicks(event)' href='https://www.amazon.com.au/gp/offer-listing/B01F36JEXE/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B01F36JEXE&linkCode=am2&tag=lasemedics-22&linkId=a505a4d5e924315e7f1cbd7a6b39ed9b'>BEAKEY 5 Pcs Makeup Sponge Set Blender Beauty Foundation Blending Sponge, Flawless for Liquid, Cream, and Powder, Multi-colored Makeup Sponges</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B01F36JEXE' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<br/>- <a target='_blank' onclick='handleOutboundLinkClicks(event)' href='https://www.amazon.com.au/gp/offer-listing/B0776493SW/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B0776493SW&linkCode=am2&tag=lasemedics-22&linkId=96eea486fb2ce3c150a11df0b9ea1ade'>Maybelline Master Liner 24HR Cream Eyeliner Pencil - Black,0.35g</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B0776493SW' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
<br/>- <a target='_blank' onclick='handleOutboundLinkClicks(event)' href='https://www.amazon.com.au/gp/offer-listing/B0051OQK7C/ref=as_li_tl?ie=UTF8&camp=247&creative=1211&creativeASIN=B0051OQK7C&linkCode=am2&tag=lasemedics-22&linkId=d7413e1d94ad9a7122fe3e812c8232a6'>L'Oreal Voluminous Carbon Black Mascara -  Carbon Black 7.7ml</a><img src='//ir-au.amazon-adsystem.com/e/ir?t=lasemedics-22&l=am2&o=36&a=B0051OQK7C' width='1' height='1' border='0' alt='' style='border:none !important; margin:0px !important;' />
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
<br/>Notice of Non-Affiliation and Disclaimer: The author of the app is not affiliated, associated, endorsed by, or in any way officially connected with any of the celebrities mentioned in this app. 
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
<img src="img/compete.png" style="width:40%;float:left;"><a href="https://apps.apple.com/au/app/30skinseconds/id1441359466" target="_blank" onclick='handleOutboundLinkClicks(event)'><img src="img/appstore1.png" style="width:40%;float:left;"></a><br/></center>

<br/><br/><img src="img/win.png">
<br><center><img src="img/compete.png" style="width:40%;float:left;"><a href="https://apps.apple.com/au/app/30skinseconds/id1441359466" target="_blank" onclick='handleOutboundLinkClicks(event)'><img src="img/appstore1.png" style="width:40%;float:left;"></a><br/></center>
</center>
<center><br><br/><b><div class="button" style="width:70%;"><a href="https://apps.apple.com/au/app/30skinseconds/id1441359466" onclick='handleOutboundLinkClicks(event)' style="text-decoration: none;color:white;">WHICH SKINCARE TIPS SUIT ME?<br/> ANALYSE MY SKIN >> </a> </div> </b> </center>
<center><img src="img/testmakeup5.png"></center>
<br><br><center><a href="https://apps.apple.com/au/app/30skinseconds/id1441359466" target="_blank" onclick='handleOutboundLinkClicks(event)'><img src="img/appstore1.png" style="width:30%;"></a><br/></center>
<br><center><img src="img/chilling.jpg"></center>
<br/><br/><br/>
<font color="black" size="2"><br/>DISCLAIMER: This app is designed by qualified beauty therapists to inform you and enhance your general knowledge. This is not intended to replace face to face skin consultations with your therapists or doctors. You should consult your doctor before making any lifestyle or diet changes or if you are concerned about your skin. This app does not diagnose or recognize medical skin concerns such as irregular skin moles or skin cancers. If you decide to apply any of the information in this application you are taking full responsibility for your actions. We are not responsible for any direct or indirect, punitive, special, incidental or any consequential damages that arise as a direct or indirect result of applying any part of this material which is provided in this application for educational purposes only and is without warranties.</font>


</body>
</html>
