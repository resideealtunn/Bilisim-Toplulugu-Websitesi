<?php

	$host = "localhost";
	$kullaniciadi = "bgsie2tsqh46";
	$parola = "SopuYk#ksg8G";
	$vt = "yenibt";
	
	$baglanti = mysqli_connect($host,$kullaniciadi,$parola,$vt);
	mysqli_set_charset($baglanti,"UTF8");
	
	if($baglanti)
	{
	}
	else
	{
			echo "<script  type='text/javascript'>
				confirm('Bağlantıda Hata Oluştu');
				</script>";
	}
?>