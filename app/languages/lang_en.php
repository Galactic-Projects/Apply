<?php
// LOGIN
define("LOGIN_ERROR", "Your E-Mail or Password is invalid!");
define("LOGIN_SUCCESS", "Login successful! You will be headed to <a href='account.php'>Account</a>.");
define("LOGIN_NOT_VERIFIED","Your Account isn't verified, please check your emails!");
// REGISTER
define("ERROR_EMAIL_INVALID", "Please enter a valid email!");
define("REGISTER_ERROR_EMAIL_ALREADY", "Email already exists!");
define("REGISTER_ERROR_USERNAME_ALREADY", "Username already exists!");
define("REGISTER_ERROR_USERNAME_EMPTY", "Username can't be empty!");
define("REGISTER_ERROR_PASSWORD_ENTER", "Enter a password!");
define("REGISTER_ERROR_PASSWORD_MATCH", "Passwords don't match!");
define("REGISTER_ERROR_SAVE", "There was an error saving your data! Try again later...");
define("REGISTER_NO_MAIL", "There is no mail.php file. <a href='important'>Activate Account</a>");
define("REGISTER_SUCCESS", "Register successful! You will be headed to <a href='login.php'>Login</a>.");
// LOGOUT
define("LOGOUT_SUCCESS", "Logout successful!");
// FORGET
define("FORGET_ERROR_USER_EXISTS", "No User was found!");
define("FORGET_SUCCESS_RESET_EMAIL", "We have sent you a link to reset your password.");
define("FORGET_NO_MAIL", "There is no mail.php file. <a href='important'>Forget Password</a>");
// RESET
define("RESET_ERROR_ID", "Invalid id!");
define("RESET_ERROR_INVALID", "Invalid code!");
define("RESET_ERROR_SAME", "Your old password can't be the new one!");
define("RESET_ERROR_EXPIRED", "Your code is expired! <a href='forget.php'>Send new code</a>");
define("RESET_SUCCESS_PASSWORD", "Your password has been reset!");
// SET
define("CODE_ERROR_ENABLEID", "Invalid id for enable your account!");
define("CODE_ERROR_ENABLED_ALREADY", "Your account is already enabled!");
define("CODE_ERROR_INVALID", "Invalid code!");
define("CODE_SUCCESS_ENABLED", "Your account has been enabled!");
// GENERAL
define("BUTTON_SEND", "SEND");
define("PLACEHOLDER_EMAIL", "Email-Address");
define("PLACEHOLDER_USERNAME", "Username");
define("PLACEHOLDER_PASSWORD", "Password");
define("PLACEHOLDER_REPEAT_PASSWORD", "Repeat password");
// NAVBAR
define("NAVBAR_HOME", "HOME");
define("NAVBAR_APPLY", "APPLY");
define("NAVBAR_ACCOUNT", "ACCOUNT");
define("NAVBAR_ADMIN", "ADMINISTRATOR");
// ACCOUNT
define("ACCOUNT_PROFILE_LOGOUT", "Logout");
define("ACCOUNT_PROFILE_IMAGE_BUTTON", "Upload");
define("ACCOUNT_PROFILE_IMAGE_ERROR_SIZE", "File is to big (Max. 100MB)!");
// ADMINISTRATION
define("ADMIN_ERROR_PERMISSION", "You have no permission to enter this panel!<br> <a href='/index.php'>Go back!</a>");
// SELECTION
// MANAGEMENT TITLE
define("DASHBOARD", "Dashboard");
define("USER_APPLICATION", "Self Application");
define("USER_SETTINGS", "Profile");
define("SERVER_APPLICATIONS", "User Applications");
define("SERVER_SETTINGS", "Application Settings");
define("", "");
define("", "");
define("", "");
define("", "");
define("", "");
// TITLE
define("TITLE_HOME", "Home :: Apply - Galactic Projects");
define("TITLE_APPLY", "Apply :: Apply - Galactic Projects");
define("TITLE_ACCOUNT", "Account :: Apply - Galactic Projects");
define("TITLE_ADMIN", "Admin :: Apply - Galactic Projects");
define("TITLE_REGISTER", "Register :: Apply - Galactic Projects");
define("TITLE_LOGIN", "Login :: Apply - Galactic Projects");
define("TITLE_SET", "Set password :: Apply - Galactic Projects");
define("TITLE_RESET", "Reset password :: Apply - Galactic Projects");
define("TITLE_FORGET", "Forget password :: Apply - Galactic Projects");
?>