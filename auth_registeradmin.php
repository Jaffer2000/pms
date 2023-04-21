<?php 

// initializing variables
$username = "";
$errors = 0; 

// connect to the database
include("config/db_config.php");

// REGISTER ADMIN
if (isset($_POST['reg_admin'])) {
	// receive all input values from the form
	$naam = mysqli_real_escape_string($conn, $_POST['naam']);
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$accounttype = mysqli_real_escape_string($conn, $_POST['accounttype']);
	$password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
	$password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);
  
	// form validation: ensure that the form is correctly filled ...
	// by adding (array_push()) corresponding error unto $errors array
	if (empty($username)) { array_push($errors, "Username is required"); }
	if (empty($password_1)) { array_push($errors, "Password is required"); }
	if ($password_1 != $password_2) {
        $errors = $errors + 1;
		echo'<div class="auth-status">';
		echo'<span class="status-type"><b>Whoopsie floepsie! </b><br> Wachtwoorden komen niet overeen.<br><br>';
		echo'<a href="registreren.php" class="authbutton">Opnieuw proberen</a></span>';
		echo'</div><br>';
	}
  
	// first check the database to make sure 
	// a user does not already exist with the same username and/or email
	$user_check_query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
	$result = mysqli_query($conn, $user_check_query);
	$user = mysqli_fetch_assoc($result);
	
	if ($user) { // if user exists
	  if ($user['username'] === $username) {
        $errors = $errors + 1;
		echo'<div class="auth-status">';
		echo'<span class="status-type"><b>Whoopsie floepsie! </b><br> Er bestaat al een account met deze gebruikersnaam.<br><br>';
		echo'<a href="registreren.php" class="authbutton">Opnieuw proberen</a></span>';
		echo'</div><br>';
	  }
	}
  
	// Finally, register user if there are no errors in the form
	if ($errors == 0) {
		$password = password_hash($password_1, PASSWORD_DEFAULT);
		//encrypt the password before saving in the database
		
		// $query = "INSERT INTO accounts (naam, username, email, accounttype, password)
		// OUTPUT inserted.naam, inserted.username, inserted.email, inserted.accounttype
		// INTO users
		// VALUES(1,'$naam'), (2, '$username'), (3, '$email'), (4, '$accounttype'), (5, '$password')
		// GO"
  
		$query = "INSERT INTO accounts (naam, username, email, accounttype, password) VALUES('$naam', '$username', '$email' , '$accounttype' , '$password')";
		$query2 = "INSERT INTO users (naam, username, email, accounttype, password) VALUES('$naam', '$username', '$email' , '$accounttype' , '$password')";

		mysqli_query($conn, $query);
		mysqli_query($conn, $query2);

        echo'<div class="auth-status">';
		echo'<span class="status-type"><b>Admin / beheerderaccount toegevoegd: </b><br> Let op! Bewaar de inloggegevens goed, Het wachtwoord kan niet gewijzigd worden!<br><br>';
		echo'<a href="registreren.php" class="authbutton">Terug naar het accountoverzicht</a></span>';
		echo'</div><br>';
	}
  }  

  ?>

<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Innovision Solutions</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="./style.css">

  <script src="https://kit.fontawesome.com/dd43f5ad90.js" crossorigin="anonymous"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com"> 
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
  <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400;700;800&display=swap" rel="stylesheet">
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>