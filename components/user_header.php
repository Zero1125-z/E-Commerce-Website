<?php
include_once __DIR__ . '/../components/connect.php'; // Include the database connection

// Test the connection
// if ($conn) {
//     echo "Database connection established.<br>";
// } else {
//     echo "Database connection failed.<br>";
// }

// Fetch Data
function fetchData() {
    global $conn;  // Make sure $conn is accessible inside the function
    $stmt = $conn->prepare("SELECT * FROM users");
    $stmt->execute();
    return $stmt->fetchAll();
}




if (isset($message)) {
   foreach ($message as $message) {
      echo '
         <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
   }
}
?>

<header class="header">

   <section class="flex">
      <div class="logo">
         <img src="images/kicks.png" height="100px" width="160px">
      </div>

      <nav class="navbar">
         <a href="home.php">Home</a>
         <a href="about.php">About</a>
         <a href="orders.php">Orders</a>
         <a href="shop.php">Shop</a>
         <a href="contact.php">Contact</a>
      </nav>

      <div class="icons">
         <?php
         $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
         $count_wishlist_items->execute([$user_id]);
         $total_wishlist_counts = $count_wishlist_items->rowCount();

         $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $count_cart_items->execute([$user_id]);
         $total_cart_counts = $count_cart_items->rowCount();
         ?>
         <div id="menu-btn" class="fas fa-bars"></div>
         <a href="search_page.php"><i class="fas fa-search"></i></a>
         <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?= $total_wishlist_counts; ?>)</span></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_counts; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
         $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
         $select_profile->execute([$user_id]);
         if ($select_profile->rowCount() > 0) {
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
            <p><?= $fetch_profile["name"]; ?></p>
            <a href="update_user.php" class="btn">Update Profile</a>
            <div class="flex-btn">
               <a href="user_register.php" class="btn">Register</a>
               <a href="user_login.php" class="btn">Login</a>
            </div>
            <a href="components/user_logout.php" class="delete-btn" onclick="return confirm('logout from the website?');">Logout</a>
         <?php
         } else {
         ?>
            <p>Please Login or Register First!</p>
            <div class="flex-btn">
               <a href="user_register.php" class="btn">Register</a>
               <a href="user_login.php" class="btn">Login</a>
            </div>
         <?php
         }
         ?>


      </div>

   </section>

</header>