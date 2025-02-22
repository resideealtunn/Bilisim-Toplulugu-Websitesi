<?php
	include("baglan.php")
?>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    />
    <link rel="stylesheet" href="styles/styleuye.css" />
    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="images/bilisimlogo.png"
    />
    <title>İndirim</title>
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
        display: block; /* Center button */
        margin: 1em auto; /* Center button */
      }

      /* Center the submit button */
      input[type="submit"].btn {
        display: block;
        margin: 1em auto; /* Center the button */
      }

      /* Styles for result messages */
      .result {
        font-size: 1.6rem; /* Make the font size larger */
        font-weight: bold; /* Make it bold */
        text-align: center; /* Center the text */
      }

      .result.eligible {
        color: green; /* Green color for eligible message */
      }

      .result.ineligible {
        color: red; /* Red color for ineligible message */
      }

      /* Styles for name display */
      .name-container {
        display: flex; /* Use flexbox for horizontal alignment */
        justify-content: center; /* Center horizontally */
        margin-top: 1em; /* Margin for spacing */
      }

      .ad,
      .soyad {
        font-size: 1.6rem; /* Font size */
        font-weight: bold; /* Bold font */
        margin: 0 0.5em; /* Space between names */
      }

      /* Limit image size */
      .resim {
        max-width: 150px; /* Set a max width for the image */
        height: auto; /* Maintain aspect ratio */
        display: block; /* Center it */
        margin: 1em auto; /* Center the image */
      }

      h1 {
        cursor: pointer;
        text-align: center; /* Center the heading */
      }

      .form-section {
        display: block; /* Başlangıçta gizli */
        margin-top: 1em;
        text-align: center; /* Center text inside form-section */
      }
    </style>
  </head>

  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary header">
      <div class="container-fluid">
        <a class="navbar-brand logo">
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

    <section class="event-application">
      <h1 onclick="toggleSection('event-application-form')">
        İndirim Sistemi Giriş Ekranı
      </h1>
      <span class="label-note">(İndirim Sistemine Giriş Yapmak İçin)</span>
      <div class="form-section" id="event-application-form">
		<?php
			if(isset($_POST["indirim"]))
			{
				$no=$_POST["sono"];
				$sql="select u.isim,i.gorsel from indirim as i
				inner join uyeler as u on u.id=i.uye_id
				where u.numara='$no'";
				$result=mysqli_query($baglanti,$sql);
				$row=mysqli_fetch_all($result);
				if($row)
				{
					$ad=$row[0][0];
					$gorsel=$row[0][1];
					if($gorsel)
					{
						echo"<p class='result' style='color:green'><b>İndirim VAR</b></p>
						  <img class='resim' src='images/$gorsel'>
							<div class='name-container'>
								<p class='ad'>$ad</p>
							</div>";
					}
				}
				else
				{
					echo"<p class='result' style='color:red'><b>İndirim YOK</b></p>
						  <img class='resim' src='images/varsayilan.png'/>
							<div class='name-container'>
							</div>";
				}
			}
			else
			{
          echo"<p class='result'></p>
          <img class='resim' src='images/varsayilan.png'>
			<div class='name-container'>
				<p class='ad'></p>
			</div>";
			}
			?>
        <form method="POST">
		  <div class="inputBox">
            <label for="eventStudentId">Öğrenci Numarası</label>
            <input
              type="number"
              id="eventStudentId"
              name="sono"
              placeholder="Öğrenci Numarası"
              required
            />
          </div>
          <input type="submit" class="btn" name="indirim" value="Sorgula" />
        </form>
      </div>
    </section>

    <footer class="footer py-3 my-4">
      <div class="share">
        <a
          style="text-decoration: none"
          href="https://chat.whatsapp.com/CNoPPLXvyTJAQhkft0nkc0"
          class="fab fa-whatsapp"
        ></a>
        <a
          style="text-decoration: none"
          href="https://github.com/neubilisimtoplulugu"
          class="fab fa-github"
        ></a>
        <a
          style="text-decoration: none"
          href="https://www.instagram.com/neubilisimtoplulugu/"
          class="fab fa-instagram"
        ></a>
        <a
          style="text-decoration: none"
          href="https://www.linkedin.com/company/necmettin-erbakan-%C3%BCniversitesi-bili%C5%9Fim-toplulu%C4%9Fu/?viewAsMember=true"
          class="fab fa-linkedin"
        ></a>
      </div>
      <div class="links nav justify-content-center border-bottom pb-3 mb-3">
        <a href="index" class="active nav-link">Ana Sayfa</a>
        <a href="etkinlikler" class="nav-link">Etkinlikler</a>
        <a href="sponsorlar" class="nav-link">Sponsorlar</a>
        <a href="uyeislemleri" class="nav-link">Üye İşlemleri</a>
      </div>
      <div class="credit">
        <p class="text-center">
          © 2024 Bilişim Topluluğu, Tüm Hakları Saklıdır.
        </p>
      </div>
    </footer>

    <script>
      function toggleSection(id) {
        const sections = document.querySelectorAll(".form-section");
        sections.forEach((section) => {
          if (section.id === id) {
            section.style.display =
              section.style.display === "none" || section.style.display === ""
                ? "block"
                : "block";
          } else {
            section.style.display = "none"; // Hide other sections
          }
        });
      }
    </script>
  </body>
</html>
