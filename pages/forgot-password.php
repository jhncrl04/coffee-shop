<link rel="stylesheet" href="../assets/css/forgotPass.css">
<dialog id="forgotPassContainer" class="forgot-pass-modal">
  <form action="./forgotPasswordMailer.php" method="POST" class="card" id="forgotPassword">
    <div>
      <h1>Forgot Password?</h1>
      <p>Please input your email address.</p>
    </div>
    <input type="email" placeholder="Email" required="required" name="forgotPassEmail" id="forgotPassEmail">

    <div class="button-container">
      <button type="submit" id="recoverAccountBtn" class="main-btn">CONFIRM</button>
      <hr>
      <button type="reset" id="logInRedirectBtn" class="secondary-btn">CANCEL</button>
    </div>
  </form>
</dialog>