<?php
  // Your Company Name - Appears in footer next to copyright
  $companyName = "YOUR COMPANY";
  // Your Twitter Handle for Dashboard Feed
  $twitterHandle = "YOURTWITTERHANDLE";
  // READ ONLY KEY for UptimeRobot to Monitor Status - MUST BE READ ONLY -> Will Be Exposed In JS
  $uptimeKey = "YOURUPTIMEROBOTKEY";
  // Analytics View ID
  $analyticsViewID = "ga:" . "YOURANALYTICSVIEWID";
  // RSS Feed Link for Dashboard
  $rssFeed = "YOURRSSLINK";
  // Root of the admin panel files
  // if in a folder called admin simply put "/admin". if not in a folder then simply put "".
  $rootOfFiles = "";
  
  // Add your database information for the login system
  $servername = "sql.yourdomain.tld";
  $username = "username";
  $password = "password";
  $dbname = "yourdatabase"; // Database which contains admin login info
  $adminTableName = "yourtable"; // Name of table containing admin login info
  $clientTableName = "yourtable"; // Name of table containing client login info
  $emailColumn = "email"; // Name of column containing emails
  $hashPasswordColumn = "password"; // Name of column containing passwords
  $primaryKeyColumn = "id"; // Name of column containing the primary key/unique identifier for each row
  
  $conn = new mysqli($servername, $username, $password, $dbname);
  

  // ADD client_secrets.json file for google api access
  // CHANGE ICON BY UPLOADING favicon.png INTO THE IMAGES FOLDER
  // CHANGE LOGO BY UPLOADING logo.png INTO THE IMAGES FOLDER

  // Set up login and logout pages with your database & add a login check on each page.
?>
