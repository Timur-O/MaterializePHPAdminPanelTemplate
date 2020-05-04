<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php include 'head.php';?>
    <title>Manage Users - Admin Panel</title>
  </head>
  <body>
    <!-- Include the Nav into the page -->
    <?php include 'nav.php';?>
    <div class="main">
      <!-- Button to show/hide menu -->
      <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
      
      <div class="row rowtoppadded2">
        <div class="borderedbox col s10 offset-s1">
          <form class="col s12">
            <div class="row">
              <div class="input-field col s9 offset-s1">
                <input id="icon_prefix2" placeholder="Search users..." class="validate"></input>
              </div>
            </div>
            
            <div class="row">
              <div class="col s10 offset-s1">
                <label>Search by...</label>
              </div>
              <div class="col s10 offset-s1">
                  <label class="padright">
                    <input name="searchoptions" type="radio" checked />
                    <span>Name</span>
                  </label>
                  <label class="padright">
                    <input name="searchoptions" type="radio" />
                    <span>Email</span>
                  </label>
                  <label class="padright">
                    <input name="searchoptions" type="radio"  />
                    <span>ClientID</span>
                  </label>
              </div>
            </div>
            
            <div class="row">            
              <button class="btn waves-effect waves-light col s2 offset-s5" type="submit" name="action">Search
                <i class="material-icons right">search</i>
              </button>
            </div>
          </form>
        </div>
        
      </div>
      
      <div class="row">
        
      </div>
      
      <div class="row respon-table">
        <table id="userstable" class="col s10 offset-s1 centered">
          <thead>
            <th>Name</th>
            <th>Email</th>
            <th>Date Joined</th>
            <th>Number of Posts</th>
            <th>Actions</th>
          </thead>
          <tbody>
            <tr>
              <td>John Doe</td>
              <td>john.doe@gmail.com</td>
              <td>30/02/2018</td>
              <td>372</td>
              <td>
                <a class="waves-effect waves-light btn red"><i class="material-icons left">delete_forever</i>Suspend</a>
                <a class="waves-effect waves-light btn amber"><i class="material-icons left">access_time</i>View Activity</a>
                <a class="waves-effect waves-light btn"><i class="material-icons left">more_vert</i>More</a>
              </td>
            </tr>
            <tr>
              <td>John Doe</td>
              <td>john.doe@gmail.com</td>
              <td>30/02/2018</td>
              <td>372</td>
              <td>
                <a class="waves-effect waves-light btn red"><i class="material-icons left">delete_forever</i>Suspend</a>
                <a class="waves-effect waves-light btn amber"><i class="material-icons left">access_time</i>View Activity</a>
                <a class="waves-effect waves-light btn"><i class="material-icons left">more_vert</i>More</a>
              </td>
            </tr>
            <tr>
              <td>John Doe</td>
              <td>john.doe@gmail.com</td>
              <td>30/02/2018</td>
              <td>372</td>
              <td>
                <a class="waves-effect waves-light btn red"><i class="material-icons left">delete_forever</i>Suspend</a>
                <a class="waves-effect waves-light btn amber"><i class="material-icons left">access_time</i>View Activity</a>
                <a class="waves-effect waves-light btn"><i class="material-icons left">more_vert</i>More</a>
              </td>
            </tr>
            <tr>
              <td>John Doe</td>
              <td>john.doe@gmail.com</td>
              <td>30/02/2018</td>
              <td>372</td>
              <td>
                <a class="waves-effect waves-light btn red"><i class="material-icons left">delete_forever</i>Suspend</a>
                <a class="waves-effect waves-light btn amber"><i class="material-icons left">access_time</i>View Activity</a>
                <a class="waves-effect waves-light btn"><i class="material-icons left">more_vert</i>More</a>
              </td>
            </tr>
            <tr>
              <td>John Doe</td>
              <td>john.doe@gmail.com</td>
              <td>30/02/2018</td>
              <td>372</td>
              <td>
                <a class="waves-effect waves-light btn red"><i class="material-icons left">delete_forever</i>Suspend</a>
                <a class="waves-effect waves-light btn amber"><i class="material-icons left">access_time</i>View Activity</a>
                <a class="waves-effect waves-light btn"><i class="material-icons left">more_vert</i>More</a>
              </td>
            </tr>
            <tr>
              <td>John Doe</td>
              <td>john.doe@gmail.com</td>
              <td>30/02/2018</td>
              <td>372</td>
              <td>
                <a class="waves-effect waves-light btn red"><i class="material-icons left">delete_forever</i>Suspend</a>
                <a class="waves-effect waves-light btn amber"><i class="material-icons left">access_time</i>View Activity</a>
                <a class="waves-effect waves-light btn"><i class="material-icons left">more_vert</i>More</a>
              </td>
            </tr>
            <tr>
              <td>John Doe</td>
              <td>john.doe@gmail.com</td>
              <td>30/02/2018</td>
              <td>372</td>
              <td>
                <a class="waves-effect waves-light btn red"><i class="material-icons left">delete_forever</i>Suspend</a>
                <a class="waves-effect waves-light btn amber"><i class="material-icons left">access_time</i>View Activity</a>
                <a class="waves-effect waves-light btn"><i class="material-icons left">more_vert</i>More</a>
              </td>
            </tr>
            <tr>
              <td>John Doe</td>
              <td>john.doe@gmail.com</td>
              <td>30/02/2018</td>
              <td>372</td>
              <td>
                <a class="waves-effect waves-light btn red"><i class="material-icons left">delete_forever</i>Suspend</a>
                <a class="waves-effect waves-light btn amber"><i class="material-icons left">access_time</i>View Activity</a>
                <a class="waves-effect waves-light btn"><i class="material-icons left">more_vert</i>More</a>
              </td>
            </tr>
            <tr>
              <td>John Doe</td>
              <td>john.doe@gmail.com</td>
              <td>30/02/2018</td>
              <td>372</td>
              <td>
                <a class="waves-effect waves-light btn red"><i class="material-icons left">delete_forever</i>Suspend</a>
                <a class="waves-effect waves-light btn amber"><i class="material-icons left">access_time</i>View Activity</a>
                <a class="waves-effect waves-light btn"><i class="material-icons left">more_vert</i>More</a>
              </td>
            </tr>
            <tr>
              <td>John Doe</td>
              <td>john.doe@gmail.com</td>
              <td>30/02/2018</td>
              <td>372</td>
              <td>
                <a class="waves-effect waves-light btn red"><i class="material-icons left">delete_forever</i>Suspend</a>
                <a class="waves-effect waves-light btn amber"><i class="material-icons left">access_time</i>View Activity</a>
                <a class="waves-effect waves-light btn"><i class="material-icons left">more_vert</i>More</a>
              </td>
            </tr>
            <tr class="paginator">
              <td colspan="5" class="center">
                <ul class="pagination">
                  <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
                  <li class="active"><a href="#!">1</a></li>
                  <li class="waves-effect"><a href="#!">2</a></li>
                  <li class="waves-effect"><a href="#!">3</a></li>
                  <li class="waves-effect"><a href="#!">4</a></li>
                  <li class="waves-effect"><a href="#!">5</a></li>
                  <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
                </ul>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      
    </div>
    <?php include 'foot.php';?>
  </body>
</html>
