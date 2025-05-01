<?php

namespace App;

class Authenticate
{
  public function isAuth(): bool
  {
    return isset($_SESSION['userID']);
  }

  public function redirectIfNotAuth()
  {
    if (!$this->isAuth()) {
      header('location:SignIn.php');
    }
  }

  public function redirectIfAuth()
  {
    if ($this->isAuth()) {
      header('location:index.php');
    }
  }

  public function signUp()
  {
    if (isset($_POST["signUpBtn"])) {
      // var_dump($_POST);


      $username = $_POST["username"];
      $email = $_POST["email"];
      $password = $_POST["password"];
      $confirmPassword = $_POST['confirm_password'];

      if ($password != $confirmPassword) {
        Alert::PrintMessage("Confirm Password Not Matched", "Danger");
      } else {
        $myDatabaseObj = new DB();
        $insertStatement = "INSERT INTO `user` VALUES(NULL,?,?,?)";
        $queryObj = $myDatabaseObj->Connection->prepare($insertStatement);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $queryObj->bind_param('sss', $username, $email, $hashedPassword);
        $querySatus = $queryObj->execute();
        if ($querySatus) {
          header('location:SignIn.php?doneSignUp=1');
        } else {
          Alert::PrintMessage("Failed to create your account", 'Danger');
        }
      }
    }
  }

  public function signIn()
  {
    if (isset($_POST['logInBtn'])) {
      $email = $_POST['email'];
      $password = $_POST['password'];
      $myDBObject = new DB();
      $selectStatement = 'SELECT * FROM `user` WHERE email = ? ';

      // Todo: You have objects here
      // myDBObject -> DB
      // Connection -> mysqli
      // queryStmtObject -> mysqli_stmt
      // resultObj -> mysqli_result

      // check if user exists in the database
      $queryStmtObject = $myDBObject->Connection->prepare($selectStatement);
      $queryStmtObject->bind_param('s', $email);
      $queryStatus = $queryStmtObject->execute();
      if (!$queryStatus) {
        Alert::PrintMessage("Something went wrong", "Danger");
      } else {

        $resultObj = $queryStmtObject->get_result();
        // echo "<pre>";
        // var_dump($resultObj);

        if ($resultObj->num_rows == 1) {
          $userArr = $resultObj->fetch_assoc(); // user record array 
          // verify password
          if (password_verify($password, $userArr['password'])) {
            // Authenticated User
            $_SESSION['userID'] = $userArr['id'];
            $_SESSION['userName'] = $userArr['name'];

            Alert::PrintMessage("Welcome back, " . $userArr['name'], "Normal");
          } else {
            Alert::PrintMessage("Incorrect Password", "Danger");
          }
        } else {
          Alert::PrintMessage("User not found", "Danger");
        }
      }
    }
  }

  public function logOut()
  {

    if (isset($_GET['logout'])) {
      session_unset();
      session_destroy();

      header('location:signIn.php');
    }
  }
}
