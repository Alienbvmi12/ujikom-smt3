<?php 
session_start();
if(isset($_SESSION['user'])){
	header("location:peminjaman.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style-login.css">
	<link rel="stylesheet" href="bootstrap.css">
	<link rel="icon" type="image/png" href="elektro.png">
	<title>Daftar</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="jquery-3.5.1.min.js"></script>
	<script>
		function hapus(){
			document.getElementById("errno").innerHTML = "";
		}
	</script>
	<style id="metas"></style>
	<style id="metasta"></style>
	<style id="metastu"></style>
	<style id="metasti"></style>
</head>
<body>
	<form method="post" id="login" name="fordaf" action="pemrosesan.php">
		<div class="wadah-form">
			<div id="effect">
				<div id="conten-form">
					<br>
					<center><img src="elektro.png" width="100px"></center>
					<br>
					<input type="text" name="username-daftar" class="adaan" id="user" onchange="aas()" placeholder="Username">
					<br>
					<input type="email" name="email-daftar" class="adaan" id="mail" onchange="ees()" placeholder="Email">
					<br>
					<input type="password" name="password-daftar" class="adaan" id="pass" onchange="uus()" placeholder="Password">
					<br>
					<input type="password" name="passwordc-daftar" class="adaan" id="passc" onchange="iis()" placeholder="Confirm Password">
					<p style="color : red;" id="errno"><?php if(isset($_GET['ver'])){echo "*Username atau password salah!! ";}if(isset($_GET['pascm'])){echo $_GET['pascm'];}?></p>
					<p>Sudah punya akun? <a href="login.php">Login</a></p>
					
					<section>
						<center><input type="submit" value="Register" class="btn btn-warning"style="width : 100px; border-radius : 120px;"></center>
					</section>
				</div>
			</div>
		</div>
	</form>	
	<script>

	</script>
</body>
</html>