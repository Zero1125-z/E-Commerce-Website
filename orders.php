<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

?>
<?php

if (isset($_GET['delete'])) {

   $delete_id = $_GET['delete'];
   $delete_product = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   header('location:orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="orders">

      <h1 class="heading">placed orders</h1>

      <div class="box-container">

         <?php
         if ($user_id == '') {
            echo '<p class="empty">please login to see your orders</p>';
         } else {
            $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
            $select_orders->execute([$user_id]);
            if ($select_orders->rowCount() > 0) {
               while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
         ?>
                  <div class="box">
                     <p>Placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
                     <p>Name : <span><?= $fetch_orders['name']; ?></span></p>
                     <p>Email : <span><?= $fetch_orders['email']; ?></span></p>
                     <p>Number : <span><?= $fetch_orders['number']; ?></span></p>
                     <p>Address : <span><?= $fetch_orders['address']; ?></span></p>
                     <p>Payment By : <span><?= $fetch_orders['method']; ?></span></p>
                     <p>Your Orders : <span><?= $fetch_orders['total_products']; ?></span></p>
                     <p>Total Price : <span>रू<?= $fetch_orders['total_price']; ?>/-</span></p>
                     <p> Payment Status : <span style="color:<?php if ($fetch_orders['payment_status'] == 'Pending') {
                                                                  echo 'red';
                                                               } else {
                                                                  echo 'green';
                                                               }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
                  </div>

                  <a href="orders.php?delete=<?php echo $fetch_orders['id']; ?>" class="btn" onclick="return confirm('Cancel your Order?');">Cancel Order</a>

         <?php
               }
            } else {
               echo '<p class="empty">no orders placed yet!</p>';
            }
         }
         ?>

      </div>

   </section>













   <?php include 'components/footer.php'; ?>

   <script src="js/script.js"></script>

</body>

</html>