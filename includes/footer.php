<div class="footer">
  <div class="flexContainer">
    <div id="logoContainer">
      <img src="<?php echo $db_logo ?>" alt="">
    </div>
    <div class="container" id="footerLinks">
      <h2>PAGES</h2>
      <div class="container" id="footerLinkContainer">
        <a href="index.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="about.php">About Us</a>
        <!-- <a href="contact.php">Contact</a> -->
        <?php
        if ($is_login) {
          echo "<a href='signout.php'>Sign Out</a>";
        }
        ?>
      </div>
    </div>
    <div class="container" id="footerContactLinks">
      <h2>CONTACT</h2>
      <div class="container" id="footerContactContainer">
        <span>
          <i class="fa-light fa-location-dot icon"></i>
          <p>047 Brunei St., Binagbag, Angat, Bulacan, Philippines</p>
        </span>
        <span>
          <i class="fa-light fa-phone icon"></i>
          <p>+(63) 945-788-0606</p>
        </span>
        <span>
          <i class="fa-light fa-envelope icon"></i>
          <p>info.coolbeanscoffee@gmail.com</p>
        </span>
      </div>
    </div>
  </div>
  <hr>
  <p id="copyright">Copyright © 2024 Cool Beans Coffee. All Rights Reserved</p>
</div>