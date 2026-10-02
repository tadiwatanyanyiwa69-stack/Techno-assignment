<?php
$page_title='Feed';
require_once __DIR__.'/../includes/auth.php';
require_login();
$user=current_user($pdo);
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['body'])){
    try{
        $body=trim($_POST['body']); if($body==='') throw new RuntimeException('Write something first.');
        $image=upload_image($_FILES['image']??[], 'posts');
        $stmt=$pdo->prepare("INSERT INTO posts(user_id,body,image) VALUES(?,?,?)"); $stmt->execute([$user['id'],$body,$image]);
        redirect('/hit-connect/feed/index.php');
    }catch(Throwable $e){flash('error',$e->getMessage());}
}
if(isset($_GET['like'])){
    $post=(int)$_GET['like'];
    $stmt=$pdo->prepare("SELECT id FROM likes WHERE post_id=? AND user_id=?");$stmt->execute([$post,$user['id']]);
    if($stmt->fetch()){ $pdo->prepare("DELETE FROM likes WHERE post_id=? AND user_id=?")->execute([$post,$user['id']]); }
    else {$pdo->prepare("INSERT INTO likes(post_id,user_id) VALUES(?,?)")->execute([$post,$user['id']]);}
    redirect('/hit-connect/feed/index.php');
}
$stmt=$pdo->query("SELECT p.*,u.username,u.full_name,u.profile_picture,(SELECT COUNT(*) FROM likes l WHERE l.post_id=p.id) likes_count,(SELECT COUNT(*) FROM comments c WHERE c.post_id=p.id) comments_count FROM posts p JOIN users u ON u.id=p.user_id ORDER BY p.created_at DESC");
$posts=$stmt->fetchAll();
require_once __DIR__.'/../includes/header.php'; ?>
<div class="card"><h2>Campus Feed</h2>
<form method="post" enctype="multipart/form-data">
<div class="form-group"><textarea name="body" placeholder="What's happening on campus?" required></textarea></div>
<div class="form-group"><input type="file" name="image" accept="image/jpeg,image/png,image/webp"></div>
<button class="btn">Post</button>
</form></div>
<?php foreach($posts as $p): ?>
<article class="post">
<div class="post-head"><div class="avatar"><?=e(strtoupper(substr($p['full_name'],0,1)))?></div><div><strong><?=e($p['full_name'])?></strong><div class="muted">@<?=e($p['username'])?> · <?=e($p['created_at'])?></div></div></div>
<p><?=nl2br(e($p['body']))?></p>
<?php if($p['image']): ?><img src="/hit-connect/<?=e($p['image'])?>" alt="Post image"><?php endif; ?>
<div class="actions"><a class="btn btn-secondary" href="?like=<?=$p['id']?>">♥ <?=$p['likes_count']?></a><span class="muted"><?=$p['comments_count']?> comments</span></div>
</article>
<?php endforeach; ?>
<?php require_once __DIR__.'/../includes/footer.php'; ?>