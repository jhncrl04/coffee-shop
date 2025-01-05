<?php
session_start();
session_destroy();

if (str_contains($_SERVER['HTTP_REFERER'], 'my-account.php')) {
  header('Location: index.php');
  exit;
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
