<?php
	include("baglan.php");
	session_start();      //oturum başlat
	$alert=null;
	$tur="success";
	if(isset($_POST['giris']))
	{
		$isim=$_POST['isim'];
		$sifre=$_POST['sifre'];
		if($isim<>"" and $sifre<>"")    //bos mu
		{
			$sql="select * from departmanlar where isim='$isim' and sifre='$sifre'";
			$result=mysqli_query($baglanti,$sql);
			$row=mysqli_fetch_all($result);
			if($row)
			{
				$_SESSION['id']=$row[0][0];
				header("Location:yonetici");
			}
			else
			{
				$alert='Bilgiler Yanlış';
				$tur='danger';
			}
		}
		else
		{
			$alert='Bilgileri Boş Bırakmayınız';
			$tur='danger';
		}
	}
?>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="styles/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="styles/styleuye.css" />
    <link rel="shortcut icon" type="image/x-icon" href="images/bilisimlogo.png">
	

    <title>Yönetici İşlemleri</title>
</head>
<body>
    <header class="header">
        <!--baştaki home about vs. kısmı-->
        <a href="index" class="logo">
          <!-- logo için-->
          <img src="images/bilisimlogo.png" alt="logo" />
        </a>
        <nav class="navbar">
          <a href="index">Ana Sayfa</a>
          <a href="etkinlikler">Etkinlikler</a>
          <a href="sponsorlar">Sponsorlar</a>
          <a href="uyeislemleri">Üye İşlemleri</a>
          <a href="yoneticiislemleri"   class="active">Yönetici İşlemleri</a>
        </nav>
        <div class="buttons">
          <!--navbarın kenarındaki iconlar için-->
        </div>
      </header>
    <section class="member-registration">
        <h1>YÖNETİCİ İŞLEMLERİ</h1>
		<?php
		if($alert)
		{
			echo"<div class='alert alert-$tur' role='alert'>
				$alert
			</div>";
		}
	?>
		<form method="post">
            <div class="inputBox">
                <label for="fullName">Kullanıcı Adı</label>
                <input type="text" id="fullName" name="isim" placeholder="Kullanıcı Adı" required />
            </div>
            <div class="inputBox">
                <label for="studentId">Şifre</label>
                <input type="password" id="studentId" name="sifre" placeholder="Şifre" required />
            </div>

            <input type="submit" class="btn"name='giris' value="Yönetici Giriş" />
        </form>
    </section>

   <footer class="footer py-3 my-4">
      <div class="share">
        <a
		style='text-decoration: none;'
          href="https://chat.whatsapp.com/CNoPPLXvyTJAQhkft0nkc0"
          class="fab fa-whatsapp"
        ></a>
        <a
		style='text-decoration: none;'
          href="https://github.com/neubilisimtoplulugu"
          class="fab fa-github"
        ></a>
        <a
		style='text-decoration: none;'
          href="https://www.instagram.com/neubilisimtoplulugu/"
          class="fab fa-instagram"
        ></a>
        <a
		style='text-decoration: none;'
		href="https://www.linkedin.com/company/necmettin-erbakan-%C3%BCniversitesi-bili%C5%9Fim-toplulu%C4%9Fu/?viewAsMember=true" class="fab fa-linkedin" class="fab fa-linkedin"></a>
      </div>
      <div class="links nav justify-content-center border-bottom pb-3 mb-3 ">
        <a href="index" class="active nav-link">Ana Sayfa</a>
        <a href="etkinlikler" class="nav-link">Etkinlikler</a>
        <a href="sponsorlar" class="nav-link">Sponsorlar</a>
        <a href="uyeislemleri" class="nav-link">Üye İşlemleri</a>
      </div>
      <div class="credit">
        <p class="text-center">© 2024 Bilişim Topluluğu, Tüm Hakları Saklıdır.</p>
      </div>
    </footer>