<?php

$is_login = $_SESSION['is_login'] ?? "";
$login_status = $_GET['login-status'] ?? "";
$account_status = $_GET['account-status'] ?? "";

// Redirect to the previous page with login modal
$referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';

if ($referer === 'mail.php') {
  $login_status = "";
}

// Parse the URL to check for query strings
$parsed_url = parse_url($referer);
parse_str($parsed_url['query'] ?? '', $query_params);

if (!$is_login && $login_status === 'fail') {
  // Remove 'login-status' if it exists
  unset($query_params['login-status']);

  // Rebuild the query string
  $new_query = http_build_query($query_params);

  // Construct the new URL
  $new_url = $parsed_url['scheme'] . '://' . $parsed_url['host'];
  if (isset($parsed_url['port'])) {
    $new_url .= ':' . $parsed_url['port'];
  }
  $new_url .= $parsed_url['path'];
  if (!empty($new_query)) {
    $new_url .= '?' . $new_query;
  }
}

?>

<dialog id="formContainer">
  <button id="closeLoginModal"><i class="fa-solid fa-xmark"></i></button>
  <div id="cardContainer">

    <!-- LOG IN CARD -->
    <form action="../database/user-authentication.php?action=login" method="POST" novalidate class="card" id="logInCard" name="logInCard">
      <input type="hidden" name="formType" value="login">
      <div class="inputContainer" id="loginInputContainer">
        <h1 class="formHeader">LOG IN</h1>
        <div id="failedLoginErrorMessage" class="error-message" style="<?php echo $login_status === 'fail' ? 'display:block' : 'display: none'; ?>">
          <h1>Wrong Credentials</h1>
          <p>Invalid email or password</p>
        </div>
        <div id="blockedAccountErrorMessage" class="error-message" style="<?php echo $account_status === 'blocked' ? 'display:block' : 'display: none'; ?>">
          <h1>Your account has been blocked</h1>
        </div>
        <input type="email" placeholder="Email" id="loginEmail" name="loginEmail" autofocus>
        <input type="password" placeholder="Password" required id="loginPassword" name="loginPassword">
        <span class="inline">
          <span>
            <button type="reset" id="forgotPassBtn">Forgot Password?</button>
          </span>
        </span>
        <button type="submit" id="logInBtn">LOG IN</button>
        <div class="line">
          <hr>
          <p>OR</p>
        </div>
        <button type="reset" id="goToSignUp" class="secondary-btn">SIGN UP</button>
      </div>
    </form>

    <!-- SIGN UP CARD -->
    <form action="../pages/mail.php" method="POST" novalidate class="card" id="signUpCard">
      <input type="hidden" name="formType" value="signup">
      <div class="inputContainer" id="signupInputContainer">
        <h1 class="formHeader">SIGN UP</h1>
        <span class="inline">
          <input type="text" placeholder="First Name" required="required" id="firstName" name="firstName">
          <input type="text" placeholder="Last Name" required="required" id="lastName" name="lastName">
        </span>

        <input type="email" placeholder="Email" required="required" id="email" name="email">

        <input type="password" placeholder="Password" required="required" id="password" name="password">
        <input type="password" placeholder="Confirm Password" required="required" id="confirmPassword" name="confirmPassword">

        <button type="submit" id="signUpBtn">SIGN UP</button>
        <div class="line">
          <hr>
          <p>OR</p>
        </div>
        <button type="reset" id="backToLogin" class="secondary-btn">RETURN TO LOG IN</button>
      </div>
    </form>
  </div>
</dialog>

<!-- forgot password modal -->
<?php
include '../pages/forgot-password.php';
include '../pages/reset-password.php'
?>