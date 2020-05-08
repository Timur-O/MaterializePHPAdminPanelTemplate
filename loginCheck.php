<?php
include 'config.php';

if (isset($_SESSION['adminUser'])) {
  $adminUser = $_SESSION['adminUser'];
  $sql = "SELECT `{$emailColumn}` FROM `{$adminTableName}` WHERE `{$primaryKeyColumn}` = '{$adminUser}'";
  $result = $conn->query($sql);
  if ($result->num_rows == 1) {
    $result = $conn->query($sql)->fetch_assoc();
    $email = $result[$emailColumn];
    $_SESSION['email'] = $email;
  } else {
    //Redirect Bc Not Admin
    header("Location: index.php"); die();
  }
} else {
  //Redirect
  header("Location: index.php"); die();
}
?>