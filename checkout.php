<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:user_login.php');
};

if (isset($_POST['order'])) {
      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $number = $_POST['number'];
      $number = filter_var($number, FILTER_SANITIZE_STRING);
      $email = $_POST['email'];
      $email = filter_var($email, FILTER_SANITIZE_STRING);
      $method = $_POST['method'];
      $method = filter_var($method, FILTER_SANITIZE_STRING);
      $address = 'flat no. ' . $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['district'];
      $address = filter_var($address, FILTER_SANITIZE_STRING);
      $total_products = $_POST['total_products'];
      $total_price = $_POST['total_price'];

      $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $check_cart->execute([$user_id]);

      if ($check_cart->rowCount() > 0) {

         $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
         $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

         $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
         $delete_cart->execute([$user_id]);

         $message[] = 'Order Placed Successfully!';
      } else {
      $message[] = 'Your Cart is Empty';
      }
   }



?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="checkout-orders">

      <form action="" method="POST">

         <h3>Your Orders</h3>

         <div class="display-orders">
            <?php
            $grand_total = 0;
            $cart_items[] = '';
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            if ($select_cart->rowCount() > 0) {
               while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                  $cart_items[] = $fetch_cart['name'] . ' (' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity'] . ') - ';
                  $total_products = implode($cart_items);
                  $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
            ?>
                  <p> <?= $fetch_cart['name']; ?> <span>(<?= '$' . $fetch_cart['price'] . '/- x ' . $fetch_cart['quantity']; ?>)</span> </p>
            <?php
               }
            } else {
               echo '<p class="empty">Your Cart is Empty!</p>';
            }
            ?>
            <input type="hidden" name="total_products" value="<?= $total_products; ?>">
            <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
            <div class="grand-total">Grand total : <span>$<?= $grand_total; ?>/-</span></div>
         </div>

         <h3>Place your Orders</h3>
         <div class="flex">
            <div class="inputBox">
               <span>Your Name :</span>
               <input type="text" name="name" placeholder="Enter your Name" class="box" maxlength="20" required>
            </div>
            <div class="inputBox">
               <span>Your Number :</span>
               <input type="number" name="number" placeholder="Enter your Number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
            </div>
            <div class="inputBox">
               <span>Your Email :</span>
               <input type="email" name="email" placeholder="Enter your Email" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>Payment Method :</span>
               <select name="method" class="box" id="checkjs" required>
                  <option value="cash on delivery">Cash on Delivery</option>
                  <option value="khalti">Khalti</option>
               </select>
            </div>
            <div class="inputBox">
               <span>Address Line 01 :</span>
               <input type="text" name="flat" placeholder="Flat / Toll / Ward Number" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>Address Line 02 :</span>
               <input type="text" name="street" placeholder="Street Name" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>Province :</span>
               <input type="text" name="city" placeholder="Bagmati" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>District :</span>
               <input type="text" min="0" name="district" placeholder="Lalitpur" class="box" maxlength="50" required>
            </div>

         </div>

         
         <input type="submit" name="order" id="cashbtn" value="place order" style="visibility:hidden;">
         <input type="submit" name="order" id="success" value="place order" style="visibility:hidden;">

      </form>
      <button onclick="check()" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">place order</button>
      <button id="payment-button" style="visibility:hidden;">Khalti</button>

   </section>

   <?php
$args = http_build_query(array(
  'token' => 'QUao9cqFzxPgvWJNi9aKac',
  'amount'  => 1000
));

$url = "https://khalti.com/api/v2/payment/verify/";


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$headers = ['Authorization: Key test_secret_key_749e3d752e6940489635aff31f8b9aff'];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Response
$response = curl_exec($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
?>











   <?php include 'components/footer.php'; ?>
   <script>
      
      function check(){
         
      var e = document.getElementById("checkjs");
      var value = e.value;
      btnCash = document.getElementById('cashbtn');
      btnKhalti = document.getElementById('payment-button');
         if (value=='cash on delivery'){
            btnCash.click()
         }
         else{
            btnKhalti.click()
         }

      }
   </script>
   <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
    <script>
        var config = {
            "publicKey": "test_public_key_ffb39d9c20614e5c89d6157f4bb0219a",
            "productIdentity": "1234567890",
            "productName": "Dragon",
            "productUrl": "http://gameofthrones.wikia.com/wiki/Dragons",
            "paymentPreference": [
                "KHALTI",
                "EBANKING",
                "MOBILE_BANKING",
                "CONNECT_IPS",
                "SCT",
                ],
            "eventHandler": {
                onSuccess (payload) {
                    // hit merchant api for initiating verfication
                  var btn = document.getElementById('success')
                  btn.click()
                },
                onError (error) {
                    console.log(error);
                },
                onClose () {
                    console.log('widget is closing');
                }
            }
        };

        var checkout = new KhaltiCheckout(config);
        var btn = document.getElementById("payment-button");
        btn.onclick = function () {
            // minimum transaction amount must be 10, i.e 1000 in paisa.
            checkout.show({amount: 1000});
        }
    </script>
   <script src="js/script.js"></script>

</body>

</html>