<?php
include ("includes/config.php");
include ("includes/classes/Db.php");
include("includes/classes/Constants.php");
include("includes/classes/Account.php");
$con = Db::getConnection();
$account = new Account($con);
include("includes/handlers/register-handler.php");
include("includes/handlers/login-handler.php");


function getInputValue($value) {
if(isset($_POST[$value])) {
    echo $_POST[$value];
}
}
?>
<html>
<head>
	<title>Welcome to Slotify!</title>
</head>
<body>

	<div id="inputContainer">
		<form id="loginForm" action="register.php" method="POST">
			<h2>Login to your account</h2>
			<p>
                <?php echo $account->getError(Constants::$loginFailed) ?>
				<label for="loginUsername">Username</label>
				<input id="loginUsername" name="loginUsername" type="text" placeholder="e.g. bartSimpson" required>
			</p>
			<p>
				<label for="loginPassword">Password</label>
				<input id="loginPassword" name="loginPassword" type="password" placeholder="Your password" required>
			</p>

			<button type="submit" name="loginButton">LOG IN</button>
			
		</form>

        <form id="registerForm" action="register.php" method="POST">
            <h2>Create your free account</h2>
            <p>
                <?php echo $account->getError(Constants::$usernameValidate) ?>
                <?php echo $account->getError(Constants::$usernameTaken) ?>
                <label for="username">Username</label>
                <input id="username" name="username" type="text" placeholder="e.g. bartSimpson" value="<?php getInputValue('username')   ?> " required>
            </p>

            <p>
                <?php echo $account->getError(Constants::$firstNameValidate) ?>
                <label for="firstname">First Name</label>
                <input id="firstname" name="firstname" type="text" placeholder="e.g. Bart" value="<?php getInputValue('firstname')     ?> " required>
            </p>

            <p>
                <?php echo $account->getError(Constants::$lastNameValidate) ?>
                <label for="lastname">Last Name</label>
                <input id="lastname" name="lastname" type="text" placeholder="e.g. Simpson" value="<?php getInputValue('lastname')   ?> " required>
            </p>


            <p>
                <?php echo $account->getError(Constants::$emailsDoNotMatch) ?>
                <?php echo $account->getError(Constants::$emailNotValid) ?>
                <?php echo $account->getError(Constants::$emailTaken) ?>
                <label for="email">Email</label>
                <input id="email" name="email" type="email" placeholder="e.g. bart@mail.com" value="<?php getInputValue('email')   ?> " required>
            </p>


            <p>
                <label for="confirmEmail">Confirm email</label>
                <input id="confirmEmail" name="confirmEmail" type="text" placeholder="e.g. bart@mail.com" value="<?php getInputValue('confirmEmail')   ?> " required>
            </p>




            <p>
                <?php echo $account->getError(Constants::$passwordsDoNotMatch) ?>
                <?php echo $account->getError(Constants::$passwordNotAlphaNumeric) ?>
                <?php echo $account->getError(Constants::$passwordLength) ?>

                <label for="password">Password</label>
                <input id="password" name="password" type="password" placeholder="Your password" required>
            </p>

            <p>
                <label for="confirmPassword">Confirm password</label>
                <input id="confirmPassword" name="confirmPassword" type="password" placeholder="Your password" required>
            </p>

            <button type="submit" name="registerButton">Sign Up</button>

        </form>


	</div>

</body>
</html>