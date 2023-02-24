<?php session_start(); //Untuk memulai session?>

<!--Untuk import resource yang dibutuhkan-->

<?php
include "koneksi.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
date_default_timezone_set("Asia/Jakarta");
$tgl = date("j F Y h:i:s A");
?>

<!--Untuk login & logout-->

<?php
if(isset($_POST['username-login']) AND isset($_POST['password-login'])){
	$userLog = $_POST['username-login'];
	$passLog = md5(sha1($_POST['password-login']));
	$query = "select * from user where username='".$userLog."' and password='".$passLog."'";
	$hasil = mysqli_query($koneksi, $query);
	$role = mysqli_fetch_array($hasil);
	if(mysqli_num_rows($hasil) > 0){
		header("location:peminjaman.php");
		$useracc = $_SESSION['user'] = $userLog;
		$userole = $_SESSION['role'] = $role[3];
	}
	else{
		header("location:login.php?ver=false");
	}
}	
if(isset($_POST['logout'])){
	unset($_SESSION['user']);
	unset($_SESSION['role']);
	echo "<script>window.location.replace('peminjaman.php');</script>";
}
?>

<!--Untuk daftar-->

<?php
if((isset($_POST['username-daftar']) AND isset($_POST['password-daftar'])) AND isset($_POST['email-daftar'])){
	unset($_SESSION['email-verify']);
	unset($_SESSION['resend-code']);
	$daftaruser = $_POST['username-daftar'];
	$daftarpass = $_POST['password-daftar'];
	$daftarpassc = $_POST['passwordc-daftar'];
	$daftaremail = $_POST['email-daftar'];
	$queryvernick = "select username from user where username='".$daftaruser."'";
	$runvernick = mysqli_query($koneksi, $queryvernick);
	if(mysqli_num_rows($runvernick) > 0){
		header("location:daftar.php?pascm=Nickname%20%sudah%20%digunakan!!");
		die;
	}
	if($daftarpass != $daftarpassc){
		header("location:daftar.php?pascm=Password%20tidak%20sesuai!!");
		die;
	}
	$_SESSION['email-verify'] = random_int(0, 9999);
	$_SESSION['resend-code'] = array("username"=>$daftaruser,"password"=>$daftarpass,"passwordc"=>$daftarpassc,"email"=>$daftaremail);
	$phpmailer = new PHPMailer();
	$phpmailer->isSMTP();
	$phpmailer->Host = 'smtp.gmail.com';
	$phpmailer->SMTPAuth = true;
	$phpmailer->Username = 'elektro1ktp@gmail.com';
	$phpmailer->Password = 'lodicvystonvxrph';
	$phpmailer->SMTPSecure = 'ssl';
	$phpmailer->Port = 465;
	
	//Mulai pengiriman
	
	$phpmailer->setFrom('elektro1ktp@gmail.com');
	$phpmailer->addAddress($_POST['email-daftar']);
	$phpmailer->isHTML(true);
	$phpmailer->Subject = "Konfirmasi email";
	$phpmailer->Body = "Kode konfirmasi email anda untuk register ke elektro1ktp adalah: ".$_SESSION['email-verify'];
	$phpmailer->send();
	header("location:konfirmkode.php");
}
if(isset($_POST['vercode'])){
	$resvar = $_SESSION['resend-code'];
	$vercode = $_POST['vercode'];
	if($vercode != $_SESSION['email-verify']){
		header("location:konfirmkode.php?ver=true");
	}
	else{
		$_SESSION['user'] = $resvar['username'];
		$_SESSION['role'] = "user";
		$regquery = "insert into user (username, password, role, pp, email) values ('".$resvar['username']."','".md5(sha1($resvar['password']))."','user','pp/basic.png', '".$resvar['email']."')";
		mysqli_query($koneksi, $regquery);
		header("location:peminjaman.php");
		unset($_SESSION['resend-code']);
	}
	
}

?>

<!--Untuk Mengambil data barang dari database-->

<?php
if(isset($_POST['kategori']) AND isset($_POST['short'])){
	$kategori = $_POST['kategori'];
	if($kategori == ""){
		$kategorimod = "";
	}
	else{
		$kategorimod = "where kode_kategori='".$kategori."'";
	}
	$short = $_POST['short'];
	$query1 = "select * from barang ".$kategorimod.$short;
	$hasil1 = mysqli_query($koneksi, $query1);
	tablestr();
	while($data = mysqli_fetch_array($hasil1)){
		$query2 = "select * from kategori where kode_kategori='".$data['kode_kategori']."'";
		$hasil2 = mysqli_query($koneksi, $query2);
		$data2 =  mysqli_fetch_array($hasil2);
		tabeldata($data['kode_barang'],$data['nama_barang'],$data['kode_kategori'],$data['stok']," ", $data['merk'], $data['sumber'], $data['tanggal_diubah'], $data2['jenis_kategori']);
	}
	echo "</table>";
	
}
?>

<?php
if(isset($_POST['short2'])){
	$kategori = $_POST['kategori'];
	if($kategori == ""){
		$kategorimod = "";
	}
	else{
		$kategorimod = "where kode_kategori='".$kategori."'";
	}
	$short2 = $_POST['short2'];
	$query1 = "select * from barang ".$kategorimod.$short2;
	$hasil1 = mysqli_query($koneksi, $query1);
	tablestr();
	while($data = mysqli_fetch_array($hasil1)){
		$query2 = "select * from kategori where kode_kategori='".$data['kode_kategori']."'";
		$hasil2 = mysqli_query($koneksi, $query2);
		$data2 =  mysqli_fetch_array($hasil2);
		tabeldata($data['kode_barang'],$data['nama_barang'],$data['kode_kategori'],$data['stok']," ", $data['merk'], $data['sumber'], $data['tanggal_diubah'], $data2['jenis_kategori']);
	}
	echo "</table>";
}
?>

<!--search-->

<?php
if(isset($_POST['search'])){
	$search = $_POST['search'];
	$query1 = "select * from barang where nama_barang like '%".$search."%'";
	$hasil1 = mysqli_query($koneksi, $query1);
	if(mysqli_num_rows($hasil1)>0){
		tablestr();
		while($data = mysqli_fetch_array($hasil1)){
			$query2 = "select * from kategori where kode_kategori='".$data['kode_kategori']."'";
		$hasil2 = mysqli_query($koneksi, $query2);
		$data2 =  mysqli_fetch_array($hasil2);
		tabeldata($data['kode_barang'],$data['nama_barang'],$data['kode_kategori'],$data['stok']," ", $data['merk'], $data['sumber'], $data['tanggal_diubah'], $data2['jenis_kategori']);
		}
		echo "</table>";
	}
	else{
	echo "<center><h3>''Tidak ada hasil ditemukan''</h3></center>";
	}
	}
?>

<!--ganti pp-->

<?php
if(isset($_FILES['gantipp'])){
	$namafile = $_FILES['gantipp']['name'];
	$sizefile = $_FILES['gantipp']['size'];
	$errorfile = $_FILES['gantipp']['error'];
	$tmpfile = $_FILES['gantipp']['tmp_name'];
	
	if($errorfile === 4){
		header("location:peminjaman.php?upfile=error");
		die;
	}
	
	$validex = ['jpg', 'jpeg', 'png', 'heic', 'gif', 'webp'];
	$filex = explode('.', $namafile);
	$filex = strtolower(end($filex));
	if(!in_array($filex, $validex)){
		header("location:peminjaman.php?upfile2=tidackvalid");
		die;
	}
	
	if($sizefile > 2000000){
		header("location:peminjaman.php?upfile3=gedeteuing");
		die;
	}
	
	$newnamafile = uniqid().".".$filex;
	move_uploaded_file($tmpfile,'pp/'.$newnamafile);
	mysqli_query($koneksi, "update user set pp='pp/".$newnamafile."' where username='".$_SESSION['user']."'");
	header("location:peminjaman.php?upfile4=gantippber");

}
	
?>

<!--Tombol tampilkan tabel-->

<?php
if(isset($_POST['tabelawal'])){
	$query1 = "select * from barang";
	$hasil1 = mysqli_query($koneksi, $query1);
	tablestr();
	while($data = mysqli_fetch_array($hasil1)){
		$query2 = "select * from kategori where kode_kategori='".$data['kode_kategori']."'";
		$hasil2 = mysqli_query($koneksi, $query2);
		$data2 =  mysqli_fetch_array($hasil2);
		tabeldata($data['kode_barang'],$data['nama_barang'],$data['kode_kategori'],$data['stok']," ", $data['merk'], $data['sumber'], $data['tanggal_diubah'], $data2['jenis_kategori']);
	}
	
	echo "</table>";
}
?>

<!--Untuk memasukan barang baru-->

<?php
if(isset($_POST['tambahnama'])){
	$tambahnama = $_POST['tambahnama'];
	$tambahstok = $_POST['tambahstok'];
	$tambahkategori = $_POST['tambahkategori'];
	$tambahmerk = $_POST['tambahmerk'];
	$tambahsumber = $_POST['tambahsumber'];
	$verquery = "select * from barang where nama_barang='".$tambahnama."' and merk='".$tambahmerk."' and sumber='".$tambahsumber."'";
	$verrun = mysqli_query($koneksi, $verquery);
	$vernum = mysqli_num_rows($verrun);
	$querydesc = "select kode_barang from barang order by kode_barang desc limit 1";
	$rundesc = mysqli_query($koneksi, $querydesc);
	$rowdesc = mysqli_fetch_array($rundesc);
	$ambilkodeakhir = $rowdesc[0];
	mysqli_query($koneksi, "alter table barang AUTO_INCREMENT=".$ambilkodeakhir);
	if($vernum > 0){
		echo "<script>ketikaduplikat();</script>";
	}
	else{
		$tamquery = "insert into barang (nama_barang, kode_kategori, stok, tanggal_diubah, merk, sumber) values ('".$tambahnama."','".$tambahkategori."',".$tambahstok.", '".$tgl."', '".$tambahmerk."', '".$tambahsumber."')";
		mysqli_query($koneksi, $tamquery);
		echo "<script>ketikatidakduplikat();</script>";
		$queryhistori = "insert into histori (tanggal,tindakan, deskripsi) values ('".$tgl."','Tambah', 'Barang masuk: ".$tambahnama."')";
		mysqli_query($koneksi, $queryhistori);
	}
}
?>

<!--untuk penambahan stok-->

<?php
if(isset($_POST['verkebdatain'])){
	$namin = $_POST['tambahnama2'];
	$stoin = intval($_POST['tambahstok']);
	$queryjum = "select * from barang where nama_barang='".$namin."'";
	$runjum = mysqli_query($koneksi, $queryjum);
	$row = mysqli_fetch_array($runjum);
	$totjum = intval($row[3])+$stoin;
	$queryin = "update barang set stok=".$totjum." where nama_barang='".$namin."'";
	mysqli_query($koneksi, $queryin);
	echo "<script>ketikatidakduplikat();</script>";
	$queryhistori = "insert into histori (tanggal,tindakan, deskripsi) values ('".$tgl."','Edit', 'Barang : ".$namin."')";
	mysqli_query($koneksi, $queryhistori);
}
?>

<!--Penghapusan data-->

<?php
if(isset($_POST['hapusbrg'])){
	$hapkod = $_POST['hapusbrg'];
	$refreshtbl = $_POST['refreshtbl'];
	$fqrhapt = mysqli_query($koneksi, "select nama_barang from barang where kode_barang=".$hapkod);
	$dathapt = mysqli_fetch_array($fqrhapt);
	$queryhistori = "insert into histori (tanggal,tindakan, deskripsi) values ('".$tgl."','Hapus', 'Barang keluar: ".$dathapt['nama_barang']."')";
	mysqli_query($koneksi, $queryhistori);
 	$queryhap = "delete from barang where kode_barang=".$hapkod;
	mysqli_query($koneksi, $queryhap);
	$querytampila = "select * from barang ".$refreshtbl;
	$untukrefresh = mysqli_query($koneksi, $querytampila);
	if(mysqli_num_rows($untukrefresh) > 0 ){
		tablestr();
		while($data = mysqli_fetch_array($untukrefresh)){
			$query2 = "select * from kategori where kode_kategori='".$data['kode_kategori']."'";
			$hasil2 = mysqli_query($koneksi, $query2);
			$data2 =  mysqli_fetch_array($hasil2);
			tabeldata($data['kode_barang'],$data['nama_barang'],$data['kode_kategori'],$data['stok']," ", $data['merk'], $data['sumber'], $data['tanggal_diubah'], $data2['jenis_kategori']);
		}
		echo "</table>";
	}
	else{
		echo "<center><h3>''Tidak ada hasil ditemukan''</h3></center>";
	}
}
?>

<!--Edit data-->

<?php
if(isset($_POST['editbrg'])){
	$ednam = $_POST['editbrg'];
	$edstok = $_POST['editstok'];
	$edkat = $_POST['editkat'];
	$edkod = $_POST['editkod'];
	$edmerk = $_POST['editmerk'];
	$edsum = $_POST['editsum'];
 	$queryed = "update barang set nama_barang='".$ednam."', stok=".$edstok.", kode_kategori='".$edkat."', tanggal_diubah='".$tgl."', merk='".$edmerk."', sumber='".$edsum."' where kode_barang=".$edkod;
	mysqli_query($koneksi, $queryed);
	echo "<script>alert('Edit data berhasil!!');</script>";
	$queryhistori = "insert into histori (tanggal,tindakan, deskripsi) values ('".$tgl."','Edit', 'Barang: ".$ednam."')";
	mysqli_query($koneksi, $queryhistori);
}

?>


<!--History-->

<?php
if(isset($_POST['histori'])){
	$queryhis = "select * from histori";
	$runhis = mysqli_query($koneksi, $queryhis);
	echo "<div style=\"float : right; margin-right : 20px;\"><button style=\"margin-top : 5px;\" class=\"btn btn-danger\" onclick=\"hapushistori()\"><h6 style=\"padding :0; margin : 0;\">Hapus histori</h6></button></div><br><table class='table table-stripped'><tr><th>No</th><th>Tanggal</th><th>Tindakan</th><th><center>Deskripsi</center></th></tr>";
	while($data = mysqli_fetch_array($runhis)){
		echo "<tr><td>".$data['no_histori']."</td><td>".$data['tanggal']."</td><td>".$data['tindakan']."</td><td><center>".$data['deskripsi']."</center></td></tr>";
	}
	echo "</table>";
}
?>

<!--Hapus histori-->
<?php
if(isset($_POST['hapushistori'])){
	mysqli_query($koneksi, "delete from histori");
	echo "<script>alert('Hapus histori berhasil!!');</script>";
	$queryhis = "select * from histori";
	$runhis = mysqli_query($koneksi, $queryhis);
	echo "<div style=\"float : right; margin-right : 20px;\"><button style=\"margin-top : 5px;\" class=\"btn btn-danger\" onclick=\"hapushistori()\"><h6 style=\"padding :0; margin : 0;\">Hapus histori</h6></button></div><br><table class='table table-stripped'><tr><th>No</th><th>Tanggal</th><th>Tindakan</th><th><center>Deskripsi</center></th></tr>";
	while($data = mysqli_fetch_array($runhis)){
		echo "<tr><td>".$data['no_histori']."</td><td>".$data['tanggal']."</td><td>".$data['tindakan']."</td><td><center>".$data['deskripsi']."</center></td></tr>";
	}
	echo "</table>";
}
	
?>

<!--Peminjaman-->

<?php
if(isset($_POST['pinkod']) AND isset($_POST['pinquant'])){
	$pinkod = $_POST['pinkod'];
	$pinquant = intval($_POST['pinquant']);
	$pinquery = "select * from barang where kode_barang = ".$pinkod;
	$pinrun = mysqli_query($koneksi, $pinquery);
	$pintblcall = mysqli_fetch_array($pinrun);
	if($pinquant > $pintblcall[3]){
		echo "<script>alert('Jumlah yang anda minta lebih banyak dari persediaan, mohon masukan nilai sesuai stok yang tersedia!! jika anda melihat stok barangnya lebih banyak, silahkan refresh web ini');</script>";
	}
	else{
	$pinquerystat = "insert into status (username,barang,quantity,tanggal,status) values ('".$_SESSION['user']."', '".$pinkod."', ".$pinquant.", '".$tgl."', 'Menunggu konfirmasi')";
	mysqli_query($koneksi, $pinquerystat);
	echo "<script>alert('Request berhasil!! Mohon tunggu pemberiathuan selanjutnya');</script>";
	}
	
	
}
?>

<!--Pengembalian-->

<?php
if(isset($_POST['kemnoak'])){
	$kemnoak = $_POST['kemnoak'];
	$kemkdbr = $_POST['kemkdbr'];
	$kemquesel = "select * from status";
	$kemrunsel = mysqli_query($koneksi, $kemquesel);
	$kemtblcall = mysqli_fetch_array($kemrunsel);
	$kemqueup = "update status set status='Menunggu Konfirmasi pengembalian', tanggal='".$tgl."' where no_aksi=".$kemnoak;
	mysqli_query($koneksi, $kemqueup);
	$tamsquery = "select * from status where username='".$_SESSION['user']."'";
	$tamsrun = mysqli_query($koneksi, $tamsquery);
	$hitler = 0;
	echo "<table class='table table-stripped'><tr><th>No</th><th>Faktur</th><th>Tanggal</th><th>Barang</th><th>Jumlah</th><th><center>Status</center></th></tr>";
	while($tamsdata = mysqli_fetch_array($tamsrun)){
		$hitler++;
		if($tamsdata['status'] == "Menunggu konfirmasi"){
			$tamspilnque = mysqli_query($koneksi, "select nama_barang from barang where kode_barang=".$tamsdata['barang']);
			$tamspilnrun = mysqli_fetch_array($tamspilnque);
			echo "<tr><td>".$hitler."</td><td>".$tamsdata['no_aksi']."</td><td>".$tamsdata['tanggal']."</td><td>".$tamspilnrun['nama_barang']."</td><td>".$tamsdata['quantity']."</td><td><center>".$tamsdata['status']."</center></td></tr>";
		}
		else if($tamsdata['status'] == "Sedang dipinjam"){
			$tamspilnque = mysqli_query($koneksi, "select nama_barang from barang where kode_barang=".$tamsdata['barang']);
			$tamspilnrun = mysqli_fetch_array($tamspilnque);
			echo "<tr><td>".$hitler."</td><td>".$tamsdata['no_aksi']."</td><td>".$tamsdata['tanggal']."</td><td>".$tamspilnrun['nama_barang']."</td><td>".$tamsdata['quantity']."</td><td><center>
			<button class='btn btn-success btn-sm' onclick=\"kembalikan(".$tamsdata['no_aksi'].", ".$tamsdata['barang'].")\">Kembalikan</button></center></td></tr>";
		}
		else if($tamsdata['status'] == "Ditolak"){
			$tamspilnque = mysqli_query($koneksi, "select nama_barang from barang where kode_barang=".$tamsdata['barang']);
			$tamspilnrun = mysqli_fetch_array($tamspilnque);
			echo "<tr><td>".$hitler."</td><td>".$tamsdata['no_aksi']."</td><td>".$tamsdata['tanggal']."</td><td>".$tamspilnrun['nama_barang']."</td><td>".$tamsdata['quantity']."</td><td style='color : red;'><center>".$tamsdata['status']."</center></td></tr>";
		}
		else if($tamsdata['status'] == "Sudah kembali"){
			$tamspilnque = mysqli_query($koneksi, "select nama_barang from barang where kode_barang=".$tamsdata['barang']);
			$tamspilnrun = mysqli_fetch_array($tamspilnque);
			echo "<tr><td>".$hitler."</td><td>".$tamsdata['no_aksi']."</td><td>".$tamsdata['tanggal']."</td><td>".$tamspilnrun['nama_barang']."</td><td>".$tamsdata['quantity']."</td><td style='color : orange;'><center>".$tamsdata['status']."</center></td></tr>";
		}
		else if($tamsdata['status'] == "Menunggu Konfirmasi pengembalian"){
			$tamspilnque = mysqli_query($koneksi, "select nama_barang from barang where kode_barang=".$tamsdata['barang']);
			$tamspilnrun = mysqli_fetch_array($tamspilnque);
			echo "<tr><td>".$hitler."</td><td>".$tamsdata['no_aksi']."</td><td>".$tamsdata['tanggal']."</td><td>".$tamspilnrun['nama_barang']."</td><td>".$tamsdata['quantity']."</td><td style='color : blue;'><center>".$tamsdata['status']."</center></td></tr>";
		}
	}
	echo "</table>";
	
}
?>

<!--Konfirmasi peminjaman oleh admin-->

<?php
if(isset($_POST['konpinoak'])){
	$konpinoak = $_POST['konpinoak'];
	$konpitin = $_POST['konpitindakan'];
	$konpikdbar = intval($_POST['konpikdbar']);
	if($konpitin == "setuju"){
		$konpiquery = "update status set status='Sedang dipinjam', tanggal='".$tgl."' where no_aksi=".$konpinoak;
		$konpiquesel = "select * from status where no_aksi=".$konpinoak;
		$konpirunsel = mysqli_query($koneksi, $konpiquesel);
		$konpifetchsel = mysqli_fetch_array($konpirunsel);
		$konpiquesel2 = "select stok, nama_barang from barang where kode_barang=".$konpikdbar;
		$konpirunsel2 = mysqli_query($koneksi, $konpiquesel2);
		$konpifetchsel2 = mysqli_fetch_array($konpirunsel2);
		$konpitotsok = $konpifetchsel2[0]-$konpifetchsel[3];
		$konpiqueup = "update barang set stok=".$konpitotsok." where kode_barang=".$konpikdbar;
		mysqli_query($koneksi, $konpiqueup);
	}
	else{
		$konpiquery = "update status set status='Ditolak', tanggal='".$tgl."' where no_aksi=".$konpinoak;
	}
	mysqli_query($koneksi, $konpiquery);
	$perun = mysqli_query($koneksi, "select * from status where status='Menunggu konfirmasi' or status='Menunggu Konfirmasi pengembalian'");
	if(mysqli_num_rows($perun) == 0){
			echo "<center><h2>Tidak ada aktivitas untuk sekarang</h2></center>";
			die;
		}
	$hitler = 0;
	echo "<table class='table table-stripped'><tr><th>No</th><th>Faktur</th><th>Tanggal</th><th>Username</th><th>Barang</th><th>Jumlah</th><th><center>Konfirmasi</center></th></tr>";
	while($konpidata = mysqli_fetch_array($perun)){
		$hitler++;
		$perpilnque = mysqli_query($koneksi, "select nama_barang from barang where kode_barang=".$konpidata['barang']);
		$perpilnrun = mysqli_fetch_array($perpilnque);
		if($konpidata['status'] == "Menunggu konfirmasi"){
			tableperadmin($hitler, $konpidata['no_aksi'], $konpidata['tanggal'], $konpidata['username'], $konpidata[0], $konpidata['quantity'], $konpidata['barang']);
		}
		else{
			tableperkemadmin($hitler, $konpidata['no_aksi'], $konpidata['tanggal'], $konpidata['username'], $konpidata[0], $konpidata['quantity'], $konpidata['barang']);
		}
	}
	echo "</table>";
	$queryhistori = "insert into histori (tanggal,tindakan, deskripsi) values ('".$tgl."','Konfirmasi peminjaman', 'None')";
	mysqli_query($koneksi, $queryhistori);
	
}

?>

<!--Konfirmasi pengembalian oleh admin-->

<?php
if(isset($_POST['konkemnoak'])){
	$konkemnoak = $_POST['konkemnoak'];
	$konkemkdbr = $_POST['konkemkdbr'];
	$konkemquery = "update status set status='Sudah kembali', tanggal='".$tgl."' where no_aksi=".$konkemnoak;
	mysqli_query($koneksi, $konkemquery);
	$konkemquesel = "select * from status where no_aksi=".$konkemnoak;
	$konkemrunsel = mysqli_query($koneksi, $konkemquesel);
	$konkemfetchsel = mysqli_fetch_array($konkemrunsel);
	$konkemquesel2 = "select stok, nama_barang from barang where kode_barang=".$konkemkdbr;
	$konkemrunsel2 = mysqli_query($koneksi, $konkemquesel2);
	$konkemfetchsel2 = mysqli_fetch_array($konkemrunsel2);
	$konkemtotsok = $konkemfetchsel2[0]+$konkemfetchsel[3];
	$konkemqueup = "update barang set stok=".$konkemtotsok." where kode_barang=".$konkemkdbr;
	mysqli_query($koneksi, $konkemqueup);
	$kemrun = mysqli_query($koneksi, "select * from status where status='Menunggu konfirmasi' or status='Menunggu Konfirmasi pengembalian'");
	if(mysqli_num_rows($kemrun) == 0){
			echo "<center><h2>Tidak ada aktivitas untuk sekarang</h2></center>";
			die;
	}
	$hitler = 0;
	echo "<table class='table table-stripped'><tr><th>No</th><th>Faktur</th><th>Tanggal</th><th>Username</th><th>Barang</th><th>Jumlah</th><th><center>Konfirmasi</center></th></tr>";
	while($konkemdata = mysqli_fetch_array($kemrun)){
		$hitler++;
		$perpilnque = mysqli_query($koneksi, "select nama_barang from barang where kode_barang=".$konkemdata['barang']);
		$perpilnrun = mysqli_fetch_array($perpilnque);
		if($konkemdata['status'] == "Menunggu konfirmasi"){
			tableperadmin($hitler, $konkemdata['no_aksi'], $konkemdata['tanggal'], $konkemdata['username'], $konkemdata[0], $konkemdata['quantity'], $konkemdata['barang']);
		}
		else{
			tableperkemadmin($hitler, $konkemdata['no_aksi'], $konkemdata['tanggal'], $konkemdata['username'], $konkemdata[0], $konkemdata['quantity'], $konkemdata['barang']);
		}
	}
	echo "</table>";
	$queryhistori = "insert into histori (tanggal,tindakan, deskripsi) values ('".$tgl."','Konfirmasi pengembalian', 'None')";
	mysqli_query($koneksi, $queryhistori);
}
?>

<!--Tampil permintaan untuk admin-->

<?php
if(isset($_POST['tampilpermintaan'])){
	$perun = mysqli_query($koneksi, "select * from status where status='Menunggu konfirmasi' or status='Menunggu Konfirmasi pengembalian'");
	$hitler = 0;
	if(mysqli_num_rows($perun) == 0){
		echo "<center><h2>Tidak ada aktivitas untuk sekarang</h2></center>";
		die;
	}
	echo "<table class='table table-stripped'><tr><th>No</th><th>Faktur</th><th>Tanggal</th><th>Username</th><th>Barang</th><th>Jumlah</th><th><center>Konfirmasi</center></th></tr>";
	while($perdata = mysqli_fetch_array($perun)){
		if($perdata['status'] == "Menunggu konfirmasi"){
		$hitler++;
		$perpilnque = mysqli_query($koneksi, "select nama_barang from barang where kode_barang=".$perdata['barang']);
		$perpilnrun = mysqli_fetch_array($perpilnque);
		tableperadmin($hitler, $perdata['no_aksi'], $perdata['tanggal'], $perdata['username'], $perpilnrun[0], $perdata['quantity'], $perdata['barang']);
		}
		else{
		$hitler++;
		$perpilnque = mysqli_query($koneksi, "select nama_barang from barang where kode_barang=".$perdata['barang']);
		$perpilnrun = mysqli_fetch_array($perpilnque);
		tableperkemadmin($hitler, $perdata['no_aksi'], $perdata['tanggal'], $perdata['username'], $perpilnrun[0], $perdata['quantity'], $perdata['barang']);
		}
	}
	echo "</table>";
}
?>

<!--Tampilan list status untuk user-->

<?php
if(isset($_POST['tampilstatus'])){
	$tamsquery = "select * from status where username='".$_SESSION['user']."'";
	$tamsrun = mysqli_query($koneksi, $tamsquery);
	$hitler = 0;
	echo "<table class='table table-stripped'><tr><th>No</th><th>Faktur</th><th>Tanggal</th><th>Barang</th><th>Jumlah</th><th><center>Status</center></th></tr>";
	while($tamsdata = mysqli_fetch_array($tamsrun)){
		$hitler++;
		if($tamsdata['status'] == "Menunggu konfirmasi"){
			$tamspilnque = mysqli_query($koneksi, "select nama_barang from barang where kode_barang=".$tamsdata['barang']);
			$tamspilnrun = mysqli_fetch_array($tamspilnque);
			echo "<tr><td>".$hitler."</td><td>".$tamsdata['no_aksi']."</td><td>".$tamsdata['tanggal']."</td><td>".$tamspilnrun['nama_barang']."</td><td>".$tamsdata['quantity']."</td><td><center>".$tamsdata['status']."</center></td></tr>";
		}
		else if($tamsdata['status'] == "Sedang dipinjam"){
			$tamspilnque = mysqli_query($koneksi, "select nama_barang from barang where kode_barang=".$tamsdata['barang']);
			$tamspilnrun = mysqli_fetch_array($tamspilnque);
			echo "<tr><td>".$hitler."</td><td>".$tamsdata['no_aksi']."</td><td>".$tamsdata['tanggal']."</td><td>".$tamspilnrun['nama_barang']."</td><td>".$tamsdata['quantity']."</td><td><center>
			<button class='btn btn-success btn-sm' onclick=\"kembalikan(".$tamsdata['no_aksi'].", ".$tamsdata['barang'].")\">Kembalikan</button></center></td></tr>";
		}
		else if($tamsdata['status'] == "Ditolak"){
			$tamspilnque = mysqli_query($koneksi, "select nama_barang from barang where kode_barang=".$tamsdata['barang']);
			$tamspilnrun = mysqli_fetch_array($tamspilnque);
			echo "<tr><td>".$hitler."</td><td>".$tamsdata['no_aksi']."</td><td>".$tamsdata['tanggal']."</td><td>".$tamspilnrun['nama_barang']."</td><td>".$tamsdata['quantity']."</td><td style='color : red;'><center>".$tamsdata['status']."</center></td></tr>";
		}
		else if($tamsdata['status'] == "Sudah kembali"){
			$tamspilnque = mysqli_query($koneksi, "select nama_barang from barang where kode_barang=".$tamsdata['barang']);
			$tamspilnrun = mysqli_fetch_array($tamspilnque);
			echo "<tr><td>".$hitler."</td><td>".$tamsdata['no_aksi']."</td><td>".$tamsdata['tanggal']."</td><td>".$tamspilnrun['nama_barang']."</td><td>".$tamsdata['quantity']."</td><td style='color : orange;'><center>".$tamsdata['status']."</center></td></tr>";
		}
		else if($tamsdata['status'] == "Menunggu Konfirmasi pengembalian"){
			$tamspilnque = mysqli_query($koneksi, "select nama_barang from barang where kode_barang=".$tamsdata['barang']);
			$tamspilnrun = mysqli_fetch_array($tamspilnque);
			echo "<tr><td>".$hitler."</td><td>".$tamsdata['no_aksi']."</td><td>".$tamsdata['tanggal']."</td><td>".$tamspilnrun['nama_barang']."</td><td>".$tamsdata['quantity']."</td><td style='color : blue;'><center>".$tamsdata['status']."</center></td></tr>";
		}
	}
	echo "</table>";
}
?>



<!--Function table-->

<?php

//function table

function tabeldata($kdbrgtb, $nmbrgtb, $katbrgtb, $stoktb, $medkat, $merk, $sumber, $tbgal,$nmkatbrg){
	//untuk admin
	if($_SESSION['role'] == "admin"){
		echo "<tr><td>".$kdbrgtb."</td><td>".$nmbrgtb."</td><td>".$nmkatbrg."</td><td>".$stoktb."</td><td>".$merk."</td><td>".$sumber."</td><td>".$tbgal."</td><td><center><img src='edit.png' style='width : 17px; cursor : pointer;' 
		onclick=\"editdata(".$kdbrgtb.", '".$nmbrgtb."', '".$katbrgtb."', '".$stoktb."', '".$merk."', '".$sumber."')\">
		<img src=\"delete.png\" style=\"width : 20px; cursor : pointer;\" onclick=\"hapusdata(".$kdbrgtb.",'".$medkat."')\"></center></td></tr>";
	}
	//untuk user
	else{
		echo "<tr><td>".$kdbrgtb."</td><td>".$nmbrgtb."</td><td>".$nmkatbrg."</td><td>".$stoktb."</td><td>".$merk."</td><td>".$sumber."</td><td>".$tbgal."</td><td><center>
		<button class=\"btn btn-primary btn-sm\" style=\"border-radius : 15px; width : 70px;\" onclick=\"pinjam(".$kdbrgtb.",)\">Pinjam</button</center></td></tr>";
	}
}	

//function struktur tabel

function tablestr(){
	//admin
	if($_SESSION['role'] == "admin"){
		echo "<table class='table table-stripped'><tr><th>Kode barang</th><th>Barang</th><th>Kategori</th><th>Stok</th><th>Merk</th><th>Sumber</th><th>Tanggal diubah</th><th><center>Delete & edit</center></th></tr>";
	}
	//user
	else{
		echo "<table class='table table-stripped'><tr><th>Kode barang</th><th>Barang</th><th>Kategori</th><th>Stok</th><th>Merk</th><th>Sumber</th><th>Tanggal diubah</th><th><center>Peminjaman</center></th></tr>";
	}
}

function tableperadmin($no, $konpinoak, $konpitgl, $konpiuser, $konpibrg, $konpiquant, $konpikdbr){
	echo "<tr><td>".$no."</td><td>".$konpinoak."</td><td>".$konpitgl."</td><td>".$konpiuser."</td><td>".$konpibrg."</td><td>".$konpiquant."</td><td><center>
		<button class='btn btn-success btn-sm' onclick=\"konfirm('".$konpinoak."','setuju', ".$konpikdbr.")\">Accept</button><button class='btn btn-danger btn-sm' onclick=\"konfirm('".$konpinoak."','tolak', ".$konpikdbr.")\">Deny</button></center></td></tr>";
	
}

function tableperkemadmin($no2, $konpinoak2, $konpitgl2, $konpiuser2, $konpibrg2, $konpiquant2, $konpikdbr2){
	echo "<tr><td>".$no2."</td><td>".$konpinoak2."</td><td>".$konpitgl2."</td><td>".$konpiuser2."</td><td>".$konpibrg2."</td><td>".$konpiquant2."</td><td><center>
		<button class='btn btn-success btn-sm' onclick=\"konfirmkem('".$konpinoak2."', ".$konpikdbr2.")\">Konfirmasi pengembalian</button></center></td></tr>";
	
}
?>
