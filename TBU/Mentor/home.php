<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>TBU Home</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- =======================================================
  * Template Name: Mentor
  * Template URL: https://bootstrapmade.com/mentor-free-education-bootstrap-theme/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

  <style>
    .btnn{
      background-color:#823341;
      transition: all 0.3s ease-in-out;
    }
    .btnn:hover{
      background-color:#b54c5f;
    }

  </style>
</head>

<body class="index-page">

<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">TBU</h1>
      </a>

      <nav id="navmenu" class="navmenu w-100 d-flex justify-content-center">
        <ul class="d-flex justify-content-center align-items-center gap-4 m-0">
          <li><a href="home.php" class="<?= basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : '' ?>">Home</a></li>
          <?php if (isset($userData['cv_score']) && isset($userData['quiz_score'])): ?>
            <li><a href="result.php" class="<?= basename($_SERVER['PHP_SELF']) == 'result.php' ? 'active' : '' ?>">Matched Universities</a></li>
          <?php else: ?>
            <li><a href="quizPage.php" class="<?= basename($_SERVER['PHP_SELF']) == 'quizPage.php' ? 'active' : '' ?>">Quiz</a></li>
          <?php endif; ?>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="dropdown custom-dropdown">
        <a class="btn-getstarted dropdown-toggle" href="#" role="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa-solid fa-circle-user text-white me-2"></i>Profile
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
          <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
          <li><a class="dropdown-item" href="settings.php">Settings</a></li>
          <li><hr class="dropdown-divider" style="border-color: rgba(111, 110, 110, 0.3);"></li>
          <li><a class="dropdown-item" href="logout.php">Logout</a></li>
        </ul>
      </div>

    </div>
  </header>
  

  <main class="main">
  <section class="vh-100 d-flex align-items-center bg-light mb-sm-5">
  <div class="container">
    <div class="row align-items-center text-center text-md-start">
      
      <!-- Image Column -->
      <div class="col-lg-6 mb-4 mb-md-0">
        <img src="assets/img/toga.png" alt="Toga" class="img-fluid">
      </div>

      <!-- Text Column -->
      <div class="col-lg-6">
        <h2 class="fw-bold mb-3" data-aos="fade-up" data-aos-delay="100">
          Empowering Minds,<br>Building Futures
        </h2>
        <p class="mb-4" data-aos="fade-up" data-aos-delay="200">
          Tirana Business University is where innovation meets education.
          Prepare for tomorrow with real-world knowledge and opportunities.
        </p>
        <div data-aos="fade-up" data-aos-delay="300">
          <a href="courses.html" class="btnn btn px-4 py-2 fw-semibold text-white">
            Get Started
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- About Us Section -->
<section id="about" class="about section py-5 vh-100 d-flex align-items-center mt-5 mt-lg-1">
  <div class="container">
    <div class="row align-items-center">
      
      <!-- Text Left -->
      <div class="col-lg-6">
        <h2 class="fw-bold mb-3" style="font-size: 1.8rem;">About Tirana Business University</h2>
        <p class="mb-3 text-muted" style="font-size: 0.95rem;">
          Tirana Business University (TBU) is a modern, innovative higher education institution dedicated to preparing students for leadership in the fields of Business, Law, and Information Technology.
        </p>
        <ul class="list-unstyled text-muted" style="font-size: 0.9rem;">
          <li><i class="bi bi-check-circle-fill text-danger me-2"></i> Founded by professionals from the BALFIN Group.</li>
          <li><i class="bi bi-check-circle-fill text-danger me-2"></i> Real-world learning via internships and case studies.</li>
          <li><i class="bi bi-check-circle-fill text-danger me-2"></i> 150+ partners & 95% graduate employment rate.</li>
        </ul>
        <p class="mb-4 text-muted" style="font-size: 0.9rem;">
          Our programs emphasize innovation, entrepreneurship, and global collaboration to meet modern job market demands.
        </p>
        <a href="#contact" class="btnn btn px-4 py-2 fw-semibold text-white">
          Learn More
        </a>
      </div>

      <!-- Image Right -->
      <div class="col-lg-6 text-center">
        <img src="assets/img/brain.png" class="img-fluid" style="max-width: 55%;" alt="University Image">
      </div>

    </div>
  </div>
</section>






  </main>

  <footer id="footer" class="footer position-relative light-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">Mentor</span>
          </a>
          <div class="footer-contact pt-3">
            <p>A108 Adam Street</p>
            <p>New York, NY 535022</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
            <p><strong>Email:</strong> <span>info@example.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Terms of service</a></li>
            <li><a href="#">Privacy policy</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Our Services</h4>
          <ul>
            <li><a href="#">Web Design</a></li>
            <li><a href="#">Web Development</a></li>
            <li><a href="#">Product Management</a></li>
            <li><a href="#">Marketing</a></li>
            <li><a href="#">Graphic Design</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12 footer-newsletter">
          <h4>Our Newsletter</h4>
          <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
          <form action="forms/newsletter.php" method="post" class="php-email-form">
            <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your subscription request has been sent. Thank you!</div>
          </form>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Mentor</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>