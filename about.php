<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About Us</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="about">

      <div class="row">
         <div class="image">
            <img src="images/aboutus/collection.jpg" alt="">
         </div>

         <div class="content">
            <h3>Why choose us?</h3>
            <p>At Kicks, shoes are more than just footwear—they're an expression of your personality and a reflection of our commitment to excellence. Experience the difference with Kicks today.

.</p>
            <a href="contact.php" class="btn">Contact Us</a>
         </div>
      </div>

      <div class="row">

         <div class="content">
            <h3>What we provide?</h3>
            <p>We provide high quality shoes at an affordable price here!</p>
            <a href="contact.php" class="btn">Contact us</a>
         </div>

         <div class="image">
            <img src="images/aboutus/menshoes.jpg" alt="">
         </div>

      </div>
      <div class="row">
         <div class="image">
            <img src="images/aboutus/kicks.jpg" alt="">
         </div>

         <div class="content">
            <h3>Kicks.</h3>
            <p>Stepping into Style, One Click at a Time

Welcome to Kicks, your ultimate destination for footwear that blends fashion, comfort, and convenience. We understand that shoes are more than just accessories; they're a reflection of your personality and an essential part of your everyday life. That's why we're committed to bringing you a curated collection of shoes that cater to your style and comfort needs.</p>

            <a href="shop.php" class="btn">Explore</a>
         </div>

      </div>

   </section>

   <section class="reviews">

      <h1 class="heading">Client Reviews</h1>

      <div class="swiper reviews-slider">

         <div class="swiper-wrapper">

            <div class="swiper-slide slide">
               <img src="images/customer/zero.jpg" alt="">
               <p>Always getting shoes from here only.</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
               <h3>Yoongie</h3>
            </div>

            <div class="swiper-slide slide">
               <img src="images/customer/inori.jpg" alt="">
               <p>This is the best site to buy shoes ever!</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
               <h3>Hobie</h3>
            </div>

            <div class="swiper-slide slide">
               <img src="images/customer/zero2.jpg" alt="">
               <p>The products here are so good.</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
               <h3>Kookie</h3>
            </div>

         </div>

      </div>

   </section>
   <?php include 'components/footer.php'; ?>

   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

   <script src="js/script.js"></script>

   <script>
      var swiper = new Swiper(".reviews-slider", {
         loop: true,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
         breakpoints: {
            0: {
               slidesPerView: 1,
            },
            768: {
               slidesPerView: 2,
            },
            991: {
               slidesPerView: 3,
            },
         },
      });
   </script>

</body>

</html>