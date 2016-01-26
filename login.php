<!-- Afiseaza forma de login si proceseaz-o -->
<?php

$page = "";
require "config/db-connect.cfg.php";
include "includes/header.inc.php";
$error = '';
//Verifica daca datele de login sunt adevarate, in caz contrat afiseaza o eroare si redirectioneaza l spre pagina principala(index.php)
if (isset($_POST['username']) and isset($_POST['password'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$qry = "SELECT * FROM users WHERE username='$username' and password='$password'";
	$result = mysqli_query($dbc, $qry);
	$count = mysqli_num_rows($result);
	if ($count == 1){
		$_SESSION['username'] = $username;
		echo '<script> window.location.href = "index.php"; </script>';
	}else{
		$error = '<p class="alert alert-danger col-md-offset-3 col-md-6">Username sau parola gresita.</p>';
	}
}

?>
<!-- Afiseaza forma de login-->
<div id="response" class="col-md-12 text-center">
	<?php echo $error; ?>
</div>
<div class="center-form panel">
	<div class="panel-body">
		<h2 class="text-center">Log in</h2>
		<hr>
		<form method="post" name="loginForm" action="login.php">
			<div class="form-group">
				<input class="form-control input-md" type="text" name="username" id="input1" placeholder="Username" autofocus>
			</div>
			<div class="form-group">
				<input class="form-control input-md" type="password" name="password" id="input2" placeholder="Password">
			</div>
			<button type="submit" name="submit" id="submit" class="btn btn-lg btn-block btn-success">Log in</button>
			<hr>
		</div>
	</form>
</div>
</div>  

<?php include "includes/footer.inc.php"; ?>