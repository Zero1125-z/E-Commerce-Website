<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

if (isset($_POST['update'])) {

   $pid = $_POST['pid'];
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, details = ? WHERE id = ?");
   $update_product->execute([$name, $price, $details, $pid]);

   $message[] = 'Product Updated Successfully!';

   $old_image_01 = $_POST['old_image_01'];
   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/' . $image_01;

   if (!empty($image_01)) {
      if ($image_size_01 > 2000000) {
         $message[] = 'Image size is too large!';
      } else {
         $update_image_01 = $conn->prepare("UPDATE `products` SET image_01 = ? WHERE id = ?");
         $update_image_01->execute([$image_01, $pid]);
         move_uploaded_file($image_tmp_name_01, $image_folder_01);
         unlink('../uploaded_img/' . $old_image_01);
         $message[] = 'Image Updated Successfully!';
      }
   }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Product</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <section class="update-product">

      <h1 class="heading">Update Product</h1>

      <?php
      $update_id = $_GET['update'];
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$update_id]);
      if ($select_products->rowCount() > 0) {
         while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
      ?>
            <form action="" method="post" enctype="multipart/form-data">
               <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
               <input type="hidden" name="old_image_01" value="<?= $fetch_products['image_01']; ?>">
               <div class="image-container">
                  <div class="main-image">
                     <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                  </div>
                  <div class="sub-image">
                     <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                  </div>
               </div>
               <span>Update Name</span>
               <input type="text" name="name" required class="box" maxlength="100" placeholder="Enter Product Name" value="<?= $fetch_products['name']; ?>">
               <span>Update Price</span>
               <input type="number" name="price" required class="box" min="0" max="9999999999" placeholder="Enter Product Price" onkeypress="if(this.value.length == 10) return false;" value="<?= $fetch_products['price']; ?>">
               <span>Update Details</span>
               <textarea name="details" class="box" required cols="30" rows="10"><?= $fetch_products['details']; ?></textarea>
               <span>Update Image</span>
               <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">

               <div class="flex-btn">
                  <input type="submit" name="update" class="btn" value="update">
                  <a href="products.php" class="option-btn">Go Back!</a>
               </div>
            </form>

      <?php
         }
      } else {
         echo '<p class="empty">no product found!</p>';
      }
      ?>

   </section>












   <script src="../js/admin_script.js"></script>

</body>

</html>