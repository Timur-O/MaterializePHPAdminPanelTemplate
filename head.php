<?php require 'config.php'; ?>
<meta charset="utf-8">
<!--Let browser know website is optimized for mobile-->
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<!-- Import CSS Stylesheet -->
<link type="text/css" rel="stylesheet" href="css/style.css" />
<!-- Import Materialize CSS -->
<link type="text/css" rel="stylesheet" href="css/materialize.min.css" />
<!--Import Materialize Icons Font-->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!-- Set Icon -->
<link rel="shortcut icon" type="image/png" href="images/favicon.png"/>
<!-- Import JQuery -->
<script type="text/javascript" src="js/jquery-3.5.0.min.js"></script>
<!-- Import Materialize JS -->
<script type="text/javascript" src="js/materialize.min.js"></script>
<!-- Import ChartJS -->
<script type="text/javascript" src="js/Chart.bundle.min.js"></script>
<script>
  function getUptimeKey() {
    return "<?php echo $uptimeKey; ?>";
  }
</script>
<script type="text/javascript" src="js/script.js"></script>