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
          <form>
            <div class="input-field col s12">
              <input id="email" type="email" class="validate">
              <label for="email">Email</label>
            </div>
            <div class="input-field col s12">
              <input id="password" type="password" class="validate">
              <label for="password">Password</label>
            </div>
            <div class="col s12 rowbottompadded">
              <a class="waves-effect waves-light btn">Login</a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php include 'foot.php';?>
  </body>
</html>
