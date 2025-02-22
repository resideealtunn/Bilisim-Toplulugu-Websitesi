<?php
    include("baglan.php");
    if(isset($_POST["etkinlik"]))
					{
					    $alert=null;
					    $tur="danger";
							$numara=$_POST["sono"];
							if($numara<>"")
							{
								$sql="select * from etkinlikler where y_durum=0 order by id desc";
								$result=mysqli_query($baglanti,$sql);
								$row=mysqli_fetch_all($result);
								$sql2="select id from uyeler where numara='$numara'";
								$result2=mysqli_query($baglanti,$sql2);
								$row2=mysqli_fetch_all($result2);
								if($row2 && $row)
								{
									$eid=$row[0][0];
									$uid=$row2[0][0];
								
										$sql4="select * from etkinlik_kayit where uye_id='$uid' and etkinlik_id='$eid' ";
										$result4=mysqli_query($baglanti,$sql4);
										$row4=mysqli_fetch_all($result4);
										if(!$row4)
										{
											$sql5="insert into etkinlik_kayit(uye_id,etkinlik_id) values($uid,$eid)";
											$result5=mysqli_query($baglanti,$sql5);
											if($result5)
											{
												$alert="Yoklama Başarıyla Alındı";
												$tur="success";
											}
											else
											{
												$alert="QR'ı Tekrar Okutun";
											}
										}
										else
										{
										    $alert="Daha Önce Yoklama Alınmış";
										}
									
								}
								else
								{
									$alert="Lütfen Topluluğa Üye Olun";
								}
							}
							else
							{
							    $alert="Lütfen Numaranızı Girin";
							}
						header("Cache-Control: no-cache, must-revalidate");
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
    if ($alert) {
        echo "<div class='alert alert-$tur' role='alert'>
				$alert
			</div>";
    }
    ?>
    <section class="event-application">
        <h1 onclick="toggleSection('event-application-form')">
        <?php
        $sql="SELECT isim FROM `etkinlikler` WHERE y_durum=0
        order by id desc";
        $result=mysqli_query($baglanti,$sql);
        $row=mysqli_fetch_all($result);
        $isim=$row[0][0];
        if($isim)
        {
            echo $isim. " ETKİNLİK YOKLAMASI";
            echo'</h1>
        <span class="label-note">(Katıldığınız etkinlikte yoklama kaydı yapabilmek için)</span>
        <div class="form-section" id="event-application-form" style="display:block">
            <form method="post">
                <div class="inputBox">
                    <label for="eventStudentId">Öğrenci Numarası</label>
                    <input type="text" id="eventStudentId" name="sono" placeholder="Öğrenci Numarası" required />
                </div>
                <input type="submit" class="btn" value="Katıldım!" name="etkinlik" />
            </form>
        </div>';
        }
        else
        {
            echo "YOKLAMASI ALINACAK ETKİNLİK YOK";
        }
        ?>
    </section>
    <footer class="footer py-3 my-4">
        <div class="share">
            <a style='text-decoration: none;' href="https://chat.whatsapp.com/CNoPPLXvyTJAQhkft0nkc0"
                class="fab fa-whatsapp"></a>
            <a style='text-decoration: none;' href="https://github.com/neubilisimtoplulugu" class="fab fa-github"></a>
            <a style='text-decoration: none;' href="https://www.instagram.com/neubilisimtoplulugu/"
                class="fab fa-instagram"></a>
            <a style='text-decoration: none;'
                href="https://www.linkedin.com/company/necmettin-erbakan-%C3%BCniversitesi-bili%C5%9Fim-toplulu%C4%9Fu/?viewAsMember=true"
                class="fab fa-linkedin"></a>
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
                    section.style.display = (section.style.display === 'none' || section.style.display === '') ?
                        'block' : 'none';
                } else {
                    section.style.display = 'none';
                }
            });
        }
    
        function toggleOtherDepartment() {
            var select = document.getElementById('applicationDepartment');
            var otherInput = document.getElementById('bolum_other');
            if (select.value === 'other') {
                otherInput.style.display = 'block';
                otherInput.required = true;
            } else {
                otherInput.style.display = 'none';
                otherInput.required = false;
            }
        }
        </script>
</body>

</html>