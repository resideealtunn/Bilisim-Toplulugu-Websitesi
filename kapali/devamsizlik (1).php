<?php
	include("baglan.php");
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
    <title>Devamsızlık Sorgu</title>
    <style>

        .form-section {
            display: block;
            font-size: 1.5rem;
            margin: 2rem;
        }
        .labelBox {
            margin-bottom: 1em;
            font-size: 1.2em;
            font-weight: bold;
        }
        .labelBox label {
            display: block;
            color: #333;
            margin-bottom: 0.5em;
        }
        .labelBox .value {
            display: block;
            padding: 0.5em;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            border-radius: 5px;
            visibility: visible;
        }
        .member-registration {
            padding: 2em;
            max-width: 600px;
            margin: auto;
        }
        .event-section {
            display: block;
            margin-top: 1em;
            background-color: #f9f9f9;
            padding: 1em;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .event-section table {
            width: 100%;
            border-collapse: collapse;
        }
        .event-section table, .event-section th, .event-section td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .event-section th {
            background-color: #f2f2f2;
        }
        .btn {
            display: inline-block;
            margin-top: 1em;
            padding: 0.5em 1em;
            background-color: #112958;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
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
        </nav>
      </header>
    <!-- Main Content -->
    <section class="member-registration">
        <h3>Devamsızlık Durumu</h3>
        <div id="member-registration-form">
            <div class="event-section" id="event-section">
                <table>
                    <tr>
                        <th>Etkinlik</th>
                        <th>Durum</th>
                    </tr>
					<?php
					if(isset($_POST['devam']))
					{
						$numara=$_POST["devamno"];
						$sql1="select uyeler.numara,uyeler.isim,
                                SUM(
                                    CASE 
                                        WHEN etkinlik_kayit.etkinlik_id=46 THEN 3
                                        WHEN etkinlik_kayit.etkinlik_id IS NOT NULL THEN 1
                                        ELSE 0
                                    END
                                ) + 
                                CASE
                                    WHEN indirim.uye_id IS NOT NULL THEN 1
                                    ELSE 0
                                END AS katılım
                                    from etkinlik_kayit 
                                    inner join uyeler on uyeler.id=etkinlik_kayit.uye_id 
                                    INNER join etkinlikler on etkinlik_kayit.etkinlik_id=etkinlikler.id 
                                    left join indirim ON uyeler.id = indirim.uye_id
                                    GROUP by etkinlik_kayit.uye_id 
                                    order by katılım desc, bolum asc, etkinlik_kayit.uye_id asc;  ";
									$count1=mysqli_query($baglanti,$sql1);
									$row2=mysqli_fetch_all($count1);
									$kontrol=0;
									if(!$numara)
									{
									}
									else
									{
										for($i=0;$i<count($row2);$i++)
										{
											if($row2[$i][0]==$numara)
											{
												$isim=$row2[$i][1];
												$ktlm=$row2[$i][2];
												$sira=$i+1;
												
											$kontrol=1;
											}
										}
										if($kontrol==1)
										{
											
										}
										
									}
            						$sql="SELECT etkinlikler.isim AS eisim, 
            						CASE WHEN etkinlik_kayit.uye_id IS NOT NULL THEN 1 ELSE 0 END AS kd
            						FROM etkinlikler
            						LEFT JOIN etkinlik_kayit ON etkinlikler.id = etkinlik_kayit.etkinlik_id 
            						AND etkinlik_kayit.uye_id = (SELECT id FROM uyeler WHERE numara ='$numara')
            						order by kd desc";
            						$result=mysqli_query($baglanti,$sql);
            						$ekayit=mysqli_fetch_all($result);
									if($ekayit)
									{	
										if($numara!=null)
										{
											$sql1="select * from uyeler where numara='$numara'";
											$count1=mysqli_query($baglanti,$sql1);
											$row=mysqli_fetch_assoc($count1);
											if($row)
											{
												echo"<div class='onemli'>
													<h3 align='center' style='color:red'>$isim $ktlm Puan İle $sira. Sıradasınız</h3>
												</div>
												<table class='table table-striped'>";
												for($i=0;$i<count($ekayit);$i++)
												{
													echo "<tr>
													<th style='text-align:center'>"; print_r($ekayit[$i][0]);echo " </th>
													<td style='text-align:center'>";if($ekayit[$i][1]==1){echo "Katıldı";}else{echo "Katılmadı";} echo"</td>
													</tr>
													";
												}
												echo "</table>";
											}
											else{
												echo"<div class='onemli'>
													<h3 align='center'>Lütfen Kayıt Olun</h3>
												</div>";
											}
										}
										else{
											echo"<div class='onemli'>
													<h3 align='center'>Lütfen Numaranızı Girin</h3>
												</div>";
										}
									}
                    }
					?>
                </table>
            </div>
        </div>
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
