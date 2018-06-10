<?php

class Account    {
    private $con;
    private $errorArray = [];

    public function __construct($con){
        $this->con = $con;
        //$this->errorArray = array();
    }

    public function register($username,$firstname,$lastname,$email,$confirmEmail,$password,$confirmPassword){
        $this->validateUsername($username);
        $this->validateFirstName($firstname);
        $this->validateLastName($lastname);
        $this->validateEmails($email,$confirmEmail);
        $this->validatePasswords($password,$confirmPassword);

        if(empty($this->errorArray)) {
            //Insert into db
           return $this->insertUserDetails($username,$firstname,$lastname,$email,$password);
        }else {
            return false;
        }
    }

    public function login($username,$password){
        $encryptedPassword = md5($password);

        try {
            $query = "SELECT * FROM users WHERE username = :username and password = :encryptedPassword " ;
            $statement = $this->con->prepare($query);
            $statement->execute(array(":username" =>$username,":encryptedPassword" => $encryptedPassword));
            if($statement->rowCount()>0){
                return true;
            }else{
                array_push($this->errorArray,Constants::$loginFailed);
                return false;
            }

        }catch(PDOException $ex){
            echo "An error occured ".$ex->getMessage();
        }

    }


    public function getError($error) {
        if(!in_array($error,$this->errorArray)) {
            $error = "";
        }
        return "<span class='errorMessage'>$error</span>";
    }


    private function insertUserDetails($username,$firstname,$lastname,$email,$password) {

       $encryptedPassword = md5($password);
       $profile_pic = "assets/images/profile_pics/head_emerald.png";
       $dateAdded = date("Y-m-d");

        try {
            $query = "INSERT INTO users(username,firstname,lastname,email,password,signUpDate,profilePic)  VALUES (:username,:firstname,:lastname,:email,:encryptedPassword,:dateAdded,:profile_pic) " ;
            $statement = $this->con->prepare($query);
            $statement->execute(array(":username" =>$username,":firstname" => $firstname,":lastname" => $lastname,":email" => $email,":encryptedPassword" => $encryptedPassword, ":dateAdded" => $dateAdded, ":profile_pic" => $profile_pic));
            if($statement->rowCount()>0){
                return true;
            }else{
                return false;
            }

        }catch(PDOException $ex){
            echo "An error occured ".$ex->getMessage();
        }


    }


     private function validateUsername($username) {

        if(strlen($username) > 25 || strlen($username) < 5) {
          array_push($this->errorArray,Constants::$usernameValidate);
          return;
        }

         try {
             $query = "SELECT username from users WHERE username = :username" ;
             $statement = $this->con->prepare($query);
             $statement->execute(array(":username" =>$username));
             if($statement->rowCount()>0){
                 array_push($this->errorArray,Constants::$usernameTaken);
                 return;
             }

         }catch(PDOException $ex){
             echo "An error occured ".$ex->getMessage();
         }



    }

    private function validateFirstName($firstname) {

        if(strlen($firstname) > 25 || strlen($firstname) < 2) {
            array_push($this->errorArray,Constants::$firstNameValidate);
            return;
        }

    }

    private function validateLastName($lastname) {

        if(strlen($lastname) > 25 || strlen($lastname) < 2) {
            array_push($this->errorArray,Constants::$lastNameValidate);
            return;
        }

    }

    private function validateEmails($email,$confirmEmail) {

            if($email != $confirmEmail) {
                array_push($this->errorArray,Constants::$emailsDoNotMatch);
                return;
            }

            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                array_push($this->errorArray,Constants::$emailNotValid);
                return;
            }

        try {
            $query = "SELECT email from users WHERE email = :email" ;
            $statement = $this->con->prepare($query);
            $statement->execute(array(":email" =>$email));
            if($statement->rowCount()>0){
                array_push($this->errorArray,Constants::$emailTaken);
                return;
             }

        }catch(PDOException $ex){
            echo "An error occured ".$ex->getMessage();
        }



    }

    private function validatePasswords($password,$confirmPassword) {

        if($password != $confirmPassword){
            array_push($this->errorArray,Constants::$passwordsDoNotMatch);
            return;
        }

        if(preg_match("/[^A-Za-z0-9]/",$password)) {
            array_push($this->errorArray,Constants::$passwordNotAlphaNumeric);
            return;
        }

        if(strlen($password) > 30 || strlen($password) < 5) {
            array_push($this->errorArray,Constants::$passwordLength);
            return;
        }

    }

}

