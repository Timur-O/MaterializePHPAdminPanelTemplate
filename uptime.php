<?php
session_start();

include 'loginCheck.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php include 'head.php';?>
    <title>Uptime - Admin Panel</title>
  </head>
  <body>
    <!-- Include the Nav into the page -->
    <?php include 'nav.php';?>
    <div class="main">
      <!-- Button to show/hide menu -->
      <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
      <div class="row">
        <div class="col s12 center"><h5 id="overalluptimeheader">Overall Uptime</h5></div>
      </div>

      <div class="row">
        <div class="col m4 s12 center">
          <div id="uptime1days" class="card">
            <div class="card-content">
              <span class="card-title">Last 24 Hours</span>
              <h5></h5>
            </div>
          </div>
        </div>
        <div class="col m4 s12 center">
          <div id="uptime7days" class="card">
            <div class="card-content">
              <span class="card-title">Last 7 Days</span>
              <h5></h5>
            </div>
          </div>
        </div>
        <div class="col m4 s12 center">
            <div id="uptime30days" class="card">
              <div class="card-content">
                <span class="card-title">Last 30 Days</span>
                <h5></h5>
              </div>
            </div>
        </div>
      </div>

      <div class="row">
        <div class="col s12 center"><h5>Uptime Information</h5></div>
      </div>

      <div class="row respon-table">
        <table class="col s12 m10 offset-m1" id="monitor_table">
          <thead>
            <tr>
              <th>Name</th>
              <th>URL</th>
              <th>Last 7 Days</th>
              <th>Avg. Response Time</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>

    </div>
    <?php include 'foot.php';?>
  </body>
</html>
