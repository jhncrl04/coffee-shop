<?php
session_start();

require '../database/category-list.php';
require '../database/product.php';
require '../database/slider.php';

$first_name = $_SESSION['fname'] ?? "";
$last_name = $_SESSION['lname'] ?? "";
$email = $_SESSION['email'] ?? "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

  <link rel="stylesheet" href="../assets/css/main.css">
  <link rel="stylesheet" href="../assets/css/adminSettings.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <?php require '../database/site-setting.php' ?>

  <script src="../assets/js/editProfileAdmin.js" defer></script>
  <script src="../assets/js/resetSiteSetting.js" defer></script>
  <script src="../assets/js/adminModal.js" defer></script>

  <title>Document</title>
</head>

<body>
  <?php include '../includes/admin_nav.php'; ?>
  <div class="main-container">
    <h1>Settings</h1>
    <div class="section-container">

      <h2>Account Settings</h2>
      <div class="account-setting-container">
        <form action="../database/upload-profile.php" enctype="multipart/form-data" method="POST" class="profile-pic-container" id="uploadProfileForm">
          <?php echo "<img src='../uploads/$user_profile' alt=''>" ?>
          <p>JPG or PNG are allowed</p>
          <input type="file" id="profileUpload" name="profileUpload">
          <label for="profileUpload" class="input-file-label">Change Profile</label>
        </form>
        <div class="input-container">
          <form action="../database/user-authentication.php?action=update-admin-info" method="POST" class="basic-info-container">
            <h3>Account Information</h3>
            <div class="inline">
              <div class="input-wrapper">
                <label for="firstName">First Name*</label>
                <input type="text" id="firstName" name="firstName" value="<?php echo $first_name ?>">
              </div>
              <div class="input-wrapper">
                <label for="lastName">Last Name*</label>
                <input type="text" id="lastName" name="lastName" value="<?php echo $last_name ?>">
              </div>
            </div>
            <div class="input-wrapper">
              <label for="email">Email*</label>
              <input type="email" id="email" name="email" value="<?php echo $email ?>">
            </div>
            <button type="submit">Save Changes</button>
          </form>
          <hr>
          <button id="changePasswordBtn">Change Password</button>
          <form action="../database/user-authentication.php?action=update-admin-password" method="POST" class="password-input-container" id="adminChangePass">
            <div class="inline">
              <div class="input-wrapper password">
                <label for="new-password">New Password*</label>
                <input type="password" id="new-password" name="new-password">
              </div>
              <div class="input-wrapper password">
                <label for="confirm-new-password">Confirm Password*</label>
                <input type="password" id="confirm-new-password" name="confirm-new-password">
              </div>
            </div>
            <button type="submit">Save Password</button>
          </form>
        </div>
      </div>
    </div>
    <h2>Site Settings</h2>
    <div class="site-setting-container">
      <h3>Modify UI</h3>
      <div class="color-setting">
        <form action="../database/site-setting.php" method="POST" class="input-wrapper color">
          <div class="inline">
            <input type="color" id="mainBg" name="mainBg" value="<?php echo $db_bg_color ?>">
            <div class="label-container">
              <label for="mainBg">Background</label>
              <div class="inline">
                <button type="reset" class="main-btn" onclick="resetBgColor()">Reset</button>
                <button type="submit" class="secondary-btn">Save</button>
              </div>
            </div>
          </div>
        </form>
        <form action="../database/site-setting.php" method="POST" class="input-wrapper color">
          <div class="inline">
            <input type="color" id="fontColor" name="fontColor" value="<?php echo $db_font_color ?>">
            <div class="label-container">
              <label for="fontColor">Font</label>
              <div class="inline">
                <button type="reset" class="main-btn" onclick="resetFontColor()">Reset</button>
                <button type="submit" class="secondary-btn">Save</button>
              </div>
            </div>
          </div>
        </form>
        <form action="../database/site-setting.php" method="POST" class="input-wrapper color">
          <div class="inline">
            <input type="color" id="accentColor" name="accentColor" value="<?php echo $db_accent_color ?>">
            <div class="label-container">
              <label for="accentColor">Accent</label>
              <div class="inline">
                <button type="reset" class="main-btn" onclick="resetAccentColor()">Reset</button>
                <button type="submit" class="secondary-btn">Save</button>
              </div>
            </div>
          </div>
        </form>
        <form action="../database/site-setting.php" enctype="multipart/form-data" method="POST" class="input-wrapper color">
          <div class="inline">
            <label for="logo">
              <img src="<?php echo $db_logo ?>" alt="" id="logoPreview">
            </label>
            <input type="file" id="logo" name="logo">
            <div class="label-container">
              <label for="logo">Logo</label>
              <div class="inline">
                <button type="reset" class="main-btn" onclick="resetLogo()">Reset</button>
                <button type="submit" class="secondary-btn">Save</button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="slider-setting-container">
        <h3>Slider Settings</h3>
        <div class="slider-setting">
          <?php loadSlider() ?>
        </div>
        <div class="inline button-wrapper">
          <button id="add-slider-item" onclick="show_modal(addSliderModal)">Add Slider</button>
          <button id="edit-slider-item" onclick="show_modal(editSliderModal)">Edit Slider</button>
          <button id="delete-slider-item" onclick="show_modal(deleteSliderModal)">Delete Slider</button>
        </div>
      </div>
    </div>
  </div>
  </div>

  <?php include_once '../includes/sliderModal.php' ?>
</body>

</html>