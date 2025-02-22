<?php
	ob_start();
	session_start();
	include("baglan.php");
	$message=null;
	$tur='danger';
	if(!$_SESSION['id'])
	{
		header("Location:anasayfa");
	}
	function resimyukle($resim, $prefix, $dhedef) {
    $yer = $resim['tmp_name'];
    $boyut = $resim['size'];
    $max_boyut = 10000000;

    // Boyut kontrolü
    if ($boyut > $max_boyut) {
        return array("hata", "Dosya boyutu çok büyük. Maksimum boyut: " . ($max_boyut / 1024 / 1024) . " MB.");
    }

    // Dosya uzantısı kontrolü
    $uzanti = strtolower(pathinfo($resim["name"], PATHINFO_EXTENSION));
    $izinverilen = array("jpg", "jpeg", "png");
    if (!in_array($uzanti, $izinverilen)) {
        return array("hata", "Fotoğraf türü tanınamadı. Geçerli türler: " . implode(", ", $izinverilen));
    }

    // Hedef dosya adı oluşturma
    $isim = $prefix . "_" . time();
    $yeniad = $isim . "." . $uzanti;
    $hedef = $dhedef . '/' . $yeniad;

    // Dosya taşıma işlemi
    if (move_uploaded_file($yer, $hedef)) {
        return array("tamam", $yeniad);
    } else {
        return array("hata", "Dosya taşınamadı. Hedef yol: " . $hedef);
    }
}

	if(isset($_POST['eekle']))
	{
		$isim=$_POST['eisim'];
		$bilgi=$_POST['ebilgi'];
		$acklm=$_POST['eaciklama'];
		if($isim<>"" and $bilgi<>"" and $acklm<>"")
		{
			if(isset($_FILES["eresim"]["name"]))
			{	
				$file = $_FILES['eresim'];
				$resimy = resimyukle($_FILES["eresim"],"resim","images");
				if($resimy[0]=="tamam")
				{
					$veriler["resim"] = $resimy[1];
					$grsl=$resimy[1];
					$sql="insert into etkinlikler(isim,bilgi,aciklama,gorsel,b_durum,y_durum,p_durum) 
					values('$isim','$bilgi','$acklm','$grsl','0','1','0')";
					$sonuc = mysqli_query($baglanti,$sql);
					if($sonuc)
					{
						$tur='success';
						$message='Etkinlik Başarıyla Eklendi...';
					}
					else
					{
						$tur='danger';
						$message='Etkinlik Eklenemedi...';
					}
				}	
			}
		}
		else
		{
			$message="Lütfen Etkinlik Bilgilerini Tam Girin";
		}
		ob_end_flush();
	}
	if(isset($_POST['pekle']))
	{
		$id=$_POST['pid'];
		$bilgi=$_POST['pbilgi'];
		$acklm=$_POST['paciklama'];
		if($id<>0 and $bilgi<>"" and $acklm<>"")
		{
			if(isset($_FILES["presim"]["name"]))
			{	
				$file = $_FILES['presim'];
				$resimy = resimyukle($_FILES["presim"],"resim","images");
				if($resimy[0]=="tamam")
				{
					$veriler["resim"] = $resimy[1];
					$grsl=$resimy[1];
					$sql1="update etkinlikler set bilgi='$bilgi',aciklama='$acklm',gorsel='$grsl',p_durum=1 where id='$id'";
					$sonuc1 = mysqli_query($baglanti,$sql1);
					if($sonuc1)
					{
						$tur='success';
						$message='Etkinlik Başarıyla Güncellendi...';
					}
					else
					{
						$tur='danger';
						$message='Etkinlik Güncellenemedi...';
					}
				}	
			}
		}
		else
		{
			$message="Lütfen Etkinlik Bilgilerini Tam Girin";
		}
		ob_end_flush();
	}
	if(isset($_POST['basvuru']))
	{
		$id=$_POST["eid"];
			$sql="select id,isim,b_durum from etkinlikler where id='$id'";
			$result=mysqli_query($baglanti,$sql);
			$row=mysqli_fetch_all($result);
			$eisim=$row[0][1];
			if($result)
			{
				$durum=$row[0][2];
				if($durum==0)
				{
					$sql2="update etkinlikler set b_durum=1 where id='$id'";
					$results=mysqli_query($baglanti,$sql2);
					if($results)
					{
						$tur='success';
							$message='Başvuru Kapatıldı';
					}
				}
				else
				{
					$sql2="update etkinlikler set b_durum=0 where id='$id'";
					$results=mysqli_query($baglanti,$sql2);
					if($results)
					{
						$tur='success';
						$message="Başvuru Açıldı";
					}
				}
			}
			else
			{
				$message="Başvuru İşlemi Başarısız";
			}
			ob_end_flush();
	}
	if(isset($_POST['yoklama']))
	{
		$id=$_POST["eid"];
			$sql="select id,isim,y_durum from etkinlikler where id='$id'";
			$result=mysqli_query($baglanti,$sql);
			$row=mysqli_fetch_all($result);
			$eisim=$row[0][1];
			if($result)
			{
				$durum=$row[0][2];
				if($durum==0)
				{
					$sql1="update etkinlikler set y_durum=1 where id='$id'";
					$result1=mysqli_query($baglanti,$sql1);
					if($result1)
					{
							$message='Yoklama Kapatıldı';
							$tur="success";
					}
				}
				else
				{
					$sql2="update etkinlikler set y_durum=0 where id='$id'";
					$results=mysqli_query($baglanti,$sql2);
					if($results)
					{
						$tur="success";
						$message='Yoklama Açıldı';
					}
				}
			}
			else
			{
				$message="Yoklama İşlemi Başarısız";
			}
			ob_end_flush();
	}
	if(isset($_POST['kekle']))
	{
		$no=$_POST["ogrno"];
			$sql="select id from uyeler where numara=$no";
			$result=mysqli_query($baglanti,$sql);
			$row=mysqli_fetch_all($result);
			if($row)
		    {   
		        $id=$row[0][0];
		        $sql2="select * from indirim where uye_id=$id";
		        $result2=mysqli_query($baglanti,$sql2);
		        $row2=mysqli_fetch_all($result2);
    			if(!$row2)
    			{
    				$file = $_FILES['foto'];
    				$resimy = resimyukle($_FILES["foto"],"resim","images");
    				if($resimy[0]=="tamam")
    				{
    					$veriler["resim"] = $resimy[1];
    					$grsl=$resimy[1];
    					$sql="insert into indirim(uye_id,gorsel) 
    					values('$id','$grsl')";
    					$sonuc = mysqli_query($baglanti,$sql);
    					if($sonuc)
    					{
    						$tur='success';
    						$message='İndirim Başarıyla Eklendi...';
    					}
    					else
    					{
    						$tur='danger';
    						$message='İndirim Eklenemedi...';
    					}
    				}
    				else
    				{
    				    $tur='danger';
    				    $message='İndirim Eklenemedi...';
    				}
    			}
    			else
    			{
    			    $tur='danger';
    				$message="Zaten Bir İndirim Mevcut";
    			}
		    }
		    else
		    {
		        $tur="danger";
		        $message="Lütfen Kayıt Olunuz";
		    }
		        ob_end_flush();
    }
    if(isset($_POST['sekle']))
	{
		$tur=$_POST['spturu'];
		$ad=$_POST['sadi'];
		$acklm=$_POST['sack'];
		$link=$_POST['slink'];
		if($ad<>"" and $link<>"" and $acklm<>"")
		{
			if(isset($_FILES["sresim"]["name"]))
			{	
				$file = $_FILES['sresim'];
				$resimy = resimyukle($_FILES["sresim"],"resim","images");
				if($resimy[0]=="tamam")
				{
					$veriler["resim"] = $resimy[1];
					$grsl=$resimy[1];
					$sql="insert into sponsor(isim,link,aciklama,gorsel,tur) 
					values('$ad','$link','$acklm','$grsl','$tur')";
					$sonuc = mysqli_query($baglanti,$sql);
					if($sonuc)
					{
						$tur='success';
						$message='Sponsor Başarıyla Eklendi';
					}
					else
					{
						$tur='danger';
						$message='Sponsor Eklenemedi...';
					}
				}	
			}
		}
		else
		{
			$message="Lütfen Sponsorluk Bilgilerini Tam Girin";
		}
		ob_end_flush();
	}
?>
<html lang="tr">
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
<style>
        .form-section {
            display: none; /* Başlangıçta tüm bölümler gizli */
            margin-top: 1em;
        }
        .label-note {
            display: block;
            font-size: 1.5em; /* Açıklama yazısının büyüklüğünü artırır */
            text-align: center; /* Metni ortalar */
            color: #666;
            margin: 0.5em 0;
        }
        #applications-table {
            border: 2px solid #333; /* Tabloya kenarlık ekler */
            border-collapse: collapse; /* Kenarlıkların birleşmesini sağlar */
            font-size: 1.2em; /* Yazı punto büyüklüğünü artırır */
            margin: 0 auto; /* Tabloyu ortalar */
            width: 90%; /* Tablo genişliğini ayarlayabilirsiniz */
        }

        #applications-table th, #applications-table td {
            border: 1px solid #ddd; /* Hücrelere kenarlık ekler */
            padding: 0.5em; /* Hücre içi boşluk */
            text-align: center; /* Metin hizalamasını merkezler */
        }

        #applications-table th {
            background-color: #f4f4f4; /* Başlık hücrelerine arka plan rengi ekler */
        }
    </style>
<body>
   <header class="header">
        <a href="index" class="logo">
         
          <img src="images/bilisimlogo.png" alt="logo" />
        </a>
        <nav class="navbar">
          <a href="index">Ana Sayfa</a>
          <a href="etkinlikler">Etkinlikler</a>
          <a href="sponsorlar">Sponsorlar</a>
          <a href="uyeislemleri">Üye İşlemleri</a>
        </nav>
      </header>
	  <?php
		if($message)
		{
			echo"<div class='alert alert-$tur' role='alert'>
				$message
			</div>";
		}
	?>
	<section class="member-registration">
        <h1 onclick="toggleSection('member-registration-form')">Etkinlik Ekle</h1>
        <span class="label-note">(Yeni Bir Etkinlik Ekle)</span>
        <div class="form-section" id="member-registration-form">
            <!-- Form içeriği buraya gelecek -->
            <form method="post" enctype='multipart/form-data'>
                <div class="inputBox">
                    <label for="fullName">Etkinlik Başlık</label>
                    <input type="text" id="fullName" name="eisim" placeholder="Etkinlik Adı" required />
                </div>
                <div class="inputBox">
                    <label for="studentId">Etkinlik Kısa Bilgi </label>
                    <input type="text" id="studentId" name="ebilgi" placeholder="Etkinlik Kısa Bilgi" required />
                </div>
                <div class="inputBox">
                    <label for="department">Açıklama</label>
                    <textarea name='eaciklama' placeholder='Açıklama' required></textarea>
                </div>
                <div class="inputBox">
                    <label for="eventImage">Etkinlik Resmi</label>
                    <input type="file" id="eventImage" name="eresim"/>
                </div>
                <input type="submit" class="btn" name='eekle' value="Etkinlik Ekle" />
            </form>
        </div>
    </section>
    
    <section class="event-application">
        <h1 onclick="toggleSection('event-application-open-close-form')">Başvuru Aç / Kapat</h1>
        <span class="label-note">(Etkinlik Başvurularını Açmak İçin)</span>
        <div class="form-section" id="event-application-open-close-form">
            <!-- Form içeriği buraya gelecek -->
            <form method="post">
                <div class="inputBox">
                    <label for="events">Etkinlikler</label>
                    <?php
									$sqletkinlik="select * from etkinlikler order by id desc";
									$result=mysqli_query($baglanti,$sqletkinlik);
									$row=mysqli_fetch_all($result);
									echo"<select name='eid' id='eid'>";
									echo"<option value=0>Lütfen Etkinlik Seçin</option>";
									for($i=0;$i<count($row);$i++)
									{
										$etkinlik=$row[$i][1];
										$etkinlikid=$row[$i][0];
										echo"<option value=$etkinlikid>";echo $etkinlik."</option>";
									}
								?>
                </div>
                <input type="submit" class="btn" name="basvuru"value="Başvuru Aç/Kapat" />
            </form>
        </div>
    </section>

    <section class="event-application">
        <h1 onclick="toggleSection('event-attendance-open-close-form')">Yoklama Aç / Kapat</h1>
        <span class="label-note">(Etkinlik Yoklamasını Açmak İçin)</span>
        <div class="form-section" id="event-attendance-open-close-form">
            <!-- Form içeriği buraya gelecek -->
            <form method="post">
                <div class="inputBox">
                    <label for="events">Etkinlikler</label>
                    <?php
									$sqletkinlik="select * from etkinlikler where b_durum=1 order by id desc";
									$result=mysqli_query($baglanti,$sqletkinlik);
									$row=mysqli_fetch_all($result);
									echo"<select name='eid' id='eid'>";
									echo"<option value=0>Lütfen Etkinlik Seçin</option>";
									for($i=0;$i<count($row);$i++)
									{
										$etkinlik=$row[$i][1];
										$etkinlikid=$row[$i][0];
										echo"<option value=$etkinlikid>";echo $etkinlik."</option>";
									}
								?>
                </div>
                <input type="submit" class="btn" name='yoklama'value="Yoklama Aç/Kapat" />
            </form>
        </div>
    </section>
    
    <section class="management-application">
        <h1 onclick="toggleSection('management-application-form')">Etkinlik Paylaş</h1>
        <span class="label-note">(Etkinliği Paylaşmak İçin)</span>
        <div class="form-section" id="management-application-form">
            <!-- Form içeriği buraya gelecek -->
            <form method="post" enctype='multipart/form-data'>
                <div class="inputBox">
                    <label for="events">Etkinlik Seç</label>
                    <select id="events" name="pid">
						<option value="0">Lütfen Etkinlik Seçin</option>
						<?php
							$sql="select * from etkinlikler 
							where p_durum=0 and b_durum=1 and y_durum=1";
							$result=mysqli_query($baglanti,$sql);
							$row=mysqli_fetch_all($result);
							for($i=0;$i<count($row);$i++)
							{
								$id=$row[$i][0];
								$isim=$row[$i][1];
							echo"<option value='$id'>$isim</option>";
							}
						?>
                    </select>
                </div>
                <div class="inputBox">
                    <label for="studentId">Etkinlik Kısa Bilgi </label>
                    <input type="text" id="studentId" name="pbilgi" placeholder="Etkinlik Kısa Bilgi" required />
                </div>
                <div class="inputBox">
                    <label for="department">Açıklama</label>
                    <textarea name='paciklama' placeholder='Açıklama' required></textarea>
                </div>
                <div class="inputBox">
                    <label for="eventImage">Etkinlik Resmi</label>
                    <input type="file" id="eventImage" name="presim"/>
                </div>
                <input type="submit" class="btn" name='pekle' value="Etkinlik Ekle" />
            </form>
        </div>
    </section>
    <section class="event-application">
        <h1 onclick="toggleSection('application-list-form')">Başvuru Listele</h1>
        <span class="label-note">(Etkinlik Başvurularını Görüntülemek İçin)</span>
        <div class="form-section" id="application-list-form">
                    <?php
            if (isset($_POST['bgor'])) {
                $eid = $_POST["eid"]; // Seçilen etkinlik ID'si
        
                if ($eid == 0) {
                    echo "<p>Lütfen bir etkinlik seçin.</p>";
                } else {
                    $sql = "SELECT 
                        uyeler.isim,
                        uyeler.numara,
                        uyeler.telefon,
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
                        END AS katilim
                    FROM 
                        uyeler 
                    LEFT JOIN 
                        etkinlik_kayit ON uyeler.id = etkinlik_kayit.uye_id
                    LEFT JOIN 
                        indirim ON uyeler.id = indirim.uye_id
                    INNER JOIN 
                        basvuru ON uyeler.id = basvuru.uye_id AND basvuru.etkinlik_id = '$eid'
                    GROUP BY 
                        uyeler.id 
                    ORDER BY 
                        katilim DESC, uyeler.bolum, basvuru.id ASC;";
                    $result = mysqli_query($baglanti, $sql);
                    if (!$result) {
                        die('Sorgu Hatası: ' . mysqli_error($baglanti));
                    }
                    if (mysqli_num_rows($result) > 0) {
                        // Tabloyu doldur
                        echo '<div id="applications-table-section" style="display:block; margin-top: 1em;">';
                        echo '<table border="1" id="applications-table">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>Sıra</th>';
                        echo '<th>Öğrenci Numarası</th>';
                        echo '<th>İsim</th>';
                        echo '<th>Telefon Numarası</th>';
                        echo '<th>Puan</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
        
                        $sira = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . $sira . '</td>';
                            echo '<td>' . $row['numara'] . '</td>';
                            echo '<td>' . $row['isim'] . '</td>';
                            echo '<td>' . $row['telefon'] . '</td>';
                            echo '<td>' . $row['katilim'] . '</td>';
                            echo '</tr>';
                            $sira++;
                        }
        
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                    } else {
                        // Eğer başvuru bulunmazsa
                        echo "<p>Bu etkinlik için başvuru bulunmamaktadır.</p>";
                    }
                }
            }
        ?>

            <form method="post">
                <div class="inputBox">
                    <label for="events">Etkinlik Seç</label>
                    <select name="eid">
                        <option value="0">Lütfen Etkinlik Seçin</option>
                        <?php
                        // Etkinlik listesini veritabanından çekmek için SQL sorgusu
                        $sqletkinlik = "SELECT * FROM etkinlikler ORDER BY id DESC";
                        $result = mysqli_query($baglanti, $sqletkinlik);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $etkinlikid = $row['id'];
                            $etkinlik = $row['isim'];
                            echo "<option value='$etkinlikid'>$etkinlik</option>";
                        }
                        ?>
                    </select>
                </div>
                <input type="submit" class="btn" name="bgor" value="Başvuruları Listele" />
            </form>
        </div>
    </section>
    
   <!-- İndirim Sistemi Kullanıcısı Ekle -->
   <section class="member-registration">
      <h1 onclick="toggleSection('discount-system-add-user')">İndirim Sistemi Kullanıcısı Ekle</h1>
      <span class="label-note">(Yeni Bir İndirim Sistemi Kullanıcısı Ekle)</span>
      <div class="form-section" id="discount-system-add-user">
         <form method="post" enctype='multipart/form-data'>
            <div class="inputBox">
               <label for="studentNumber">Kullanıcı Öğrenci Numarası</label>
               <input type="text" id="studentNumber" name="ogrno" placeholder="Öğrenci Numarası" required />
            </div>
            <div class="inputBox">
               <label for="userPhoto">Kullanıcı Fotoğrafı</label>
               <input type="file" id="userPhoto" name="foto"/>
            </div>
            <input type="submit" class="btn" name="kekle" value="Kullanıcı Ekle" />
         </form>
      </div>
   </section>

   <!-- İndirim Sistemi Kullanıcılarını Listele -->
   <section class="member-registration">
      <h1 onclick="toggleSection('discount-system-list-users')">İndirim Sistemi Kullanıcılarını Listele</h1>
      <span class="label-note">(Mevcut Kullanıcıları Listele)</span>
      <div class="form-section" id="discount-system-list-users">
         <div id="userList">
             <table>
            <?php
               $sql="select isim,gorsel from indirim as i
               inner join uyeler as u on u.id=i.uye_id";
               $result=mysqli_query($baglanti,$sql);
               $row=mysqli_fetch_all($result);
               for($i=0;$i<count($row);$i++)
               {
                   $isim=$row[$i][0];
                    echo '<tr>';
                    echo '<td>' . $isim . '</td>';
                    echo '</tr>';
               }
            ?>
            </table>
         </div>
      </div>
   </section>

        <!-- Sponsor Ekle -->
    <section class="sponsor-registration">
        <h1 onclick="toggleSection('sponsor-registration-form')">Sponsor Ekle</h1>
        <span class="label-note">(Yeni Bir Sponsor Ekle)</span>
        <div class="form-section" id="sponsor-registration-form">
            <form method="post" enctype="multipart/form-data">
                <div class="inputBox">
                    <label for="sponsorType">Sponsor Türü</label>
                    <select id="sponsorType" name="spturu" required>
                        <option value="0">Ana Sponsor</option>
                        <option value="1">Etkinlik Sponsoru</option>
                        <option value="2">İndirim Sistemi Sponsoru</option>
                    </select>
                </div>
                <div class="inputBox">
                    <label for="sponsorName">Sponsor Adı</label>
                    <input type="text" id="sponsorName" name="sadi" placeholder="Sponsor Adı" required />
                </div>
                <div class="inputBox">
                    <label for="shortInfo">Sponsor Link</label>
                    <input type="text" id="shortInfo" name="slink" placeholder="Sponsor Linki" required />
                </div>
                <div class="inputBox">
                    <label for="description">Sponsor Açıklama</label>
                    <textarea id="description" name="sack" placeholder="Açıklama" required></textarea>
                </div>
                <div class="inputBox">
                    <label for="sponsorLogo">Sponsor Logo</label>
                    <input type="file" id="sponsorLogo" name="sresim" />
                </div>
                <input type="submit" class="btn" name="sekle" value="Sponsor Ekle" />
            </form>
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

    <script>
        function toggleSection(id) {
            const sections = document.querySelectorAll('.form-section');
            sections.forEach(section => {
                if (section.id === id) {
                    section.style.display = section.style.display === 'none' ? 'block' : 'none';
                } else {
                    section.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
