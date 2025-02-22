<?php
	include("baglan.php");
	$eid=array();
?>
<html lang="">
  <!-- Mirrored from keenitsolutions.com/products/html/educavo/index4.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 02 Aug 2024 08:04:38 GMT -->
  <head>
    <!-- meta tag -->
    <meta charset="utf-8" />
    <title>Etkinliklerimiz</title>
    <meta name="description" content="" />
    <!-- responsive tag -->
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- favicon -->
    <link rel="apple-touch-icon" href="apple-touch-icon.html" />
    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="images/bilisimlogo.png"
    />
    <!-- Bootstrap v4.4.1 css -->
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/css/bootstrap.min.css"
    />
    <!-- font-awesome css -->
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/css/font-awesome.min.css"
    />
    <!-- animate css -->
    <link rel="stylesheet" type="text/css" href="assets/css/animate.css" />
    <!-- owl.carousel css -->
    <link rel="stylesheet" type="text/css" href="assets/css/owl.carousel.css" />
    <!-- slick css -->
    <link rel="stylesheet" type="text/css" href="assets/css/slick.css" />
    <!-- off canvas css -->
    <link rel="stylesheet" type="text/css" href="assets/css/off-canvas.css" />
    <!-- linea-font css -->
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/fonts/linea-fonts.css"
    />
    <!-- flaticon css  -->
    <link rel="stylesheet" type="text/css" href="assets/fonts/flaticon.css" />
    <!-- magnific popup css -->
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/css/magnific-popup.css"
    />
    <!-- Main Menu css -->
    <link rel="stylesheet" href="assets/css/rsmenu-main.css" />
    <!-- spacing css -->
    <link rel="stylesheet" type="text/css" href="assets/css/rs-spacing.css" />
    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="style.css" />
    <!-- This stylesheet dynamically changed from style.less -->
    <!-- responsive css -->
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css" />
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
  </head>
  <body class="home-style3">
    <nav class="navbar navbar-expand-lg bg-body-tertiary header">
  <div class="container-fluid">
    <a class="navbar-brand logo" href="anasayfa">
      <img src="images/bilisimlogo.png" alt="logo" />
    </a>
    <div class="collapse navbar-collapse navbar" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index">Ana Sayfa</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="etkinlikler">Etkinlikler</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="sponsorlar">Sponsorlar</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="uyeislemleri">Üye İşlemleri</a>
        </li>
      </ul>
      <div class="buttons">
        <!--navbarın kenarındaki iconlar için-->
      </div>
    </div>
  </div>
</nav>

    <!-- Popular Course Section Start -->
    <div class="rs-popular-courses style2 bg3 pt-94 pb-200 md-pt-64 md-pb-90">
		<div class="container">
			<div class="sec-title mb-60 text-center md-mb-30">
			  <h2 class="title mb-0" style='color:skyblue'>Aktif Başvuru</h2>
			</div>
			<div class='row'>
				<?php
					$sql1="select isim,bilgi,aciklama,gorsel,id from etkinlikler
					where b_durum=0
					order by id desc";
					$result1=mysqli_query($baglanti,$sql1);
					$row1=mysqli_fetch_all($result1);
					for($i=0;$i<count($row1);$i++)
					{
						$isim=$row1[$i][0];
						$bilgi=$row1[$i][1];
						$aciklama=$row1[$i][2];
						$gorsel=$row1[$i][3];
						$id=$row1[$i][4];
						echo"<div class='col-lg-4 col-md-6 mb-30'>
					<div class='course-wrap'>
					  <div class='front-part'>
						<div class='img-part'>
						  <img src='images/$gorsel'/>
						</div>
						<div class='content-part'>
						  <a class='categorie' href='uyeislemleri'>$isim</a>
						  <h4 class='title'>
							<a>$bilgi</a>
						  </h4>
						</div>
					  </div>
					  <div class='inner-part'>
						<div class='content-part'>
						  <a class='categorie' href='uyeislemleri'>$isim</a>
						  <h4 class='title'>
							<a href='uyeislemleri'>$aciklama</a>
						  </h4>
						</div>
					  </div>
					</div>
				  </div>";
					}
					if(count($row1)==0)
					{
						echo "<h3 style='color:red; text-align:center'>Aktif Başvuru Bulunmamakta</h3>";
					}
			?>
			</div>
		</div>
      <div class="container">
        <div class="sec-title mb-60 text-center md-mb-30">
          <h2 class="title mb-0" style='color:skyblue'>Geçmiş Etkinlikler</h2>
        </div>
		<div class='row'>
			<?php
				$sql1="select isim,bilgi,aciklama,gorsel,id from etkinlikler
				where p_durum=1
				order by id desc";
				$result1=mysqli_query($baglanti,$sql1);
				$row1=mysqli_fetch_all($result1);
				for($i=0;$i<3;$i++)
				{
					$isim=$row1[$i][0];
					$bilgi=$row1[$i][1];
					$aciklama=$row1[$i][2];
					$gorsel=$row1[$i][3];
					$id=$row1[$i][4];
					array_push($eid,$id);
					echo"<div class='col-lg-4 col-md-6 mb-30'>
				<div class='course-wrap'>
				  <div class='front-part'>
					<div class='img-part'>
					  <img src='images/$gorsel'/>
					</div>
					<div class='content-part'>
					  <a class='categorie'>$isim</a>
					  <h4 class='title'>
						<a>$bilgi</a>
					  </h4>
					</div>
				  </div>
				  <div class='inner-part'>
					<div class='content-part'>
					  <a class='categorie'>$isim</a>
					  <h4 class='title'>
						<a>$aciklama</a>
					  </h4>
					</div>
				  </div>
				</div>
			  </div>";
				}
			?>
		</div>
		<div class='row'>
			<?php
				$sql="SELECT e.isim,e.bilgi,e.aciklama,e.gorsel,e.id
				FROM etkinlik_kayit AS ek
				INNER JOIN etkinlikler AS e ON e.id = ek.etkinlik_id
				WHERE e.p_durum=1
				GROUP BY e.id, e.isim, e.bilgi, e.aciklama, e.gorsel
				ORDER BY COUNT(ek.etkinlik_id) DESC;";
				$result=mysqli_query($baglanti,$sql);
				$row=mysqli_fetch_all($result);
				for($i=0;$i<count($row);$i++)
				{
					$isim=$row[$i][0];
					$bilgi=$row[$i][1];
					$aciklama=$row[$i][2];
					$gorsel=$row[$i][3];
					$id=$row[$i][4];
					if(!in_array($id,$eid))
					{
						array_push($eid,$id);
						echo"<div class='col-lg-4 col-md-6 mb-30'>
					<div class='course-wrap'>
					  <div class='front-part'>
						<div class='img-part'>
						  <img src='images/$gorsel'/>
						</div>
						<div class='content-part'>
						  <a class='categorie'>$isim</a>
						  <h4 class='title'>
							<a>$bilgi</a>
						  </h4>
						</div>
					  </div>
					  <div class='inner-part'>
						<div class='content-part'>
						  <a class='categorie'>$isim</a>
						  <h4 class='title'>
							<a>$aciklama</a>
						  </h4>
						</div>
					  </div>
					</div>
				  </div>";
					}
					if(count($eid)==6)
					{
						break;
					}
				}
			?>
		</div>
		<div class='row'>
			<?php
				$sql1="SELECT e.isim, e.bilgi,e.aciklama,e.gorsel, e.id		
				FROM basvuru AS eb
				INNER JOIN etkinlikler AS e ON e.id = eb.etkinlik_id
				WHERE e.p_durum=1
				GROUP BY e.id, e.isim, e.bilgi, e.aciklama, e.gorsel
				ORDER BY COUNT(eb.etkinlik_id) DESC";
				$result1=mysqli_query($baglanti,$sql1);
				$row1=mysqli_fetch_all($result1);
				for($i=0;$i<count($row1);$i++)
				{
					$isim=$row1[$i][0];
					$bilgi=$row1[$i][1];
					$aciklama=$row1[$i][2];
					$gorsel=$row1[$i][3];
					$id=$row1[$i][4];
					if(!in_array($id,$eid))
					{
						array_push($eid,$id);
							echo"<div class='col-lg-4 col-md-6 mb-30'>
						<div class='course-wrap'>
						  <div class='front-part'>
							<div class='img-part'>
							  <img src='images/$gorsel'/>
							</div>
							<div class='content-part'>
							  <a class='categorie'>$isim</a>
							  <h4 class='title'>
								<a>$bilgi</a>
							  </h4>
							</div>
						  </div>
						  <div class='inner-part'>
							<div class='content-part'>
							  <a class='categorie'>$isim</a>
							  <h4 class='title'>
								<a>$aciklama</a>
							  </h4>
							</div>
						  </div>
						</div>
					  </div>";
					}
					if(count($eid)==9)
					{
						break;
					}
				}
			?>
		</div>
      </div>
    </div>

	<footer class="footer py-3 my-4">
      <div class="share">
        <a
			style='border:0.1rem solid rgba(255, 255, 255, 0.4);'
          href="https://chat.whatsapp.com/CNoPPLXvyTJAQhkft0nkc0"
          class="fab fa-whatsapp"
        ></a>
        <a
					style='border:0.1rem solid rgba(255, 255, 255, 0.4);'
          href="https://github.com/neubilisimtoplulugu"
          class="fab fa-github"
        ></a>
        <a
					style='border:0.1rem solid rgba(255, 255, 255, 0.4);'
          href="https://www.instagram.com/neubilisimtoplulugu/"
          class="fab fa-instagram"
        ></a>
        <a
			style='border:0.1rem solid rgba(255, 255, 255, 0.4);'		
		href="https://www.linkedin.com/company/necmettin-erbakan-%C3%BCniversitesi-bili%C5%9Fim-toplulu%C4%9Fu/?viewAsMember=true" class="fab fa-linkedin"></a>
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
  </body>
</html>
