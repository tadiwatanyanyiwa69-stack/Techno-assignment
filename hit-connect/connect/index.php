<?php
$page_title='Campus Connect';
require_once __DIR__.'/../includes/auth.php'; require_login(); $user=current_user($pdo);
$q=trim($_GET['q']??'');
if($q){$s=$pdo->prepare("SELECT * FROM users WHERE id<>? AND (full_name LIKE ? OR username LIKE ? OR bio LIKE ?) ORDER BY created_at DESC");$s->execute([$user['id'],"%$q%","%$q%","%$q%"]);}else{$s=$pdo->prepare("SELECT * FROM users WHERE id<>? ORDER BY created_at DESC");$s->execute([$user['id']]);}
$users=$s->fetchAll(); require_once __DIR__.'/../includes/header.php'; ?>
<div class="card"><h2>Campus Connect</h2><p class="muted">Find students with shared interests for study groups, projects, sports and hobbies.</p><form class="search"><input name="q" value="<?=e($q)?>" placeholder="Search people or interests..."><button class="btn">Search</button></form></div>
<div class="grid"><?php foreach($users as $u): ?><div class="card">
<?php if($u['profile_picture']): ?><img class="profile-big" src="/hit-connect/<?=e($u['profile_picture'])?>" alt="Profile"><?php else: ?><div class="profile-big" style="display:grid;place-items:center"><?=e(strtoupper(substr($u['full_name'],0,1)))?></div><?php endif; ?>
<h3><?=e($u['full_name'])?></h3><p class="muted">@<?=e($u['username'])?></p><p><?=nl2br(e($u['bio']??''))?></p><a class="btn btn-small" href="/hit-connect/messages/index.php?to=<?=$u['id']?>">Message</a>
</div><?php endforeach; ?></div>
<?php require_once __DIR__.'/../includes/footer.php'; ?>