<?php
session_start();

$title = 'My Settings';

$email = $_SESSION['email'] ?? '';
$profile = $_SESSION['profile'] ?? '';
$first_name = $_SESSION['fname'] ?? '';
$last_name = $_SESSION['lname'] ?? '';
$gender = $_SESSION['gender'] ?? '';
$contact = $_SESSION['contact'] ?? '';
$address = $_SESSION['user_address'] ?? '';
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

  <!-- MY JAVASCRIPT -->
  <script src="../assets/js/form.js" defer></script>
  <script src="../assets/js/modal.js" defer></script>
  <script src="../assets/js/accountValidation.js" defer></script>
  <script src="../assets/js/dropdown.js" defer></script>

  <style>
    .page-container {
      width: 100%;
      min-height: 80vh;
      height: fit-content;
      display: flex;
      align-items: center;
      justify-content: space-evenly;
    }

    .my-account-container {
      min-width: 60rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: baseline;
      gap: 2rem;
    }

    .my-account-container h1 {
      font-size: 3rem;
      font-weight: 500;
    }

    .my-account-container div {
      width: 100%;
      background: var(--secondary-bg);
      border: 0.2rem solid var(--border);
      border-radius: 1rem;
      padding: 2rem;
      transition: all 200ms ease-in;
    }

    .my-account-container div:hover {
      box-shadow: 0 0 3rem 0 var(--shadow);
    }

    .my-account-container div h2 {
      font-size: 2.4rem;
      font-weight: 500;
    }

    .my-account-container div p {
      font-size: 1.6rem;
      color: var(--secondary-text);
    }

    .view-container {
      width: 80rem;
      display: flex;
      flex-direction: column;
      align-items: center;

      padding: 5rem;
      border: 0.2rem solid var(--border);
      box-shadow: 1.5rem 1.5rem 3rem -1rem var(--shadow);
      border-radius: 1rem;
      background: linear-gradient(to bottom,
          var(--error) 15rem,
          var(--secondary-bg) 15rem);
    }

    .view-container img {
      border: 1rem solid var(--secondary-bg);
      border-radius: 100%;
      width: 20rem;
      height: 20rem;
    }

    input[type="text"].edit-info-input,
    input[type="email"].edit-info-input {
      padding: 0;
      font-size: 1.8rem;
      letter-spacing: 0.2rem;
      border-radius: 0;
      border: none;
      border-bottom: 0.2rem solid var(--accent);
      outline: none;
    }

    .view-container form .inline {
      gap: 3rem;
    }

    .view-container form {
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }

    .view-container .wrapper {
      display: flex;
      flex-direction: column;
    }

    .view-container .wrapper label {
      font-size: 1.4rem;
      font-weight: 600;
    }
  </style>

</head>


<body>
  <?php require '../includes/nav.php' ?>

  <div class="page-container">
    <div class="my-account-container">
      <h1>My Account</h1>
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
      <!-- <div>
        <h2>Account Settings</h2>
        <p>Manage and keep your account updated</p>
      </div> -->
    </div>
    <div class="view-container">
      <img src="../uploads/profile.jpg" alt="">

      <form action="../database/user-authentication.php" method="POST" class="edit-account-form" id="editAccountForm">
        <div class="inline">
          <div class="wrapper">
            <label>First Name</label>
            <input type="text" name="firstName" id="firstName" class="edit-info-input" value='<?php echo strlen($first_name) !== 0 ? $first_name : 'N/A' ?>' readonly>
          </div>
          <div class="wrapper">
            <label>Last Name</label>
            <input type="text" name="lastName" id="lastName" class="edit-info-input" value='<?php echo strlen($last_name) !== 0 ? $last_name : 'N/A' ?>' readonly>
          </div>
        </div>
        <div class="wrapper">
          <label>Email</label>
          <input type="email" name="email" id="email" class="edit-info-input" value='<?php echo strlen($email) !== 0 ? $email : 'N/A' ?>' readonly>
        </div>
        <div class="wrapper">
          <label>Contact</label>
          <input type="text" name="contact" id="contact" class="edit-info-input" value='<?php echo strlen($contact) !== 0 ? $contact : 'N/A' ?>' readonly>
        </div>
        <div class="wrapper">
          <label>Address</label>
          <input type="text" name="address" id="address" class="edit-info-input" value='<?php echo strlen($address) !== 0 ? $address : 'N/A' ?>' readonly>
        </div>
      </form>
    </div>
  </div>

  <?php
  // require '../includes/footer.php';
  require '../includes/auth.php';
  ?>
</body>

</html>