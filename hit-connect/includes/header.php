<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/functions.php';
$user = current_user($pdo);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($page_title ?? 'HIT Connect') ?></title>
<link rel="stylesheet" href="/hit-connect/assets/css/style.css">
</head>
<body>
<header class="topbar">
  <a class="brand" href="/hit-connect/index.php">HIT<span>Connect</span></a>
  <nav>
    <a href="/hit-connect/feed/index.php">Feed</a>
    <a href="/hit-connect/marketplace/index.php">Market</a>
    <a href="/hit-connect/skills/index.php">Skills</a>
    <a href="/hit-connect/connect/index.php">Connect</a>
    <?php if ($user): ?>
      <a href="/hit-connect/messages/index.php">Messages</a>
      <a href="/hit-connect/profile/index.php">Profile</a>
      <?php if ($user['role'] === 'admin'): ?><a href="/hit-connect/admin/index.php">Admin</a><?php endif; ?>
      <a class="btn btn-small" href="/hit-connect/logout.php">Logout</a>
    <?php else: ?>
      <a href="/hit-connect/login.php">Login</a>
      <a class="btn btn-small" href="/hit-connect/register.php">Join</a>
    <?php endif; ?>
  </nav>
</header>
<main class="container">
<?php show_flash(); ?>
