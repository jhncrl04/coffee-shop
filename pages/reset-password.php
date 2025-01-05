<?php
$email = $_GET['email'] ?? '';
$action = $_GET['action'] ?? '';
?>

<link rel="stylesheet" href="../assets/css/forgotPass.css">
<?php require '../database/site-setting.php' ?>

<dialog id="resetPassContainer" class="forgot-pass-modal">
  <!-- <div id="loginErrorMessage">
        <h1>INVALID PASSWORD</h1>
        <p>Password must be al least 6 characters.</p>
        <p>Password and confirm password must match.</p>
      </div> -->
  <form action="../database/user-authentication.php?action=reset-password&email=<?php echo $email; ?>" method="POST" class="card" id="resetPassword">
    <div>
      <h1>Change Password</h1>
      <p>Create new password below to change your password.</p>
    </div>
    <input type="password" placeholder="New Password" required="required" name="newPassword" id="newPassword">
    <input type="password" placeholder="Re-enter New Password" required="required" name="confirmNewPassword" id="confirmNewPassword">

    <div class="button-container">
      <button type="submit" id="resetPassBtn" class="main-btn">RESET PASSWORD</button>
      <hr>
      <button type="reset" id="resetPassBackToLogin" class="secondary-btn">CANCEL</button>
    </div>
  </form>
</dialog>

<?php
if ($action === 'reset-password') {
  echo "
  <script>
    const  resetPassModal = document.getElementById('resetPassContainer')
    resetPassModal.showModal();  
  </script>";
}
?>