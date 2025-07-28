<?php

if (isset($_POST['add_to_wishlist'])) {

   if ($user_id == '') {
      header('location:user_login.php');
      // } else {
   };

   if (isset($_POST['add_to_wishlist'])) {

      $id = $_POST['id'];
      $name = $_POST['name'];
      $price = $_POST['price'];
      $image_01 = $_POST['image_01'];

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$name, $user_id]);

      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
      $check_cart_numbers->execute([$name, $user_id]);

      if ($check_wishlist_numbers->rowCount() > 0) {
         $message[] = 'Already added to Wishlist';
      } elseif ($check_cart_numbers->rowCount() > 0) {
         $message[] = 'Already added to Cart';
      } else {
         $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
         $insert_wishlist->execute([$user_id, $id, $name, $price, $image_01]);
         $message[] = 'Product added to Wishlist';
      }
   }
};


if (isset($_POST['add_to_cart'])) {

   $id = $_POST['id'];
   $name = $_POST['name'];
   $price = $_POST['price'];
   $qty = $_POST['quantity'];
   $image_01 = $_POST['image_01'];


   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$name, $user_id]);

   if ($check_cart_numbers->rowCount() > 0) {
      $message[] = 'Already added to Cart!';
   } else {

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$name, $user_id]);

      if ($check_wishlist_numbers->rowCount() > 0) {
         $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
         $delete_wishlist->execute([$name, $user_id]);
      }

      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $id, $name, $price, $qty, $image_01]);
      $message[] = 'Added to Cart!';
   }
};
