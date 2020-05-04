// Initialize Materialize Scripts
$(document).ready(function(){
  $('.sidenav').sidenav();

  var currPage = document.location.pathname.match(/[^\/]+$/)[0];

  switch (currPage) {
    case 'index':
    case 'index.php':
      $(function(){
        updateUptimeCard();
      });
      break;
    case 'uptime':
    case 'uptime.php':
      $(function(){
        updateUptimeTable();
      });
      break;
    case 'analytics':
    case 'analytics.php':
      countryChart();
      deviceChart();
      break;
  }
});

function deviceChart() {
  var ctx = document.getElementById('deviceChart').getContext('2d');
  var deviceNames = [];
  var deviceValues = [];
  $.each(devices, function(name, value) {
    deviceNames.push(name);
    deviceValues.push(value);
  });
  var deviceChartDoughnut = new Chart(ctx, {
      type: 'doughnut',
      data: {
          labels: deviceNames,
          datasets: [{
              label: '',
              data: deviceValues,
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)',
                  'rgba(255, 99, 243, 0.2)',
                  'rgba(99, 241, 255, 0.2)',
                  'rgba(255, 207, 99, 0.2)',
                  'rgba(99, 111, 255, 0.2)'
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)',
                  'rgba(255, 99, 243, 1)',
                  'rgba(99, 241, 255, 1)',
                  'rgba(255, 207, 99, 1)',
                  'rgba(99, 111, 255, 1)'
              ],
              borderWidth: 1
          }]
      }
  });
}

function countryChart() {
  var ctx = document.getElementById('countryChart').getContext('2d');
  var countryNames = [];
  var countryValues = [];
  $.each(countries, function(name, value) {
    countryNames.push(name);
    countryValues.push(value);
  });
  var countryChartBar = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: countryNames,
          datasets: [{
              label: '',
              data: countryValues,
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)',
                  'rgba(255, 99, 243, 0.2)',
                  'rgba(99, 241, 255, 0.2)',
                  'rgba(255, 207, 99, 0.2)',
                  'rgba(99, 111, 255, 0.2)'
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)',
                  'rgba(255, 99, 243, 1)',
                  'rgba(99, 241, 255, 1)',
                  'rgba(255, 207, 99, 1)',
                  'rgba(99, 111, 255, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          },
          legend: {
            display: false
          }
      }
  });
}

function updateUptimeTable() {
  $.post("https://api.uptimerobot.com/v2/getMonitors",
  {
    api_key: getUptimeKey(),
    format: "json",
    custom_uptime_ratios: "1-7-30",
    response_times: 1
  },
  function(data){
    uptimeTableChanger(data);
  });
}

function uptimeTableChanger(data) {
  var avg1day = 0;
  var avg7day = 0;
  var avg30day = 0;
  for (var i = 0; i < (data.monitors).length; i++) {
    var custom_uptime = data.monitors[i].custom_uptime_ratio;
    avg1day += parseFloat(custom_uptime.split('-')[0]);
    avg7day += parseFloat(custom_uptime.split('-')[1]);
    avg30day += parseFloat(custom_uptime.split('-')[2]);
    var custom_uptime_7 = custom_uptime.split('-')[1];
    $('#monitor_table > tbody').append('<tr>');
    $('#monitor_table > tbody').append('<td>' + data.monitors[i].friendly_name + '</td>');
    $('#monitor_table > tbody').append('<td>' + data.monitors[i].url + '</td>');
    if (custom_uptime_7 == 100.000) {
      $('#monitor_table > tbody').append('<td class="green-text">' + (Math.round(custom_uptime_7 * 100) / 100) + '%</td>');
    } else if (custom_uptime_7 > 70) {
      $('#monitor_table > tbody').append('<td class="orange-text">' + (Math.round(custom_uptime_7 * 100) / 100) + '%</td>');
    } else {
      $('#monitor_table > tbody').append('<td class="red-text">' + (Math.round(custom_uptime_7 * 100) / 100) + '%</td>');
    }
    $('#monitor_table > tbody').append('<td>' + Math.round(data.monitors[i].average_response_time) + 'ms</td>');
    if (data.monitors[i].status == 2) {
      $('#monitor_table > tbody').append('<td class="green-text">Up</td>');
    } else if (data.monitors[i].status == 0) {
      $('#monitor_table > tbody').append('<td class="grey-text">Paused</td>');
    } else {
      $('#monitor_table > tbody').append('<td class="red-text">Down</td>');
    }
    $('#monitor_table > tbody').append('</tr>');
  }
  avg1day = (Math.round((avg1day/(data.monitors).length) * 100) / 100);
  avg7day = (Math.round((avg7day/(data.monitors).length) * 100) / 100);
  avg30day = (Math.round((avg30day/(data.monitors).length) * 100) / 100);
  $('#uptime1days > div > h5').text(avg1day + "%");
  $('#uptime7days > div > h5').text(avg7day + "%");
  $('#uptime30days > div > h5').text(avg30day + "%");
  if (avg1day == 100) {
    $('#uptime1days').attr('class', 'card green');
  } else if (avg1day > 70) {
    $('#uptime1days').attr('class', 'card orange');
  } else {
    $('#uptime1days').attr('class', 'card red');
  }
  if (avg7day == 100) {
    $('#uptime7days').attr('class', 'card green');
  } else if (avg7day > 70) {
    $('#uptime7days').attr('class', 'card orange');
  } else {
    $('#uptime7days').attr('class', 'card red');
  }
  if (avg30day == 100) {
    $('#uptime30days').attr('class', 'card green');
  } else if (avg30day > 70) {
    $('#uptime30days').attr('class', 'card orange');
  } else {
    $('#uptime30days').attr('class', 'card red');
  }
}

function uptimeCardSetter(data) {
  downMonitors = 0;
  for (var i = 0; i < (data.monitors).length; i++) {
    if (data.monitors[i].status != 2) {
      downMonitors++;
    }
  }
  if (downMonitors != 0) {
    $('#uptimecard').attr('class', 'card red');
    $('#uptimecard > .card-content > h5').text(downMonitors);
  }
}

function updateUptimeCard() {
  $.post("https://api.uptimerobot.com/v2/getMonitors",
  {
    api_key: getUptimeKey(),
    format: "json"
  },
  function(data){
    uptimeCardSetter(data);
  });
}
