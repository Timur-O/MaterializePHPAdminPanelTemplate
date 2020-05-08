<?php
session_start();
include 'config.php';
if (isset($_SESSION['adminUser'])) {
  $adminUser = $_SESSION['adminUser'];
  $sql = "SELECT `{$emailColumn}` FROM `{$adminTableName}` WHERE `{$primaryKeyColumn}` = '{$adminUser}'";
  $result = $conn->query($sql);
  if ($result->num_rows === 1) {
    //Redirect to overview
    header("Location: overview.php"); die();
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php include 'head.php';?>
    <title>Login - Admin Panel</title>
  </head>
  <body>
    <div class="loginmain">
      <div class="row rowtoppadded10">
        <div class="col s4 offset-s4 loginbox center">
          <h5>Login</h5>
          
          <?php
            $passwordError = $emailError = "";
            
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                include 'config.php';

                $passwordError = $emailError = "";
                $passwordValid = $emailValid = false;

                if (empty($_POST["email"])) {
                  $emailError = "Email is required";
                } else {
                  $email = test_input($_POST["email"]);
                  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailError = "Invalid email format";
                  } else {
                    $sql = "SELECT * FROM `{$adminTableName}` WHERE `{$emailColumn}` = '{$email}'";
                    $result = $conn->query($sql);

                    if (empty($result) OR $result->num_rows === 0) {
                      $emailError = "No such user found";
                    } else {
                      // Account Exists
                      $emailValid = true;
                    }
                  }
                }

                if (empty($_POST["password"])) {
                  $passwordError = "Password is required";
                } else {
                  $password = test_input($_POST["password"]);

                  $sql = "SELECT `{$hashPasswordColumn}` FROM `{$adminTableName}` WHERE `{$emailColumn}` = '{$email}'";
                  $result = $conn->query($sql) or die($conn->error);
                  $result = $result->fetch_assoc();
                  $hashPass = $result[$hashPasswordColumn];

                  if (password_verify($password, $hashPass)) {
                    //Passwords Match
                    $passwordValid = true;
                  } else {
                    $passwordError = "Incorrect Password";
                  }
                }

                if ($passwordValid && $emailValid) {
                  $sql = "SELECT `{$primaryKeyColumn}` FROM `{$adminTableName}` WHERE `{$emailColumn}` = '{$email}'";
                  $result = $conn->query($sql) or die($conn->error);
                  $result = $result->fetch_assoc();
                  $adminID = $result[$primaryKeyColumn];

                  $_SESSION['adminUser'] = $adminID;

                  //Redirect
                  header("Location: overview.php"); die();
                }
            }

            function test_input($data) {
              $data = trim($data);
              $data = stripslashes($data);
              $data = htmlspecialchars($data);
              return $data;
            }
          ?>
          
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="input-field col s12">
              <input id="email" type="email" class="validate" name="email">
              <label for="email">Email</label>
              <p class="red-text"><?php echo $emailError;?></p>
            </div>
            <div class="input-field col s12">
              <input id="password" type="password" class="validate" name="password">
              <label for="password">Password</label>
              <p class="red-text"><?php echo $passwordError;?></p>
            </div>
            <div class="col s12 rowbottompadded">
              <button class="btn waves-effect waves-light" type="Submit" name="action">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php include 'foot.php';?>
  </body>
</html>
