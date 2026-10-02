<?php
$page_title='Admin';
require_once __DIR__.'/../includes/auth.php'; require_login(); $user=current_user($pdo);
if($user['role']!=='admin') redirect('/hit-connect/index.php');
$users=$pdo->query("SELECT id,full_name,username,email,role,created_at FROM users ORDER BY created_at DESC")->fetchAll();
$products=$pdo->query("SELECT p.*,u.username FROM products p JOIN users u ON u.id=p.seller_id ORDER BY p.created_at DESC")->fetchAll();
$reports=$pdo->query("SELECT * FROM reports ORDER BY created_at DESC")->fetchAll();
require_once __DIR__.'/../includes/header.php'; ?>
<h2>Admin Dashboard</h2><div class="grid">
<div class="card"><h3>Users</h3><strong><?=count($users)?></strong></div>
<div class="card"><h3>Products</h3><strong><?=count($products)?></strong></div>
<div class="card"><h3>Reports</h3><strong><?=count($reports)?></strong></div></div>
<div class="card"><h3>Registered users</h3><?php foreach($users as $u): ?><p><strong><?=e($u['full_name'])?></strong> @<?=e($u['username'])?> — <?=e($u['email'])?></p><?php endforeach; ?></div>
<?php require_once __DIR__.'/../includes/footer.php'; ?>