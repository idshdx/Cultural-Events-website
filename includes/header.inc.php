<!-- Cum este nevoie de sesiune in ficare pagina, in loc sa te repeti de n ori pentru fiecare pagina, il adaugi in header si la randul lui headerul in pagina necesara-->
<?php session_start() ?>
<!DOCTYPE html>
<html>
<head>
	<title>Barlad City | Locul unde gasesti toate evenimentele din Barlad</title>
	<!-- Se inclus regulile de CSS(Stilizare) pentru fiecare pagina(Atat de pe CDN cat si local)-->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet">
	<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.7.3/summernote.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
	<div id="fb-root"></div>
	<script>
		//Script-ul responsabil pentru  includerea si pozitionarea functionalitatii specifice Facebook(buton like, etc)
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display. De asta folosim Bootstrap -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">Barlad City</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<form name="formCategory" action="create.php" method="post">
						<input type="hidden" name="sendVal" value="category">
					</form>
					<form name="formEvent" action="create.php" method="post">
						<input type="hidden" name="sendVal" value="event">
					</form>
					<li><a href="index.php"> Home</a></li>
					<?php 
					//In caz ca utlizatorul este logat afiseaza butoanele specifice unui utilizator admin
					if (isset($_SESSION['username']) && $_SESSION['username'] != "") {
						echo '
							<li class="dropdown">
								<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"> Adauga 
									 <span class="caret"> </span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="#" onclick="formCategory.submit()">Categorie</a></li>
									<li><a href="#" onclick="formEvent.submit()">Eveniment</a></li>
								</ul>
							</li>
						';
					}
					?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#"><div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div></a></li>
					<?php 
					//Diferite afisaje in functie daca ultilizatorul este logat=> Arati butonul de login daca nu e logat si invers
					if (isset($_SESSION['username']) && $_SESSION['username'] != "")
						echo '<li><a href="logout.php"> Logout</a></li>';
					else
						echo '<li><a href="login.php"> Login</a></li>';
					?>
					<li><a href="#"></a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
	<div class="container">
