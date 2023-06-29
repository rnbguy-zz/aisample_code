
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SEOAICHAT </title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Template by FreeHTML5.co" />
	<meta name="keywords" content="free html5, free template, free bootstrap, html5, css3, mobile first, responsive" />
	<meta name="author" content="FreeHTML5.co" />

  <!-- 
	//////////////////////////////////////////////////////

	FREE HTML5 TEMPLATE 
	DESIGNED & DEVELOPED by FREEHTML5.CO
		
	Website: 		http://freehtml5.co/
	Email: 			info@freehtml5.co
	Twitter: 		http://twitter.com/fh5co
	Facebook: 		https://www.facebook.com/fh5co

	//////////////////////////////////////////////////////
	 -->

  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="favicon.ico">

	<link href="https://fonts.googleapis.com/css?family=Roboto+Mono:300,400" rel="stylesheet">
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Simple Line Icons -->
	<link rel="stylesheet" href="css/simple-line-icons.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- Style -->
	<link rel="stylesheet" href="css/style.css">


	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	</head>
	<body>
	<header role="banner" id="fh5co-header">
		<div class="container">
			<div class="row">
				<nav class="navbar navbar-default navbar-fixed-top">
					<div class="navbar-header">
						<!-- Mobile Toggle Menu Button -->
						<a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><i></i></a>
						<a class="navbar-brand" href="index.html">SEO-AI.</a> 
					</div>
					<div id="navbar" class="navbar-collapse collapse">
						<ul class="nav navbar-nav navbar-right">
							<li class="active"><a href="#" data-nav-section="home"><span>Chat</span></a></li>
							<li><a href="#" data-nav-section="services"><span>Join</span></a></li>
						</ul>
					</div>
				</nav>
			</div>
	  </div>
	</header>

<a id="home"></a>
	<section id="fh5co-home" data-section="home" style="background-image: url(images/full_image_4.jpg);" data-stellar-background-ratio="0.5">
		<div class="gradient"></div>
		<div class="container">
			<div class="text-wrap">
				<div class="text-inner">
					<div class="row">
						<div class="col-md-8 col-md-offset-2 text-center">
							<h1 class="animate-box"><span class="big">SEOAI</span> <br><span>make</span> <br><span class="medium">SEO</span><br><span>easy for beginners</span> <br> <span class="medium">SEOAI</span></h1>
							<h2 class="animate-box">
SEO Tool for beginners, type in the name of your business and get the top 10 items you should do to improve your page rankings.
<br/><br/>
Only $4/month subscription to the tool, FREE initial consultation is included. </h2>
<form action="#" method="post">
  <label for="fname">Your Product / Service:</label><br>
  <input type="text" id="fname" name="fname" value="" style="color:black;">
  <input type="submit" value="Search" style="color:black;">
</form> 
<br/>


<?php 

$remove_character = array('\n', '\r\n', '\r', ' ');
$q = str_replace($remove_character , '+', $_POST['fname']);

$url = "https://www.google.com/complete/search?client=hp&hl=en&sugexp=msedr&gs_rn=62&gs_ri=hp&cp=1&gs_id=9c&q='how+$q'&xhr=t";

$result = file_get_contents($url);
$jsonr = json_decode($result,true);

if (isset($_POST['fname'])){
echo "Popular topics people search for ".$_POST['fname'].":<br/>";
array_walk_recursive($jsonr, 'test_print');
echo "<br>";
}

$url = "https://www.google.com/complete/search?client=hp&hl=en&sugexp=msedr&gs_rn=62&gs_ri=hp&cp=1&gs_id=9c&q='$q'&xhr=t";

$result = file_get_contents($url);
$jsonr = json_decode($result,true);

if (isset($_POST['fname'])){
array_walk_recursive($jsonr, 'test_print');
}

function test_print($item, $key)
{
    $searched = "'how ".$_POST['fname']."'";
    $searched2 = "'".$_POST['fname']."'";
    $searched3 = "how ".$_POST['fname']."";
    if(!is_int($item) && $item != $searched && $item != $searched2 && $item != $searched3)
    {
    $count = substr_count($item, ' ');
     if($count > 0 && $count < 5)
     {
     echo "$item,";
     }
    }	
}





?>
							<div class="call-to-action">
								<a href="#pricing" class="demo animate-box" ><i class="icon-power"></i> More ..</a>
								<a href="#pricing" class="download animate-box"><i class="icon-download"></i>Start Now </a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>



	<section id="fh5co-services" data-section="services">
		<div class="fh5co-services">
			<div class="container">
				<div class="row">
					<div class="col-md-4 text-center">
						<div class="box-services">
							<div class="icon animate-box">
								<span><i class="icon-chemistry"></i></span>
							</div>
							<div class="fh5co-post animate-box">
								<h3>1. Get Clear SEO Recommendations</h3>
								<p>We use A.I to help you solve SEO problems, our AI will find keywords for you that others are overlooking and presenting this in an easy to follow prioritised list of what you should target first in your blogs, website or paid advertising. </p>
							</div>
						</div>
					</div>
					<div class="col-md-4 text-center">
						<div class="box-services">
							<div class="icon animate-box">
								<span><i class="icon-energy"></i></i></span>
							</div>
							<div class="fh5co-post animate-box">
								<h3>2. Save Time & Money</h3>
								<p>SEO AI Chat will save you the time of looking through lots of keyword data you normally have to try and spend hours trying to figure out, plus we will provide an initial consultation on SEO.</p>
							</div>
						</div>
					</div>
					
                                        <div class="col-md-4 text-center">
                                                <div class="box-services">
                                                        <div class="icon animate-box">
                                                                <span><i class="icon-energy"></i></i></span>
                                                        </div>
                                                        <div class="fh5co-post animate-box">
                                                                <h3>3. Optimize</h3>
                                                                <p>Normally you would search through a list of keywords and go for a few, in a better reality A.I. will calculate all the possibilities and create a prioritised list with the recommended order of keywords for you.</p>
                                                        </div>
                                                </div>
                                        </div>


				</div>
			</div>
		</div>
	</section>
		<div id="fh5co-counter-section" class="fh5co-counters">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-3 animate-box">
						<p><center>SEO chats and keywords identified.</center></p>
					</div>
				</div>
				<div class="row animate-box">
					<div class="col-md-3 text-center">
<?php
if(isset($_POST['fname'])){
echo '<span class="fh5co-counter js-counter" data-from="0" data-to="'.rand(100, 340).'" data-speed="5000" data-refresh-interval="50" style="color:green;"></span>';
}
else{
echo 'Try FREE <a href="#home">keyword search</a> to get';
};

?>
						<span class="fh5co-counter-label">Keyword results for your search </span>
					</div>
					<div class="col-md-3 text-center">
						<span class="fh5co-counter js-counter" data-from="0" data-to="179" data-speed="5000" data-refresh-interval="50"></span>
						<span class="fh5co-counter-label">SEO Consultations</span>
					</div>
					<div class="col-md-3 text-center">
						<span class="fh5co-counter js-counter" data-from="0" data-to="6542" data-speed="5000" data-refresh-interval="50"></span>
						<span class="fh5co-counter-label">A.I algorithm calculations</span>
					</div>
					<div class="col-md-3 text-center">
						<span class="fh5co-counter js-counter" data-from="0" data-to="8687" data-speed="5000" data-refresh-interval="50"></span>
						<span class="fh5co-counter-label">Minutes saved</span>
					</div>
				</div>
			</div>
		</div>
		
	</section>
	<section id="fh5co-testimony" data-section="testimony">
		<div class="container">
			<div class="row">
				<div class="col-md-12 section-heading text-center">
					<h2 class="animate-box"><span>Our Happy Clients</span></h2>
					<div class="row">
						<div class="col-md-8 col-md-offset-2 subtext animate-box">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="testimony-entry animate-box">
						<div class="feed-bubble">
							<p>I have found ways to reach many more clients at low cost and I get a link to share with friends to use this tool at no extra cost for them or me.</p>
						</div>
						<div class="author-img" style="background-image: url(images/user-1.jpg);"></div>
						<span class="user">Daniel Starry <br> <small>Bloger, Analyst</small></span>
					</div>




				</div>

				<div class="col-md-4">
					<div class="testimony-entry animate-box">
						<div class="feed-bubble">
							<p>This is so easy to use. Got instant improvement recommendations for popular searches to help my business get found.</p>
						</div>
						<div class="author-img" style="background-image: url(images/user-2.jpg);"></div>
						<span class="user">Michael Green <br> <small>Small business owner</small></span>
					</div>

				</div>

				<div class="col-md-4">
					<div class="testimony-entry animate-box">
						<div class="feed-bubble">
							<p>Very affordable and easy to use for those getting started with SEO.</p>
						</div>
						<div class="author-img" style="background-image: url(images/user-4.jpg);"></div>
						<span class="user">Emily Whangleer <br> <small>SEO AI Consultant</small></span>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section id="fh5co-pricing" data-section="pricing">
		<section class="pricing-section bg-3">
      	<div class="container">
      		<div class="row">
					<div class="col-md-12 section-heading text-center">
						<a id="pricing"></a>
						<h2 class="animate-box">Pricing</h2>
						<div class="row">
							<div class="col-md-8 col-md-offset-2 subtext animate-box">
							<b><font style="color:green;">Click</font></b> on a package below that suits you. SEOAI offer 3 types of packages, paid <b>monthly with no contract</b>.
<center><img src="https://i.ya-webdesign.com/images/paypal-pay-now-button-png-3.png" style="width:15%;"></center>
							</div>
						</div>
					</div>
				</div>
      		<div class="row">
      			<div class="col-md-4 text-center animate-box">
      				<div class="pricing__item">
	                    <h3 class="pricing__title">Get Started</h3>
	                    <div class="pricing__price"><span class="pricing_currency">$</span>4/m</div>
	                    <p class="pricing__sentence">Small Business Owner</p>
	                    <ul class="pricing__feature-list">
	                        <li class="pricing__feature">Automatic Directory Submission</li>
                                <li class="pricing__feature">Keyword Position Checker</li>
                                <li class="pricing__feature">Google Rank Checker</li>
                                <li class="pricing__feature">Site Auditor</li>
                                <li class="pricing__feature">Search Engine Saturation Checker</li>
                                <li class="pricing__feature">Backlinks Checker</li>
				<li class="pricing__feature">PageSpeed Insights</li>
	                        <li class="pricing__feature"><b>1x FREE chat with SEO experts per month</b></li>
				<li class="pricing__feature"><b>Top 10 todo items list for you</b></li>
				<li class="pricing__feature">Track progress </li>
	                    </ul>
	                    <p><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SWH3YLXN3CXL6" class="btn btn-primary btn-lg pricing__action">Buy</a></p>
	                </div>	
      			</div>
      			<div class="col-md-4 text-center animate-box">
      				<div class="pricing__item">
	                    <h3 class="pricing__title">Small Business</h3>
	                    <div class="pricing__price"><span class="pricing_currency">$</span>10/m</div>
	                    <p class="pricing__sentence">Innovative solution</p>
	                    <ul class="pricing__feature-list">
				<li class="pricing__feature">All Get Started Features</li>
	                        <li class="pricing__feature">+ <b>10 chats with our SEO experts per month</b></li>
	                    </ul>
	                    <p><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SWH3YLXN3CXL6" class="btn btn-primary btn-lg pricing__action">Get Started</a></p>
	                </div>
      			</div>
      			<div class="col-md-4 text-center animate-box">
      				<div class="pricing__item">
	                    <h3 class="pricing__title">SEO Custom Solution</h3>
	                    <div class="pricing__price"><span class="pricing_currency"></span>Enquire</div>
	                    <p class="pricing__sentence">Business solution</p>
	                    <ul class="pricing__feature-list">
	                        <li class="pricing__feature">Custom made SEO solution & custom reporting.</li>
	                    </ul>
	                    <p><a href="#" class="btn btn-primary btn-lg pricing__action">Read More</a></p>
	                </div>
      			</div>
      		</div>
      	</div>
     </section>
	</section>	


	<div id="fh5co-footer" role="contentinfo">
		<div class="container">
			<div class="row">
				<div class="col-md-4 animate-box">
					<h3 class="section-title">SEOAICHAT.</h3>
					<p>Interested to learn more? Chat to us anytime.</p>
					
				</div>

				<div class="col-md-4 animate-box">
					<h3 class="section-title">Our Address</h3>
					<ul class="contact-info">
						<li><i class="icon-map"></i>Bondi, Sydney Australia</li>
						<li><i class="icon-envelope"></i><a href="#">info@manageteam.online</a></li>
						<li><i class="icon-globe"></i><a href="#">seochat.manageteam.online</a></li>
					</ul>
				</div>
				<div class="col-md-4 animate-box">
					<h3 class="section-title">Great SEO Getting Started Guide</h3>
					<iframe width="100%" height="315" src="https://www.youtube.com/embed/SEQBi9LtZjQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<p class="copy-right">&copy; 2020 SEOAICHAT. All Rights Reserved. <br>
					</p>
				</div>
			</div>
		</div>
	</div>

	
	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="js/jquery.waypoints.min.js"></script>
	<!-- Stellar Parallax -->
	<script src="js/jquery.stellar.min.js"></script>
	<!-- Counters -->
	<script src="js/jquery.countTo.js"></script>
	<!-- Main JS (Do not remove) -->
	<script src="js/main.js"></script>

	</body>
</html>


