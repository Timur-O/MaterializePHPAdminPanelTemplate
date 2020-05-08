<!-- Nav Menu -->
<ul id="slide-out" class="sidenav sidenav-fixed">
  <li><a href="#"><i class="material-icons">account_box</i><?php echo $_SESSION['email'];?></a></li>
  <li><a href="logout.php"><i class="material-icons">exit_to_app</i>Log Out</a></li>
  <li><div class="divider"></div></li>
  <li><a href="index.php"><i class="material-icons">dashboard</i>Overview</a></li>
  <li><div class="divider"></div></li>
  <li><a class="subheader">Management Tools</a></li>
  <li><a href="manageusers.php"><i class="material-icons">supervisor_account</i>Manage Users</a></li>
  <li><a href="analytics.php"><i class="material-icons">insert_chart</i>Analytics</a></li>
  <li><a href="uptime.php"><i class="material-icons">swap_vertical_circle</i>Service Status</a></li>
</ul>