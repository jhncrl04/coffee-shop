<?php
session_start();

$title = 'My Settings';

$email = $_SESSION['email'] ?? '';
$profile = $_SESSION['profile'] ?? '';
$first_name = $_SESSION['fname'] ?? '';
$last_name = $_SESSION['lname'] ?? '';
$contact = $_SESSION['contact'] ?? '';
$address = $_SESSION['user_address'] ?? '';
$is_login = $_SESSION['is_login'] ?? false;

if (!$is_login) {
  header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title><?= $title ?></title>

  <!-- FONT AWESOME ICONS -->
  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css">

  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-duotone-solid.css">

  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-thin.css">

  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-solid.css">

  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-regular.css">

  <link
    rel="stylesheet"
    href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-light.css">

  <link rel="stylesheet" href="https://atugatran.github.io/FontAwesome6Pro/css/all.min.css">

  <!-- MY CSS -->
  <link rel="stylesheet" href="../assets/css/main.css">
  <link rel="stylesheet" href="../assets/css/homepage.css">
  <link rel="stylesheet" href="../assets/css/userAuthentication.css">
  <link rel="stylesheet" href="../assets/css/footer.css">
  <link rel="stylesheet" href="../assets/css/accountVerificationModal.css">
  <link rel="stylesheet" href="../assets/css/myAccount.css">

  <?php require '../database/site-setting.php' ?>

  <!-- MY JAVASCRIPT -->
  <!-- <script src="../assets/js/form.js" defer></script>
  <script src="../assets/js/modal.js" defer></script>
  <script src="../assets/js/accountValidation.js" defer></script> -->
  <script src="../assets/js/dropdown.js" defer></script>
  <script src="../assets/js/editAccount.js" defer></script>

</head>


<body>
  <?php require '../includes/nav.php' ?>

  <div class="page-container">
    <div class="my-account-container">
      <div class="button-container">
        <h2>My Account</h2>
        <p>View and manage your account information</p>
      </div>
      <div class="button-container">
        <h2>My Orders</h2>
        <p>View your order history</p>
      </div>
      <div class="button-container">
        <h2>My Favorites</h2>
        <p>View all your list of favorites</p>
      </div>
    </div>
    <div class="container">

      <!-- Change profile -->
      <h1>My Account</h1>
      <form action="../database/upload-profile.php" enctype="multipart/form-data" method="POST" class="profile-container" id="uploadProfileForm">
        <img src='<?php
                  if (strlen($profile) !== 0) {
                    echo "../uploads/$profile";
                  } else {
                    echo "../assets/images/default-male-profile.jpg";
                  } ?>' alt="">
        <div class="wrapper">
          <span>
            <input type="file" id="profileUpload" name="profileUpload">
            <label for="profileUpload">Upload new photo</label>
          </span>
          <p>JPG or PNG is allowed</p>
        </div>
      </form>

      <div class="view-container">

        <!-- Change personal infos form -->
        <form action="../database/user-authentication.php?action=update-user-info" novalidate method="POST" class="edit-account-form" id="editPersonalInfoForm">
          <button type="button" class="accordion-header">
            PERSONAL INFO
            <i class="fa-solid fa-caret-down"></i>
          </button>
          <div class="input-wrapper accordion-content">
            <div class='message-container' id="personalInfoMessageContainer">
              <p class="message" id="personalInfoMessage">Required fields are marked by *</p>
            </div>
            <div class="inline input">
              <div class="wrapper">
                <label>First Name *</label>
                <input type="text" name="firstName" id="firstName" class="edit-info-input" value='<?php echo $first_name ?>' placeholder="N/A" readonly>
              </div>
              <div class="wrapper">
                <label>Last Name *</label>
                <input type="text" name="lastName" id="lastName" class="edit-info-input" value='<?php echo $last_name ?>' placeholder="N/A" readonly>
              </div>
            </div>
            <div class="wrapper">
              <label>Contact</label>
              <input type="text" name="contact" id="contact" class="edit-info-input" value='<?php echo $contact ?>' placeholder="N/A" readonly>
            </div>
            <div class="wrapper">
              <label>Address</label>
              <input type="text" name="address" id="address" class="edit-info-input" value='<?php echo $address ?>' placeholder="N/A" readonly>
            </div>
            <div class="inline button">
              <button id="editPersonalInfoBtn" class="main-btn" type="reset">EDIT</button>
              <button id="saveChangeBtn" class="secondary-btn accordion-save-btn" type="button">SAVE</button>
            </div>
            <dialog id="infoConfirmModal">
              <div>
                <h2>Confirm changes</h2>
                <p>Do you want to save your changes?</p>
              </div>
              <div class="inline">
                <button type="submit" class="main-btn">Yes</button>
                <button type="button" id="closeInfoConfirmModalBtn" class="secondary-btn">No</button>
              </div>
            </dialog>
          </div>
        </form>

        <!-- Change email form -->
        <form action="../database/user-authentication.php?action=update-email" novalidate method="POST" class="edit-account-form" id="editEmailForm">
          <button type="button" class="accordion-header">
            EMAIL
            <i class="fa-solid fa-caret-down"></i>
          </button>
          <div class="input-wrapper accordion-content">
            <div class='message-container' id="emailMessageContainer">
              <p class="message" id="emailMessage">Required fields are marked by *</p>
            </div>
            <input type="hidden" value='<?php echo $email ?>' name="oldEmail" id="oldEmail">
            <div class="wrapper">
              <label>Email *</label>
              <input type="email" name="email" id="email" class="edit-email-input" value='<?php echo $email ?>' placeholder="N/A" readonly>
            </div>
            <div class="wrapper edit-confirm-password">
              <p>Enter password to save change</p>
              <input type="password" name="password" id="password" class="edit-email-input" placeholder="Password">
            </div>
            <div class="inline button">
              <button id="editEmailBtn" class="main-btn" type="reset">EDIT</button>
              <button id="saveEmailChangeBtn" class="secondary-btn accordion-save-btn" type="submit">SAVE</button>
            </div>
          </div>
        </form>


        <!-- Change Password Form -->
        <form action="../database/user-authentication.php?action=edit-password" novalidate method="POST" class="edit-password-form" id="editPasswordForm">
          <button type="button" class="accordion-header">
            PASSWORD
            <i class="fa-solid fa-caret-down"></i>
          </button>
          <div class="input-wrapper accordion-content">
            <div class='message-container' id="passwordMessageContainer">
              <p class="message" id="passwordMessage">Required fields are marked by *</p>
            </div>
            <div class="wrapper">
              <label>Old Password *</label>
              <input type="password" name="old_password" id="old_password" class="edit-password-input" placeholder="Old Password" readonly>
            </div>
            <div class="wrapper edit-wrapper">
              <label>New Password</label>
              <input type="password" name="new_password" id="new_password" class="edit-password-input" placeholder="New Password" readonly>
            </div>
            <div class="wrapper edit-wrapper">
              <label>Confirm New Password</label>
              <input type="password" name="confirm_new_password" id="confirm_new_password" class="edit-password-input" placeholder="New Password" readonly>
            </div>
            <div class="inline button">
              <button id="editPasswordBtn" class="main-btn" type="button">EDIT</button>
              <button id="savePasswordChangeBtn" class="secondary-btn accordion-save-btn" type="submit">SAVE</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php
  // require '../includes/footer.php';
  // require '../includes/auth.php';
  ?>
</body>

</html>