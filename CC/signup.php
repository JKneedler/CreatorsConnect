<?php

  session_start();

  if($_SESSION){
    header("Location: profile.php");
  }

  if(array_key_exists('email', $_POST) OR array_key_exists('password', $_POST)){
    if(mysqli_connect_error()){
      die("There was an error connecting to the database.");
    }

    if($_POST['email'] == ''){
      echo "<p>Email address is required.</p>";
    } else if($_POST['password'] == ''){
      echo "<p>Password is required.</p>";
    } else {
      $query = "SELECT `id` FROM `Users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
      $result = mysqli_query($link, $query);
      if(mysqli_num_rows($result) > 0){
        if($_POST['signUp'] == '1'){
          echo "<p>Email is already registered.</p>";
        } else {
          $query = "SELECT * FROM `Users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
          $result = mysqli_query($link, $query);
          $userData = mysqli_fetch_array($result);
          if($_POST['password'] == $userData['password']){
            $_SESSION['email'] = $userData['email'];
            header("Location: index.php");
            exit;
          } else {
            echo "<p>Incorrect Password.</p>";
          }
        }
      } else {
        if($_POST['signUp'] == '1'){
          $query = "INSERT INTO `Users` (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, $_POST['password'])."')";
          if(mysqli_query($link, $query)){
            $_SESSION['email'] = $_POST['email'];
            header("Location: index.php");
            exit;
          } else {
            echo "<p>There was a problem signing you up, please try again later.</p>";
          }
        } else {
          echo "<p>Incorrect email or password.</p>";
        }
      }
    }
  }

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="Style/signUpStyle.css" />

    <title>Get Started</title>
  </head>
  <body>
    <div class="container">
      <div class="card bg-light" id="logInForm">
        <div class="card-body" id="logInCard">
          <h5 class="card-title">Log In</h5>
          <form method="post">
            <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input name="password" type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <div class="form-group" id="buttonGroup">
              <button type="submit" class="btn btn-primary" id="logInButton">Log In</button>
              <small id="signUpChange" class="form-text text-muted">Don't have an account yet?</small>
              <button type="button" class="btn btn-outline-secondary btn-sm" id="signUpToggle">Sign Up</button>
            </div>
          </form>
        </div>
      </div>

      <div class="card bg-light" id="signUpForm">
        <div class="card-body" id="signUpCard">
          <h5 class="card-title">Sign Up</h5>
          <form method="post">
            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <label for="email">First Name</label>
                  <input name="firstName" type="text" class="form-control" id="firstName" placeholder="First">
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label for="email">Last Name</label>
                  <input name="lastName" type="text" class="form-control" id="lastName" placeholder="Last">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input name="email" type="email" class="form-control" id="emailSignUp" aria-describedby="emailHelp" placeholder="Enter email">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input name="password" type="password" class="form-control" id="passwordSignUp" placeholder="Password">
            </div>
            <div class="form-group" id="buttonGroupSignUp">
              <button type="submit" class="btn btn-primary" id="signUpButton">Sign Up</button>
              <small id="logInChange" class="form-text text-muted">Already have an account?</small>
              <button type="button" class="btn btn-outline-secondary btn-sm" id="logInToggle">Log In</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

    <script type="text/javascript">

      $(document).ready(function() {
        $("#signUpToggle").click(function() {
            $("#signUpForm").toggle();
            $("#logInForm").toggle();
        });

        $("#logInToggle").click(function() {
            $("#signUpForm").toggle();
            $("#logInForm").toggle();
        });
      });

    </script>
  </body>
</html>
