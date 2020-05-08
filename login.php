<?php
  include_once 'include/bootstrap.php';
  include_once 'include/config.php';


?>


<!DOCTYPE html>
<html>
  <head>
    <script type="text/javascript" src="javascript/chart.js"></script>
    <link rel="stylesheet" href="css/login.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body>
    <div id="wrapper">

      <div id="main-contain">
      <center>
        <div id="login-contain">
          <div id="login-header">
            <img id="login-img-logo" src="img/logo.png">
          </div>
          <div id="login-title">
            <h1>User Login</h1>
          </div>
          <div id="login-body">
            <form action="sub/login/cek_user.php" method="POST">
              <table>
                <thead></thead>
                <tbody>
                  <tr>
                    <td>Username</td>
                    <td><input type="text" name="username"></td>
                  </tr>
                  <tr>
                    <td>Password</td>
                    <td><input type="password" name="password"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td><input type="submit" name="submit" value="Login"></td>
                  </tr>
                </tbody>
              </table>
            </form>
          </div>
        </div>
      </center>  
      </div>

    </div>

  </body>
</html>