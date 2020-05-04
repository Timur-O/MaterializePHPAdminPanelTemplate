<?php
// Load the Google API PHP Client Library.
require_once __DIR__ . '/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfig(__DIR__ . '/client_secrets.json');
$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
$client->setAccessType('offline');
$client->setIncludeGrantedScopes(true);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php include 'head.php';?>
    <title>Analytics - Admin Panel</title>
  </head>
  <body>
    <!-- Include the Nav into the page -->
    <?php include 'nav.php';?>
    <div class="main">
      <!-- Button to show/hide menu -->
      <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>

      <div class="row rowtoppadded2">
        <div class="col s12">
          <a id="7daybutton" href="analytics.php?dateRange=7daysAgo" class="waves-effect waves-light btn analyticsRangeButton col l1 m2 s12">7 Days</a>
          <a id="30daybutton" href="analytics.php?dateRange=30daysAgo" class="waves-effect waves-light btn analyticsRangeButton col l1 m2 s12">30 Days</a>
          <a id="90daybutton" href="analytics.php?dateRange=90daysAgo" class="waves-effect waves-light btn analyticsRangeButton col l1 m2 s12">90 Days</a>
          <a id="allTimebutton" href="analytics.php?dateRange=allTime" class="waves-effect waves-light btn analyticsRangeButton col l1 m2 s12">All Time</a>
          Currently Viewing:
            <?php
            if (isset($_GET['dateRange'])) {
              if ($_GET['dateRange'] == "90daysAgo") {
                echo "Last 90 Days";
                echo "<script>$('.analyticsRangeButton').attr('class', 'waves-effect waves-light btn analyticsRangeButton col l1 m2 s12'); $('#90daybutton').attr('class', 'waves-effect waves-light btn analyticsRangeButton col l1 m2 s12 purple');</script>";
              } else if ($_GET['dateRange'] == "30daysAgo") {
                echo "Last 30 Days";
                echo "<script>$('.analyticsRangeButton').attr('class', 'waves-effect waves-light btn analyticsRangeButton col l1 m2 s12'); $('#30daybutton').attr('class', 'waves-effect waves-light btn analyticsRangeButton col l1 m2 s12 purple');</script>";
              } else if ($_GET['dateRange'] == "allTime") {
                echo "All Time";
                echo "<script>$('.analyticsRangeButton').attr('class', 'waves-effect waves-light btn analyticsRangeButton col l1 m2 s12'); $('#allTimebutton').attr('class', 'waves-effect waves-light btn analyticsRangeButton col l1 m2 s12 purple');</script>";
              } else {
                echo "Last 7 Days";
                echo "<script>$('.analyticsRangeButton').attr('class', 'waves-effect waves-light btn analyticsRangeButton col l1 m2 s12'); $('#7daybutton').attr('class', 'waves-effect waves-light btn analyticsRangeButton col l1 m2 s12 purple');</script>";
              }
            } else {
              echo "Last 7 Days";
              echo "<script>$('.analyticsRangeButton').attr('class', 'waves-effect waves-light btn analyticsRangeButton col l1 m2 s12'); $('#7daybutton').attr('class', 'waves-effect waves-light btn analyticsRangeButton col l1 m2 s12 purple');</script>";
            }
            ?>
        </div>
      </div>

      <?php
        // If the user has already authorized this app then get an access token
        // else redirect to ask the user to authorize access to Google Analytics.
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
          // Set the access token on the client.
          $client->setAccessToken($_SESSION['access_token']);

          // Create an authorized analytics service object.
          $analytics = new Google_Service_AnalyticsReporting($client);

          // Set Date Range
          if (isset($_GET['dateRange'])) {
            if ($_GET['dateRange'] == "90daysAgo") {
              $startRange = "90daysAgo";
            } else if ($_GET['dateRange'] == "30daysAgo") {
              $startRange = "30daysAgo";
            } else if ($_GET['dateRange'] == "allTime") {
              $startRange = "2005-01-01";
            } else {
              $startRange = "7daysAgo";
            }
          } else {
            $startRange = "7daysAgo";
          }
          $endRange = "yesterday";

          // Call the Analytics Reporting API V4.
          $responseND = getReportND($analytics);
          $responseCountryD = getReportCountryD($analytics);
          $responseDeviceD = getReportDeviceD($analytics);
          $responseMediumD = getReportMediumD($analytics);
          $responseLandingD = getReportLandingD($analytics);
          $responseCategoryD = getReportCategoryD($analytics);

          // Print the response.
          printResultsND($responseND);
          printResultsCountryD($responseCountryD);
          printResultsDeviceD($responseDeviceD);
          printResultsMediumD($responseMediumD);
          printResultsLandingD($responseLandingD);
          printResultsCategoryD($responseCategoryD);
        } else {
          $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/admin/oauth2callback.php';
          header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }

        function getReportND($analytics) {
          global $analyticsViewID;
          $VIEW_ID = $analyticsViewID;

          // Create the DateRange object.
          $dateRange = new Google_Service_AnalyticsReporting_DateRange();
          global $startRange;
          global $endRange;
          $dateRange->setStartDate($startRange);
          $dateRange->setEndDate($endRange);

          // Create the Metrics object.
          $sessions = new Google_Service_AnalyticsReporting_Metric();
          $sessions->setExpression("ga:sessions");
          $sessions->setAlias("sessions");

          // Create the Metrics object.
          $users = new Google_Service_AnalyticsReporting_Metric();
          $users->setExpression("ga:users");
          $users->setAlias("users");

          // Create the Metrics object.
          $newUsers = new Google_Service_AnalyticsReporting_Metric();
          $newUsers->setExpression("ga:newUsers");
          $newUsers->setAlias("newUsers");

          // Create the Metrics object.
          $bounceRate = new Google_Service_AnalyticsReporting_Metric();
          $bounceRate->setExpression("ga:bounceRate");
          $bounceRate->setAlias("bounceRate");

          // Create the Metrics object.
          $avgDuration = new Google_Service_AnalyticsReporting_Metric();
          $avgDuration->setExpression("ga:avgSessionDuration");
          $avgDuration->setAlias("avgDuration");

          // Create the Metrics object.
          $avgPageLoad = new Google_Service_AnalyticsReporting_Metric();
          $avgPageLoad->setExpression("ga:avgPageLoadTime");
          $avgPageLoad->setAlias("avgPageLoad");

          // Create the Metrics object.
          $goalCompletion = new Google_Service_AnalyticsReporting_Metric();
          $goalCompletion->setExpression("ga:goalCompletionsAll");
          $goalCompletion->setAlias("goalCompletion");

          // Create the Metrics object.
          $goalValue = new Google_Service_AnalyticsReporting_Metric();
          $goalValue->setExpression("ga:goalValueAll");
          $goalValue->setAlias("goalValue");

          // Create the ReportRequest object.
          $request = new Google_Service_AnalyticsReporting_ReportRequest();
          $request->setViewId($VIEW_ID);
          $request->setDateRanges($dateRange);
          $request->setMetrics(array($sessions, $users, $newUsers, $bounceRate, $avgDuration, $avgPageLoad, $goalCompletion, $goalValue));

          $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
          $body->setReportRequests( array( $request) );
          return $analytics->reports->batchGet( $body );
        }

        function printResultsND($reports) {
          for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
            $report = $reports[ $reportIndex ];
            $header = $report->getColumnHeader();
            $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
            $rows = $report->getData()->getRows();

            for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
              $row = $rows[ $rowIndex ];
              $metrics = $row->getMetrics();

              for ($j = 0; $j < count($metrics); $j++) {
                $values = $metrics[$j]->getValues();
                for ($k = 0; $k < count($values); $k++) {
                  $entry = $metricHeaders[$k];
                  //print($entry->getName() . ": " . $values[$k] . "\n");
                  global ${'analyticsValue' . $entry->getName()};
                  ${'analyticsValue' . $entry->getName()} = $values[$k];
                }
              }
            }
          }
        }

        function getReportCountryD($analytics) {
          global $analyticsViewID;
          $VIEW_ID = $analyticsViewID;

          // Create the DateRange object.
          $dateRange = new Google_Service_AnalyticsReporting_DateRange();
          global $startRange;
          global $endRange;
          $dateRange->setStartDate($startRange);
          $dateRange->setEndDate($endRange);

          // Create the Metrics object.
          $sessions = new Google_Service_AnalyticsReporting_Metric();
          $sessions->setExpression("ga:sessions");
          $sessions->setAlias("sessions");

          // Create IrderBy Object
          $ordering = new Google_Service_AnalyticsReporting_OrderBy();
          $ordering->setFieldName("ga:sessions");
          $ordering->setOrderType("VALUE");
          $ordering->setSortOrder("DESCENDING");

          // Create the Dimensions object.
          $country = new Google_Service_AnalyticsReporting_Dimension();
          $country->setName("ga:country");

          // Create the ReportRequest object.
          $request = new Google_Service_AnalyticsReporting_ReportRequest();
          $request->setViewId($VIEW_ID);
          $request->setDateRanges($dateRange);
          $request->setMetrics(array($sessions));
          $request->setDimensions(array($country));
          $request->setOrderBys($ordering);

          $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
          $body->setReportRequests( array( $request) );
          return $analytics->reports->batchGet( $body );
        }

        function printResultsCountryD($reports) {
          for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
            $report = $reports[ $reportIndex ];
            $header = $report->getColumnHeader();
            $dimensionHeaders = $header->getDimensions();
            $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
            $rows = $report->getData()->getRows();

            for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
              $row = $rows[ $rowIndex ];
              $dimensions = $row->getDimensions();
              $metrics = $row->getMetrics();
              for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
                //print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
                global $countryArray;
                $values = $metrics[$i]->getValues();
                for ($k = 0; $k < count($values); $k++) {
                  $countryArray[$dimensions[$i]] = $values[$k];
                }

              }
            }
          }
        }

        function getReportDeviceD($analytics) {
          global $analyticsViewID;
          $VIEW_ID = $analyticsViewID;

          // Create the DateRange object.
          $dateRange = new Google_Service_AnalyticsReporting_DateRange();
          global $startRange;
          global $endRange;
          $dateRange->setStartDate($startRange);
          $dateRange->setEndDate($endRange);

          // Create the Metrics object.
          $sessions = new Google_Service_AnalyticsReporting_Metric();
          $sessions->setExpression("ga:sessions");
          $sessions->setAlias("sessions");

          // Create IrderBy Object
          $ordering = new Google_Service_AnalyticsReporting_OrderBy();
          $ordering->setFieldName("ga:sessions");
          $ordering->setOrderType("VALUE");
          $ordering->setSortOrder("DESCENDING");

          // Create the Dimensions object.
          $country = new Google_Service_AnalyticsReporting_Dimension();
          $country->setName("ga:deviceCategory");

          // Create the ReportRequest object.
          $request = new Google_Service_AnalyticsReporting_ReportRequest();
          $request->setViewId($VIEW_ID);
          $request->setDateRanges($dateRange);
          $request->setMetrics(array($sessions));
          $request->setDimensions(array($country));
          $request->setOrderBys($ordering);

          $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
          $body->setReportRequests( array( $request) );
          return $analytics->reports->batchGet( $body );
        }

        function printResultsDeviceD($reports) {
          for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
            $report = $reports[ $reportIndex ];
            $header = $report->getColumnHeader();
            $dimensionHeaders = $header->getDimensions();
            $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
            $rows = $report->getData()->getRows();

            for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
              $row = $rows[ $rowIndex ];
              $dimensions = $row->getDimensions();
              $metrics = $row->getMetrics();
              for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
                //print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
                global $deviceArray;
                $values = $metrics[$i]->getValues();
                for ($k = 0; $k < count($values); $k++) {
                  $deviceArray[$dimensions[$i]] = $values[$k];
                }

              }
            }
          }
        }

        function getReportMediumD($analytics) {
          global $analyticsViewID;
          $VIEW_ID = $analyticsViewID;

          // Create the DateRange object.
          $dateRange = new Google_Service_AnalyticsReporting_DateRange();
          global $startRange;
          global $endRange;
          $dateRange->setStartDate($startRange);
          $dateRange->setEndDate($endRange);

          // Create the Metrics object.
          $sessions = new Google_Service_AnalyticsReporting_Metric();
          $sessions->setExpression("ga:sessions");
          $sessions->setAlias("sessions");

          // Create IrderBy Object
          $ordering = new Google_Service_AnalyticsReporting_OrderBy();
          $ordering->setFieldName("ga:sessions");
          $ordering->setOrderType("VALUE");
          $ordering->setSortOrder("DESCENDING");

          // Create the Dimensions object.
          $country = new Google_Service_AnalyticsReporting_Dimension();
          $country->setName("ga:medium");

          // Create the ReportRequest object.
          $request = new Google_Service_AnalyticsReporting_ReportRequest();
          $request->setViewId($VIEW_ID);
          $request->setDateRanges($dateRange);
          $request->setMetrics(array($sessions));
          $request->setDimensions(array($country));
          $request->setOrderBys($ordering);

          $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
          $body->setReportRequests( array( $request) );
          return $analytics->reports->batchGet( $body );
        }

        function printResultsMediumD($reports) {
          for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
            $report = $reports[ $reportIndex ];
            $header = $report->getColumnHeader();
            $dimensionHeaders = $header->getDimensions();
            $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
            $rows = $report->getData()->getRows();

            for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
              $row = $rows[ $rowIndex ];
              $dimensions = $row->getDimensions();
              $metrics = $row->getMetrics();
              for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
                //print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
                global $mediumArray;
                $values = $metrics[$i]->getValues();
                for ($k = 0; $k < count($values); $k++) {
                  $mediumArray[$dimensions[$i]] = $values[$k];
                }

              }
            }
          }
        }

        function getReportLandingD($analytics) {
          global $analyticsViewID;
          $VIEW_ID = $analyticsViewID;

          // Create the DateRange object.
          $dateRange = new Google_Service_AnalyticsReporting_DateRange();
          global $startRange;
          global $endRange;
          $dateRange->setStartDate($startRange);
          $dateRange->setEndDate($endRange);

          // Create the Metrics object.
          $sessions = new Google_Service_AnalyticsReporting_Metric();
          $sessions->setExpression("ga:sessions");
          $sessions->setAlias("sessions");

          // Create IrderBy Object
          $ordering = new Google_Service_AnalyticsReporting_OrderBy();
          $ordering->setFieldName("ga:sessions");
          $ordering->setOrderType("VALUE");
          $ordering->setSortOrder("DESCENDING");

          // Create the Dimensions object.
          $country = new Google_Service_AnalyticsReporting_Dimension();
          $country->setName("ga:landingPagePath");

          // Create the ReportRequest object.
          $request = new Google_Service_AnalyticsReporting_ReportRequest();
          $request->setViewId($VIEW_ID);
          $request->setDateRanges($dateRange);
          $request->setMetrics(array($sessions));
          $request->setDimensions(array($country));
          $request->setOrderBys($ordering);

          $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
          $body->setReportRequests( array( $request) );
          return $analytics->reports->batchGet( $body );
        }

        function printResultsLandingD($reports) {
          for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
            $report = $reports[ $reportIndex ];
            $header = $report->getColumnHeader();
            $dimensionHeaders = $header->getDimensions();
            $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
            $rows = $report->getData()->getRows();

            for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
              $row = $rows[ $rowIndex ];
              $dimensions = $row->getDimensions();
              $metrics = $row->getMetrics();
              for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
                //print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
                global $landingArray;
                $values = $metrics[$i]->getValues();
                for ($k = 0; $k < count($values); $k++) {
                  $landingArray[$dimensions[$i]] = $values[$k];
                }

              }
            }
          }
        }

        function getReportCategoryD($analytics) {
          global $analyticsViewID;
          $VIEW_ID = $analyticsViewID;

          // Create the DateRange object.
          $dateRange = new Google_Service_AnalyticsReporting_DateRange();
          global $startRange;
          global $endRange;
          $dateRange->setStartDate($startRange);
          $dateRange->setEndDate($endRange);

          // Create the Metrics object.
          $sessions = new Google_Service_AnalyticsReporting_Metric();
          $sessions->setExpression("ga:users");
          $sessions->setAlias("users");

          // Create IrderBy Object
          $ordering = new Google_Service_AnalyticsReporting_OrderBy();
          $ordering->setFieldName("ga:users");
          $ordering->setOrderType("VALUE");
          $ordering->setSortOrder("DESCENDING");

          // Create the Dimensions object.
          $country = new Google_Service_AnalyticsReporting_Dimension();
          $country->setName("ga:interestOtherCategory");

          // Create the ReportRequest object.
          $request = new Google_Service_AnalyticsReporting_ReportRequest();
          $request->setViewId($VIEW_ID);
          $request->setDateRanges($dateRange);
          $request->setMetrics(array($sessions));
          $request->setDimensions(array($country));
          $request->setOrderBys($ordering);

          $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
          $body->setReportRequests( array( $request) );
          return $analytics->reports->batchGet( $body );
        }

        function printResultsCategoryD($reports) {
          for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
            $report = $reports[ $reportIndex ];
            $header = $report->getColumnHeader();
            $dimensionHeaders = $header->getDimensions();
            $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
            $rows = $report->getData()->getRows();

            for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
              $row = $rows[ $rowIndex ];
              $dimensions = $row->getDimensions();
              $metrics = $row->getMetrics();
              for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
                //print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
                global $categoryArray;
                $values = $metrics[$i]->getValues();
                for ($k = 0; $k < count($values); $k++) {
                  $categoryArray[$dimensions[$i]] = $values[$k];
                }

              }
            }
          }
        }

        echo "<script>var countries = {";
        $tempCount = 0;
        foreach($countryArray as $x => $x_value) {
            if ($tempCount < 10) {
              echo '"' . $x . '"' . ':"' . $x_value . '",';
              $tempCount++;
            }
        }
        echo '};</script>';

        echo "<script>var devices = {";
        $tempCount = 0;
        foreach($deviceArray as $x => $x_value) {
            if ($tempCount < 10) {
              echo '"' . $x . '"' . ':"' . $x_value . '",';
              $tempCount++;
            }
        }
        echo '};</script>';

      ?>

      <div class="row">
        <div class="col m6 s12">
          <div class="card">
            <div class="card-content">
              <span class="card-title">Session Analytics:</span>
              <div class="row">
                <div class="col m6 s12">
                  <div class="card">
                    <div class="card-content">
                      <span class="card-title">Sessions</span>
                      <h5><?php echo $analyticsValuesessions; ?></h5>
                    </div>
                  </div>
                </div>

                <div class="col m6 s12">
                  <div class="card">
                    <div class="card-content">
                      <span class="card-title">Avg. Session Duration</span>
                      <h5><?php echo round($analyticsValueavgDuration,2);?> Seconds</h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col m6 s12">
          <div class="card">
            <div class="card-content">
              <span class="card-title">User Analytics:</span>
              <div class="row">
                <div class="col m6 s12">
                  <div class="card">
                    <div class="card-content">
                      <span class="card-title">Total Users</span>
                      <h5><?php echo $analyticsValueusers; ?></h5>
                    </div>
                  </div>
                </div>

                <div class="col m6 s12">
                  <div class="card">
                    <div class="card-content">
                      <span class="card-title">New Users</span>
                      <h5><?php echo $analyticsValuenewUsers; ?></h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col m6 s12">
            <div class="card">
              <div class="card-content">
                <span class="card-title">Goal Analytics:</span>
                <div class="row">
                  <div class="col m6 s12">
                    <div class="card">
                      <div class="card-content">
                        <span class="card-title">Total Goal Completions</span>
                        <h5><?php echo round($analyticsValuegoalCompletion,2);?></h5>
                      </div>
                    </div>
                  </div>

                  <div class="col m6 s12">
                    <div class="card">
                      <div class="card-content">
                        <span class="card-title">Total Goal Value</span>
                        <h5>$<?php echo round($analyticsValuegoalValue,2);?></h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>

        <div class="col m6 s12">
          <div class="card">
            <div class="card-content">
              <span class="card-title">Miscellaneous Useful Analytics:</span>
              <div class="row">

                <div class="col m6 s12">
                  <div class="card">
                    <div class="card-content">
                      <span class="card-title">Bounce Rate</span>
                      <h5><?php echo round($analyticsValuebounceRate,2);?>%</h5>
                    </div>
                  </div>
                </div>

                <div class="col m6 s12">
                  <div class="card">
                    <div class="card-content">
                      <span class="card-title">Avg. Page Load Time</span>
                      <h5><?php echo round($analyticsValueavgPageLoad,2);?> Seconds</h5>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>


        </div>
      </div>

      <div class="row">
        <div class="col m6 s12">
          <div class="card">
            <div class="card-content">
              <span class="card-title">Top Countries by Sessions</span>
              <canvas id="countryChart"></canvas>
            </div>
          </div>
        </div>

        <div class="col m6 s12">
          <div class="card">
            <div class="card-content">
              <span class="card-title">Top Devices by Sessions</span>
              <canvas id="deviceChart"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col m6 s12">
          <div class="card">
            <div class="card-content">
              <span class="card-title">Top User Channels</span>
              <p>These are the ways in which users have come to your website. Note: "(none)" means they came to your website directly (perhaps by typing the URL into their browser).</p>
              <?php
                $tempCount = 0;
                echo "<table><thead><th>Medium</th><th>Number of Sessions</th></thead><tbody>";
                foreach($mediumArray as $x => $x_value) {
                    if ($tempCount < 7) {
                      echo '<tr><td>' . $x . '</td><td>' . $x_value . '</td></tr>';
                      $tempCount++;
                    }
                }
                echo "</tbody></table>";
              ?>
            </div>
          </div>
        </div>
        <div class="col m6 s12">
          <div class="card">
            <div class="card-content">
              <span class="card-title">First Landing Pages</span>
              <?php
                $tempCount = 0;
                echo "<table><thead><th>Landing Page</th><th>Number of Sessions</th></thead><tbody>";
                foreach($landingArray as $x => $x_value) {
                    if ($tempCount < 7) {
                      echo '<tr><td>' . $x . '</td><td>' . $x_value . '</td></tr>';
                      $tempCount++;
                    }
                }
                echo "</tbody></table>";
              ?>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col m6 s12">
          <div class="card">
            <div class="card-content">
              <span class="card-title">User Interest Category</span>
              <p>These are the categories that indicate that your users are more likely to be interested in learning about the specified category, and more likely to be ready to purchase.</p>
              <?php
                $tempCount = 0;
                echo "<table><thead><th>Interest Category</th><th>Number of Users</th></thead><tbody>";
                foreach($categoryArray as $x => $x_value) {
                    if ($tempCount < 7) {
                      echo '<tr><td>' . $x . '</td><td>' . $x_value . '</td></tr>';
                      $tempCount++;
                    }
                }
                echo "</tbody></table>";
              ?>
            </div>
          </div>
        </div>
      </div>

    </div>
    <?php include 'foot.php';?>
  </body>
</html>
