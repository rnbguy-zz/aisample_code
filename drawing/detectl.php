
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
<script>
function handleOutboundLinkClicks(event) {
  ga('send', 'event', {
    eventCategory: 'Outbound Link',
    eventAction: 'click',
    eventLabel: event.target.href,
    transport: 'beacon'
  });
}
</script>

	<meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/reset.css">
        <link rel="stylesheet" type="text/css" href="../css/main.css">
	<title>Scan your face and get a personalised skin care routine.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="style.css">

</head>
<body >




	<!-- BEGIN: banner wrapper -->
		<section id="bannerWrapper" >
				
			<!-- BEGIN: banner area -->
			<article class="bannerArea" style="font-family:Baskerville; ">
				<div id="owl-one" class="owl-carousel">
				<center>
					<div class="item" >
						
						<div class="mycontainer">
						
							<div class="overlay" style="background-color:white; padding:5px; ">
							
							<div >

                        <form action="http://www.lasemedics.com.au/detect3.php" method="post" enctype="multipart/form-data" name="myform" id="myform">
                        <label for="fileToUpload"><div style="color:#B6577B;font-family:Cambria;">
<center>
			<p>

<center><img src="img/draw1.png" style="width:25%;float:left;">
<img src="img/giphy1.gif" >

<?php
echo "<center> Draw, act or find something around you. The first person to upload a photo of something that looks the most like the below wins:<br/><br/> </center>";

$arrX = array("Harbour Bridge", "Koala", "Table");
 
// get random index from array $arrX
$randIndex = array_rand($arrX);
 
$thing = $arrX[$randIndex];
// output the value for the random index

echo "
<center><b><img src='img/arrow1.gif' style='width:30%;'> 
<font style='font-size:30px;'>".$thing."</font></b>
<br/>
</center>";

?>

<br><br/><b><div class="button" style="width:70%;font-size:50px;">PLAY</div></b> </div></label>
                        <input type="file" name="fileToUpload" id="fileToUpload" style="display: none;" accept="image/*" onchange="this.form.submit()" onclick="document.getElementById('loading').style.display = 'block';"/>
			<input type="hidden" value="<?php echo $thing;?>" id="item" name="item"/> 
                        </form>
<center><br><br/><b><div class="button" style="width:70%;"><a href="https://www.lasemedics.com.au/detectl.php" onclick='handleOutboundLinkClicks(event)' style="text-decoration: none;color:white;">SKIP WORD </a> </div> </b> </center>

<br/> <center><font style="color:blue;">You're on Level 1 difficulty. The next levels get harder pictures and a timer will be introduced!!</font></center>



</font>

<div style="margin-bottom:20px;margin-top:20px;">

</div>

<br/><br/><br/>



<br/><br/>
		</div>
</center>

							</div>
						
						</div>
						
					</div>
					
										
				</div>
			</article>
			<!-- END: banner area -->
				
		</section>
		<!-- END: banner wrapper -->

<br/>



</body>
</html>
