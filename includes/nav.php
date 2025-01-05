<?php
$is_login = $_SESSION['is_login'] ?? false;
$user_first_name = $_SESSION['fname'] ?? '';
$user_profile = $_SESSION['profile'] ?? '';
?>

<?php if ($is_login): ?>
  <script>
    const url = new URL(window.location.href);
    url.searchParams.delete('login-status'); // Remove the 'login-status' parameter
    url.searchParams.delete('account-status'); // Remove the 'login-status' parameter
    window.history.replaceState(null, '', url); // Update the URL without reloading
  </script>
<?php endif; ?>

<nav>
  <a href="index.php" class="logo">COOL BEANS</a>
  <ul>
    <li>
      <a
        href="../index.php"
        class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?> nav-link">
        HOME
      </a>
    </li>
    <li>
      <a
        href="menu.php"
        class="<?php echo basename($_SERVER['PHP_SELF']) == 'menu.php' ? 'active' : ''; ?> nav-link">
        MENU
      </a>
    </li>
    <li>
      <a
        href="about.php"
        class="<?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?> nav-link">
        ABOUT US
      </a>
    </li>
    <!-- <li>
      <a
        href="contact.php"
        class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?> nav-link">
        CONTACT
      </a>
    </li> -->
  </ul>

  <span id="icon-container">

    <div class="dropdown" id="accountDropdown">
      <button id="dropdownBtn" class="dropbtn">
        <?php
        if (!$is_login) {
          echo "<span>Sign In</span>";
          echo '<i class="fa-regular fa-circle-user icon"></i>';
        } elseif ($is_login) {
          echo "<span>$user_first_name</span>";
          if ($user_profile) {
            echo "<img src='../uploads/$user_profile' class='profile'>";
          } else {
            echo '<i class="fa-regular fa-circle-user icon"></i>';
          }
        }
        ?>

      </button>

      <div id="myDropdown" class="dropdown-content">
        <?php
        if ($is_login) {
          echo "<script> 
                document.getElementById('myDropdown').innerHTML = `<a href='../pages/my-account.php'>My Account</a>
                <a href='signout.php'>Sign out</a>` 
              </script>";
        } else {
          echo "<script> document.getElementById('myDropdown').innerHTML = `<a id='login-btn'>Sign In</a>` </script>";
        }
        ?>
      </div>
    </div>

    <!-- <button><i class="fa-regular fa-magnifying-glass icon"></i></button> -->
    <button
      onClick="<?= $is_login ? 'openCart()' : 'show_modal(logInModal)' ?>">
      <i class="fa-regular fa-cart-shopping icon"></i>
    </button>
  </span>
</nav>