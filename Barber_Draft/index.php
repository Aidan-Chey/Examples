<?php 
switch(true){
	case isset($_GET['Services']):
		$image =  "2-Services.png";
		break;
	case isset($_GET['Products']):
		$image =  "3-Products.png";
		break;
	case isset($_GET['Find_Us']):
		$image =  "4-Find Us.png";
		break;
	case isset($_GET['About_Us']):
		$image =  "5-About Us.png";
		break;
	case isset($_GET['Gallery']):
		$image =  "6-Gallery.png";
		break;
	default:
		$image = "1-Home.png";
		break;
}?>
<!DOCTYPE html>
<html>
<head>
	<title>Barber Draft</title>
	<meta charset="utf-8">
	<meta name="Author" content="Aidan Dunn">
	<meta name="Description" content="Images created to present to a potential client for a assignment during schooling">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
	<style type="text/css">
		body{
			font-size: 16px;
			background-color: hsl(0,0%,0%);
			position: relative;
		}
		body, nav h1{
			margin: 0;
			padding: 0;
		}
		nav{
			background-color: hsl(0, 100%, 35%);
		}
		nav h1{
			font-size: 180%;
			font-family: monospace;
			line-height: 2.5em;
		}
		nav{
			text-align: center
		}
		img{
			display: block;
			margin: 0 auto;
		}
		a{
			margin: 0 auto;
			position: absolute;
		}
		#home{
			width: 86px;
			height: 28px;
			left: 48.5%;
			top: 15.2%;
		}
		#services{
			width: 108px;
			height: 28px;
			left: 54.2%;
			top: 15.2%;
		}
		#products{
			width: 111px;
			height: 28px;
			left: 61.4%;
			top: 15.2%;
		}
		#find{
			width: 101px;
			height: 29px;
			left: 48.2%;
			top: 19.1%;
		}
		#about{
			width: 117px;
			height: 29px;
			left: 55%;
			top: 19.1%;
		}
		#gallary{
			width: 99px;
			height: 29px;
			left: 62.8%;
			top: 19.1%;
		}
	</style>
</head>
<body>
	<nav>
		<h1>Barber Draft Images</h1>
	</nav>
	<a id="home" href="?Home"></a>
	<a id="services" href="?Services"></a>
	<a id="products" href="?Products"></a>
	<a id="find" href="?Find_Us"></a>
	<a id="about" href="?About_Us"></a>
	<a id="gallary" href="?Gallery"></a>
	<img src="/Barber_Draft/<?php echo $image; ?>">
</body>
</html>