<?php


function sanitizeFormPassword($formInput) {
    return strip_tags($formInput);
}

//removing the html tags,replacing empty spaces with nothing,first letter  uppercase on previously lowered letters of string
function sanitizeFormString($formInput) {
    $formOutput = strip_tags(str_replace(" ","",$formInput));
    return ucfirst(strtolower($formOutput));
}

//removing the html tags,replacing empty spaces with nothing
function sanitizeFormUsername($formInput) {
    return strip_tags(str_replace(" ","",$formInput));
}




if(isset($_POST['registerButton'])) {
    $username = sanitizeFormUsername($_POST['username']);
    $firstname = sanitizeFormString($_POST['firstname']);
    $lastname = sanitizeFormString($_POST['lastname']);
    $email = sanitizeFormString($_POST['email']);
    $confirmEmail = sanitizeFormString($_POST['confirmEmail']);
    $password = sanitizeFormPassword($_POST['password']);
    $confirmPassword =  sanitizeFormPassword($_POST['confirmPassword']);


  $wasSuccessfull = $account->register($username,$firstname,$lastname,$email,$confirmEmail,$password,$confirmPassword);

  if($wasSuccessfull){
      $_SESSION['userLoggedIn'] = $username;
      header("Location:index.php");
  }



}

?>
