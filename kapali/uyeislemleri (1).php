<?php
include("baglan.php");
$alert = null;
$tur = "success";

// Üye kaydı işlemi
if(isset($_POST["kayit"])) {
    $isim = mysqli_real_escape_string($baglanti, $_POST["isim"]);
    $numara = mysqli_real_escape_string($baglanti, $_POST["numara"]);
    $bolum = mysqli_real_escape_string($baglanti, $_POST["bolum"]);
    $tel = mysqli_real_escape_string($baglanti, $_POST["tel"]);
    $mail = mysqli_real_escape_string($baglanti, $_POST["mail"]);
    $adres = mysqli_real_escape_string($baglanti, $_POST["adres"]);
    $sinif = mysqli_real_escape_string($baglanti, $_POST["sinif"]);
    $ref = mysqli_real_escape_string($baglanti, $_POST["ref"]);

    if($bolum == "other") {
        $bolum = mysqli_real_escape_string($baglanti, $_POST["bolum_other"]);
    }

    $sql = "INSERT INTO uyeler(isim, numara, bolum, sinif, telefon, mail, adres, referans) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($baglanti, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssss", $isim, $numara, $bolum, $sinif, $tel, $mail, $adres, $ref);
    
    if(mysqli_stmt_execute($stmt)) {
        $alert = "Başarıyla Kayıt Olundu";
    } else {
        $alert = "Kayıt Yapılırken Hata Oluştu";
        $tur = "danger";
    }
    mysqli_stmt_close($stmt);
}

// Yönetim kurulu başvurusu işlemi
if(isset($_POST['yonetim'])) {
    $no = mysqli_real_escape_string($baglanti, $_POST['ogrno']);
    $platform = isset($_POST['canva']) ? 1 : 0;
    $video = isset($_POST['video']) ? 1 : 0;
    $foto = isset($_POST['foto']) ? 1 : 0;
    $icerik = isset($_POST['icerik']) ? 1 : 0;
    $grafik = isset($_POST['grafik']) ? 1 : 0;
    $konf = isset($_POST['konferans']) ? 1 : 0;
    $arka = isset($_POST['arka']) ? 1 : 0;
    $sponsor = isset($_POST['sponsor']) ? 1 : 0;
    $gorusme = isset($_POST['gorusme']) ? 1 : 0;
    $evrak = isset($_POST['evrak']) ? 1 : 0;
    $teslim = isset($_POST['teslim']) ? 1 : 0;
    $niyet = mysqli_real_escape_string($baglanti, $_POST['niyet']);

    $sql = "SELECT id FROM uyeler WHERE numara = ?";
    $stmt = mysqli_prepare($baglanti, $sql);
    mysqli_stmt_bind_param($stmt, "s", $no);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];
        
        $sqlk = "SELECT * FROM ybasvuru WHERE uye_id = ?";
        $stmtk = mysqli_prepare($baglanti, $sqlk);
        mysqli_stmt_bind_param($stmtk, "i", $id);
        mysqli_stmt_execute($stmtk);
        $resultk = mysqli_stmt_get_result($stmtk);
        
        if(mysqli_num_rows($resultk) == 0) {
            $sqle = "INSERT INTO ybasvuru(uye_id, platform, video, foto, icerik, grafik, konferans, arka, sponsor, gorusme, evrak, teslim, niyet) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmte = mysqli_prepare($baglanti, $sqle);
            mysqli_stmt_bind_param($stmte, "iiiiiiiiiiiss", $id, $platform, $video, $foto, $icerik, $grafik, $konf, $arka, $sponsor, $gorusme, $evrak, $teslim, $niyet);
            
            if(mysqli_stmt_execute($stmte)) {
                $alert = "Yönetim Kurulu Başvurunuz Alındı";
            } else {
                $alert = "Başvururken Hata Oluştu";
                $tur = "danger";
            }
            mysqli_stmt_close($stmte);
        } else {
            $alert = "Zaten Bir Başvurunuz Bulunmakta";
            $tur = "danger";
        }
        mysqli_stmt_close($stmtk);
    } else {
        $alert = "Lütfen Topluluğumuza Üye Olunuz";
        $tur = "danger";
    }
    mysqli_stmt_close($stmt);
}

// Etkinlik başvurusu işlemi
if(isset($_POST["etkinlik"])) {
    $eid = mysqli_real_escape_string($baglanti, $_POST["eid"]);
    $no = mysqli_real_escape_string($baglanti, $_POST["sono"]);
    
    if($eid == 0 || $no == "") {
        $tur = "danger";
        $alert = "Lütfen Bilgileri Eksiksiz Girin";
    } else {
        $sql = "SELECT id FROM uyeler WHERE numara = ?";
        $stmt = mysqli_prepare($baglanti, $sql);
        mysqli_stmt_bind_param($stmt, "s", $no);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];
            
            $sqlk = "SELECT * FROM basvuru WHERE uye_id = ? AND etkinlik_id = ?";
            $stmtk = mysqli_prepare($baglanti, $sqlk);
            mysqli_stmt_bind_param($stmtk, "ii", $id, $eid);
            mysqli_stmt_execute($stmtk);
            $resultk = mysqli_stmt_get_result($stmtk);
            
            if(mysqli_num_rows($resultk) == 0) {
                $sqle = "INSERT INTO basvuru(uye_id, etkinlik_id) VALUES (?, ?)";
                $stmte = mysqli_prepare($baglanti, $sqle);
                mysqli_stmt_bind_param($stmte, "ii", $id, $eid);
                
                if(mysqli_stmt_execute($stmte)) {
                    $alert = "Başvuru Alındı";
                } else {
                    $tur = "danger";
                    $alert = "Lütfen Daha Sonra Tekrar Deneyin";
                }
                mysqli_stmt_close($stmte);
            } else {
                $tur = "danger";
                $alert = "Zaten Bir Başvurunuz Bulunmakta";
            }
            mysqli_stmt_close($stmtk);
        } else {
            $tur = "danger";
            $alert = "Lütfen Üye Olunuz";
        }
        mysqli_stmt_close($stmt);
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
    <title>Üye İşlemleri</title>
    <style>
        .label-note {
            display: block;
            font-size: 0.9em;
            text-align: center;
            color: #666;
            margin: 0.5em 0;
        }
        .additional-section {
            margin-top: 2em;
        }
        .additional-section .description {
            display: block;
            font-size: 0.9em;
            text-align: center;
            color: #666;
            margin-bottom: 1em;
        }
        .additional-section .inputBox {
            text-align: center;
        }
        .additional-section .btn {
            display: inline-block;
            margin-top: 1em;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary header">
  <div class="container-fluid">
    <a class="navbar-brand logo" href="#">
      <img src="images/bilisimlogo.png" alt="logo" />
    </a>
    <div class="collapse navbar-collapse navbar" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index">Ana Sayfa</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="etkinlikler">Etkinlikler</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="sponsorlar">Sponsorlar</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="uyeislemleri">Üye İşlemleri</a>
        </li>
      </ul>
      <div class="buttons">
        <!--navbarın kenarındaki iconlar için-->
      </div>
    </div>
  </div>
</nav>
	<?php
		if($alert)
		{
			echo"<div class='alert alert-$tur' role='alert'>
				$alert
			</div>";
		}
	?>
    <section class="member-registration">
        <h1 onclick="toggleSection('member-registration-form')">Yeni Üye Kayıt</h1>
        <span class="label-note">(Topluluğumuza üye olmak için)</span>
        <div class="form-section" id="member-registration-form">
            <form method="post">
                <div class="inputBox">
                    <label for="fullName">İsim Soyisim</label>
                    <input type="text" id="fullName" name="isim" placeholder="İsim Soyisim" required >
                </div>
                <div class="inputBox">
                    <label for="studentId">Öğrenci Numarası</label>
                    <input type="number" id="studentId" name="numara" placeholder="Öğrenci Numarası" required />
                </div>
				<?php
					$sql = "SELECT bolum FROM uyeler GROUP BY bolum";
					$result = mysqli_query($baglanti, $sql);
					$row = mysqli_fetch_all($result);

					echo "<div class='inputBox'>
							<label for='department'>Bölüm</label>
							<select name='bolum' id='department' onchange='toggleOtherDepartment()'>
								<option value=''>Seçiniz</option>";

					for ($i = 0; $i < count($row); $i++) {
						$bolum = $row[$i][0];
						echo "<option value='$bolum'>$bolum</option>";
					}

					echo "<option value='other'>Diğer</option>";
					echo "</select>
						  <input type='text' name='bolum_other' id='bolum_other' placeholder='Bölümünüzü giriniz' style='display:none; margin-top:10px;' required />
						</div>";
					?>
					<div class='inputBox'>
						<label for='class'>Sınıf</label>
						<select name='sinif' id='class'>
							<option value=''>Seçiniz</option>
							<option value='0'>Hazırlık</option>
							<option value='1'>1</option>
							<option value='2'>2</option>
							<option value='3'>3</option>
							<option value='4'>4</option>
						</select>
					</div>
                <div class="inputBox">
                    <label for="phoneNumber">Telefon Numarası</label>
                    <input type="tel" id="phoneNumber" name="tel" placeholder="Telefon Numarası" pattern="[0]{1}[5]{1}[0-9]{2}[0-9]{3}[0-9]{4}" required />
                </div>
                <div class="inputBox">
                    <label for="email">Mail Adresi</label>
                    <input type="email" id="email" name="mail" placeholder="Mail Adresi" required />
                </div>
                <div class="inputBox">
                    <label for="address">Adres</label>
                    <input type="text" id="address" name="adres" placeholder="Adres" required />
                </div>
                <div class="inputBox">
                    <label for="refStudentId">Referans Öğrenci Numarası</label>
                    <input type="number" id="refStudentId" name="ref" placeholder="İsteğe Bağlı" />
                </div>
                <input type="submit" class="btn" value="Kayıt Ol" name='kayit'/>
            </form>
        </div>
    </section>

    <section class="management-application">
        <h1 onclick="toggleSection('management-application-form')">Yönetim Kuruluna Başvur</h1>
        <span class="label-note">(Yönetim kurulumuzuza başvurmak için)</span>
        <div class="form-section" id="management-application-form">
            <form method="post">
                <div class="inputBox">
                    <label for="applicationStudentId">Öğrenci Numarası</label>
                    <input type="number" id="applicationStudentId" name="ogrno" placeholder="Öğrenci Numarası"
                        required />
                </div>

                <!-- Departman Seçimi -->
                <div class="inputBox">
                    <label for="departments">Başvurmak İstediğiniz Departmanlar</label>

                    <!-- Sosyal Medya checkbox (disabled by default) -->
                    <div style="display: flex; align-items: center; margin-bottom: 0.5em;">
                        <input type="checkbox" id="socialMedia" name="departman[]" value="Sosyal Medya"
                            style="width: 1.2em; height: 1.2em; margin-right: 0.5em;" disabled>
                        <label for="socialMedia" style="font-weight: 400; font-size: 1.5rem;">Sosyal Medya</label>
                    </div>

                    <!-- Additional checkboxes (indented) -->
                    <div style="display: flex; align-items: center; margin-bottom: 0.5em; margin-left: 2em;">
                        <input type="checkbox" id="canvaCheckbox" name="canva" value="Canva"
                            style="width: 1.2em; height: 1.2em; margin-right: 0.5em;" onclick="checkSocialMedia()">
                        <label for="canvaCheckbox" style="font-weight: 400; font-size: 1.2rem;">Canva, PS vb. tasarım
                            platformlarını kullanabiliyorum</label>
                    </div>

                    <div style="display: flex; align-items: center; margin-bottom: 0.5em; margin-left: 2em;">
                        <input type="checkbox" id="videoEditCheckbox" name="video" value="Video Editi"
                            style="width: 1.2em; height: 1.2em; margin-right: 0.5em;" onclick="checkSocialMedia()">
                        <label for="videoEditCheckbox" style="font-weight: 400; font-size: 1.2rem;">Video editi
                            yapabilirim</label>
                    </div>

                    <div style="display: flex; align-items: center; margin-bottom: 0.5em; margin-left: 2em;">
                        <input type="checkbox" id="photoVideoCheckbox" name="foto"
                            value="Fotoğraf/Video Çekimi" style="width: 1.2em; height: 1.2em; margin-right: 0.5em;"
                            onclick="checkSocialMedia()">
                        <label for="photoVideoCheckbox" style="font-weight: 400; font-size: 1.2rem;">Fotoğraf/video
                            çekebilirim</label>
                    </div>

                    <div style="display: flex; align-items: center; margin-bottom: 0.5em; margin-left: 2em;">
                        <input type="checkbox" id="contentCreationCheckbox" name="icerik" value="İçerik Üretimi"
                            style="width: 1.2em; height: 1.2em; margin-right: 0.5em;" onclick="checkSocialMedia()">
                        <label for="contentCreationCheckbox" style="font-weight: 400; font-size: 1.2rem;">İçerik
                            üretebilirim</label>
                    </div>

                    <div style="display: flex; align-items: center; margin-bottom: 0.5em; margin-left: 2em;">
                        <input type="checkbox" id="graphicDesignCheckbox" name="grafik" value="Grafik Tasarımı"
                            style="width: 1.2em; height: 1.2em; margin-right: 0.5em;" onclick="checkSocialMedia()">
                        <label for="graphicDesignCheckbox" style="font-weight: 400; font-size: 1.2rem;">Grafik tasarımı
                            yapabilirim</label>
                    </div>


                    <script>
                    function checkSocialMedia() {
                        var checkboxes = [
                            document.getElementById("canvaCheckbox"),
                            document.getElementById("videoEditCheckbox"),
                            document.getElementById("photoVideoCheckbox"),
                            document.getElementById("contentCreationCheckbox"),
                            document.getElementById("graphicDesignCheckbox")
                        ];

                        var socialMediaCheckbox = document.getElementById("socialMedia");

                        // Eğer alt checkboxlardan biri işaretlenirse "Organizasyon ve Sponsorluk" otomatik olarak işaretlensin
                        var anyChecked = checkboxes.some(function(checkbox) {
                            return checkbox.checked;
                        });

                        // "Organizasyon ve Sponsorluk" checkbox'ını sadece alt checkboxlar işaretlenince kontrol ederiz
                        if (anyChecked) {
                            socialMediaCheckbox.checked = true;
                        } else {
                            socialMediaCheckbox.checked = false;
                        }
                    }
                    </script>
                

                    <!-- Organization checkbox (disabled by default) -->
                    <div style="display: flex; align-items: center; margin-bottom: 0.5em;">
                        <input type="checkbox" id="organization" name="departman[]" value="Organizasyon ve Sponsorluk"
                            style="width: 1.2em; height: 1.2em; margin-right: 0.5em;" disabled>
                        <label for="organization" style="font-weight: 400; font-size: 1.5rem;">Organizasyon</label>
                    </div>

                    <!-- Additional checkboxes (indented) -->
                    <div style="display: flex; align-items: center; margin-bottom: 0.5em; margin-left: 2em;">
                        <input type="checkbox" id="konferansCheckbox" name="konferans" value="konferans"
                            style="width: 1.2em; height: 1.2em; margin-right: 0.5em;" onclick="checkOrganization()">
                        <label for="konferansCheckbox" style="font-weight: 400; font-size: 1.2rem;">Konferans
                            sunabilirim.</label>
                    </div>

                    <div style="display: flex; align-items: center; margin-bottom: 0.5em; margin-left: 2em;">
                        <input type="checkbox" id="sahneArkasiCheckbox" name="arka" value="Sahne Arkasi"
                            style="width: 1.2em; height: 1.2em; margin-right: 0.5em;" onclick="checkOrganization()">
                        <label for="sahneArkasiCheckbox" style="font-weight: 400; font-size: 1.2rem;">Etkinliklerde
                            sahne arkası işlerde çalışabilirim.</label>
                    </div>

                    <div style="display: flex; align-items: center; margin-bottom: 0.5em; margin-left: 2em;">
                        <input type="checkbox" id="sponsorCheckbox" name="sponsor" value="Sponsor"
                            style="width: 1.2em; height: 1.2em; margin-right: 0.5em;" onclick="checkOrganization()">
                        <label for="sponsorCheckbox" style="font-weight: 400; font-size: 1.2rem;">Topluluğa gönüllü
                            temini ve finansal kaynak aramak için çalışırım.</label>
                    </div>

                    <div style="display: flex; align-items: center; margin-bottom: 0.5em; margin-left: 2em;">
                        <input type="checkbox" id="gorusmeCheckbox" name="gorusme" value="Görüşmeler"
                            style="width: 1.2em; height: 1.2em; margin-right: 0.5em;" onclick="checkOrganization()">
                        <label for="gorusmeCheckbox" style="font-weight: 400; font-size: 1.2rem;">Etkinlik hazırlığında
                            gerekli görüşmelere katılırım.</label>
                    </div>

                    <script>
                    function checkOrganization() {
                        var checkboxes = [
                            document.getElementById("konferansCheckbox"),
                            document.getElementById("sahneArkasiCheckbox"),
                            document.getElementById("sponsorCheckbox"),
                            document.getElementById("gorusmeCheckbox"),
                        ];

                        var organizationCheckbox = document.getElementById("organization");

                        // Eğer alt checkboxlardan biri işaretlenirse "Organizasyon ve Sponsorluk" otomatik olarak işaretlensin
                        var anyChecked = checkboxes.some(function(checkbox) {
                            return checkbox.checked;
                        });

                        // "Organizasyon ve Sponsorluk" checkbox'ını sadece alt checkboxlar işaretlenince kontrol ederiz
                        if (anyChecked) {
                            organizationCheckbox.checked = true;
                        } else {
                            organizationCheckbox.checked = false;
                        }
                    }
                    </script>

                    <!-- raporlaming checkbox (disabled by default) -->
                    <div style="display: flex; align-items: center; margin-bottom: 0.5em;">
                        <input type="checkbox" id="raporlama" name="departman[]" value="Raporlama"
                            style="width: 1.2em; height: 1.2em; margin-right: 0.5em;" disabled>
                        <label for="raporlama" style="font-weight: 400; font-size: 1.5rem;">Raporlama</label>
                    </div>

                    <!-- Additional checkboxes (indented) -->
                    <div style="display: flex; align-items: center; margin-bottom: 0.5em; margin-left: 2em;">
                        <input type="checkbox" id="evrakHazirlamaCheckbox" name="evrak" value="evrak"
                            style="width: 1.2em; height: 1.2em; margin-right: 0.5em;" onclick="checkRaporlama()">
                        <label for="evrakHazirlamaCheckbox" style="font-weight: 400; font-size: 1.2rem;">Belge/evrak
                            hazırlayabilirim.</label>
                    </div>

                    <div style="display: flex; align-items: center; margin-bottom: 0.5em; margin-left: 2em;">
                        <input type="checkbox" id="teslimCheckbox" name="teslim" value="Evrak Teslimi"
                            style="width: 1.2em; height: 1.2em; margin-right: 0.5em;" onclick="checkRaporlama()">
                        <label for="teslimCheckbox" style="font-weight: 400; font-size: 1.2rem;">Evrakların ilgili
                            makama teslimini sağlarım.</label>
                    </div>



                    <script>
                    function checkRaporlama() {
                        var checkboxes = [
                            document.getElementById("evrakHazirlamaCheckbox"),
                            document.getElementById("teslimCheckbox"),
                        ];

                        var raporlamaCheckbox = document.getElementById("raporlama");

                        // Eğer alt checkboxlardan biri işaretlenirse "Organizasyon ve Sponsorluk" otomatik olarak işaretlensin
                        var anyChecked = checkboxes.some(function(checkbox) {
                            return checkbox.checked;
                        });

                        // "Organizasyon ve Sponsorluk" checkbox'ını sadece alt checkboxlar işaretlenince kontrol ederiz
                        if (anyChecked) {
                            raporlamaCheckbox.checked = true;
                        } else {
                            raporlamaCheckbox.checked = false;
                        }
                    }
                    </script>

                    <!-- Niyet Metni -->
                    <div class="inputBox">
                        <label for="motivationLetter">Niyet Metni</label>
                        <textarea id="motivationLetter" name="niyet"
                            placeholder="Kendinizi tanıtın ve başvurmak istediğiniz departmanı neden seçtiğinizi anlatın."
                            required></textarea>
                    </div>


                    <div style="display: flex; align-items: center; margin-bottom: 0.5em;">
                        <input type="checkbox" id="taahhut" name="departman[]" value="taahhut"
                            style="width: 1.2em; height: 1.2em; margin-right: 0.5em;" required>
                        <label for="taahhut" style="font-weight: 400; font-size: 1.5rem;">
                            Dönem boyunca topluluk içindeki görevimi yerine getireceğimi taahhüt ederim.
                        </label>
                    </div>

                    <input style="display: inline-block;
    padding: 1rem 2rem;
    font-size: 1.4rem;
    color: white;
    background-color: #060133;
    border-radius: 1.2rem;
    text-align: center;
    cursor: pointer;
    opacity: 0.9;
    transition: background-color 0.3s ease, opacity 0.3s ease;" type="submit" class="btn" value="Yönetim Kuruluna Başvur" name="yonetim" />
                </div>
            </form>
        </div>
    </section>

    <section class="event-application">
        <h1 onclick="toggleSection('event-application-form')">Etkinliğe Başvur</h1>
        <span class="label-note">(Aktif etkinliğe başvurmak için)</span>
        <div class="form-section" id="event-application-form">
            <form method="post">
                <div class="inputBox">
                    <label for="eventStudentId">Öğrenci Numarası</label>
                    <input type="text" id="eventStudentId" name="sono" placeholder="Öğrenci Numarası" required />
                </div>
                <div class="inputBox">
                    <label for="events">Etkinlikler</label>
					<?php
						$sql="select * from etkinlikler where b_durum=0";
								$result=mysqli_query($baglanti,$sql);
								$row=mysqli_fetch_all($result);
								if($row)
								{
    								echo"<select name='eid' id='eid'>
    								<option value='0'>Lütfen Etkinlik Seçin</option>";
    								for($i=0;$i<count($row);$i++)
    								{
    									$etkinlik=$row[$i][1];
    									$etkinlikid=$row[$i][0];
    									echo"<option value=$etkinlikid>";echo $etkinlik."</option>";		
    								}
								}
								else
								{
							        echo'<h4 align="center" style="color:red">Başvurulacak Etkinlik Yok</h4>';
								}
					?>
				</div>
                <input type="submit" class="btn" value="Etkinliğe Başvur" name="etkinlik" />
            </form>
        </div>
    </section>

    <!-- New Section: Üye Devamsızlık -->
    <section class="additional-section">
        <h1 onclick="toggleSection('attendance-check-form')">Üye Devamsızlık</h1>
        <span class="description">(Üye devamsızlık, puan ve öncelik durumunu görüntülemek için tıklayınız)</span>
        <div class="form-section" id="attendance-check-form">
            <form method="post" action='devamsizlik'>
                <div class="inputBox">
                    <label for="absenceStudentId">Öğrenci Numarası</label>
                    <input type="number" id="absenceStudentId" name="devamno" placeholder="Öğrenci Numarası" required />
                </div>
                <input type="submit" class="btn" name="devam"value="Devamsızlık Sorgula" />
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
                    section.style.display = (section.style.display === 'none' || section.style.display === '') ? 'block' : 'none';
                } else {
                    section.style.display = 'none';
                }
            });
        }
		function toggleOtherDepartment() {
    var select = document.getElementById('department');
    var otherInput = document.getElementById('bolum_other');
    if (select.value === 'other') {
        otherInput.style.display = 'block';
        otherInput.required = true; // Make the input required if "Other" is selected
    } else {
        otherInput.style.display = 'none';
        otherInput.required = false; // Remove the requirement if "Other" is not selected
    }
}
    </script>
</body>
</html>
