<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_admins = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
   $delete_admins->execute([$delete_id]);
   header('location:admin_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <section class="accounts">

      <h1 class="heading">Admin Accounts</h1>

      <div class="box-container">

         <div class="box">
            <p>Add New Admin</p>
            <a href="register_admin.php" class="option-btn">Admin Register</a>
         </div>

         <?php
         $select_accounts = $conn->prepare("SELECT * FROM `admins`");
         $select_accounts->execute();
         if ($select_accounts->rowCount() > 0) {
            while ($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)) {
         ?>
               <div class="box">
                  <p> Admin ID : <span><?= $fetch_accounts['id']; ?></span> </p>
                  <p> Admin Name : <span><?= $fetch_accounts['name']; ?></span> </p>
                  <div class="flex-btn">
                     <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('Delete this Account?')" class="delete-btn">Delete</a>
                     <?php
                     if ($fetch_accounts['id'] == $admin_id) {
                        echo '<a href="update_profile.php" class="option-btn">Update</a>';
                     }
                     ?>
                  </div>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">No Accounts Available!</p>';
         }
         ?>

      </div>

   </section>
   <script src="../js/admin_script.js"></script>

</body>

</html>