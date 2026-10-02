<?php
$page_title='Messages';
require_once __DIR__.'/../includes/auth.php'; require_login(); $user=current_user($pdo);
$to=(int)($_GET['to']??0);
if($_SERVER['REQUEST_METHOD']==='POST' && $to){
    $body=trim($_POST['body']??'');
    if($body!==''){$s=$pdo->prepare("INSERT INTO messages(sender_id,receiver_id,body) VALUES(?,?,?)");$s->execute([$user['id'],$to,$body]);}
    redirect('/hit-connect/messages/index.php?to='.$to);
}
$people=$pdo->prepare("SELECT id,full_name,username FROM users WHERE id<>? ORDER BY full_name");$people->execute([$user['id']]);$people=$people->fetchAll();
require_once __DIR__.'/../includes/header.php'; ?>
<div class="grid-2"><div class="card"><h3>People</h3><?php foreach($people as $p): ?><p><a href="?to=<?=$p['id']?>"><strong><?=e($p['full_name'])?></strong><br><span class="muted">@<?=e($p['username'])?></span></a></p><?php endforeach; ?></div>
<div class="card"><?php if($to):
$s=$pdo->prepare("SELECT * FROM users WHERE id=?");$s->execute([$to]);$other=$s->fetch();
if(!$other){echo '<p>User not found.</p>';}else{
echo '<h3>Chat with '.e($other['full_name']).'</h3><div class="chat-box">';
$m=$pdo->prepare("SELECT * FROM messages WHERE (sender_id=? AND receiver_id=?) OR (sender_id=? AND receiver_id=?) ORDER BY created_at ASC");$m->execute([$user['id'],$to,$to,$user['id']]);
foreach($m as $msg) echo '<div class="message '.($msg['sender_id']==$user['id']?'mine':'').'">'.nl2br(e($msg['body'])).'<div class="muted" style="font-size:11px">'.e($msg['created_at']).'</div></div>';
echo '</div><form method="post" style="margin-top:12px"><div class="form-group"><textarea name="body" placeholder="Write a message..." required></textarea></div><button class="btn">Send</button></form>';
}
else: ?><div class="empty">Select a person to start a conversation.</div><?php endif; ?></div></div>
<?php require_once __DIR__.'/../includes/footer.php'; ?>