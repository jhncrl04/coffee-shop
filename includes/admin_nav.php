<?php
$user_first_name = $_SESSION['fname'] ?? '';
$user_profile = $_SESSION['profile'] ?? '';
$user_role = $_SESSION['user_role'];
$is_login = $_SESSION['is_login'] ?? false;
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];
$fullname = "$fname $lname";

if ($user_role !== 'admin') {
  header("Location: index.php");
} ?>

<?php if ($is_login): ?>
  <script>
    const url = new URL(window.location.href);
    url.searchParams.delete('login-status'); // Remove the 'login-status' parameter
    url.searchParams.delete('account-status'); // Remove the 'login-status' parameter
    window.history.replaceState(null, '', url); // Update the URL without reloading
  </script>
<?php endif; ?>

<nav id="adminNav">
  <div class="prof-name-container">
    <?php
    if ($is_login) {
      if ($user_profile) {
        echo "<img src='../uploads/$user_profile' class='profile'>";
      } else {
        echo '<i class="fa-regular fa-circle-user icon"></i>';
      }
      echo "<p>$fullname</p>";
    } else {
      header('Location: index.php');
    }
    ?>
  </div>
  <ul>
    <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
      <div></div><a href="dashboard.php">Dashboard</a>
    </li>
    <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'orders.php' ? 'active' : ''; ?>">
      <div></div><a href="orders.php">Orders</a>
    </li>
    <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'customers.php' ? 'active' : ''; ?>">
      <div></div><a href="customers.php">Customers</a>
    </li>
    <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'admin-product.php' ? 'active' : ''; ?>">
      <div></div><a href="admin-product.php">Products</a>
    </li>
    <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'admin-inventory.php' ? 'active' : ''; ?>">
      <div></div><a href="admin-inventory.php">Inventory</a>
    </li>
    <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'admin-pos.php' ? 'active' : ''; ?>">
      <div></div><a href="admin-pos.php">Point of Sale</a>
    </li>
    <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'admin-settings.php' ? 'active' : ''; ?>">
      <div></div><a href="admin-settings.php">Settings</a>
    </li>
    <li>
      <div></div><a href="signout.php">Sign Out</a>
    </li>
  </ul>

  <a href="" id="printReports">Print Reports</a>
</nav>