<?php
$page_title='Skills';
require_once __DIR__.'/../includes/auth.php'; require_login(); $user=current_user($pdo);
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name=trim($_POST['skill_name']);$desc=trim($_POST['description']);$avail=trim($_POST['availability']);
    if($name===''){flash('error','Enter a skill name.');}else{$s=$pdo->prepare("INSERT INTO skills(user_id,skill_name,description,availability) VALUES(?,?,?,?)");$s->execute([$user['id'],$name,$desc,$avail]);flash('success','Skill added.');redirect('/hit-connect/skills/index.php');}
}
$q=trim($_GET['q']??'');
if($q){$s=$pdo->prepare("SELECT s.*,u.full_name,u.username,u.profile_picture FROM skills s JOIN users u ON u.id=s.user_id WHERE s.skill_name LIKE ? ORDER BY s.created_at DESC");$s->execute(["%$q%"]);}else{$s=$pdo->query("SELECT s.*,u.full_name,u.username,u.profile_picture FROM skills s JOIN users u ON u.id=s.user_id ORDER BY s.created_at DESC");}
$skills=$s->fetchAll(); require_once __DIR__.'/../includes/header.php'; ?>
<div class="card"><h2>Skill Sharing</h2><form class="search"><input name="q" value="<?=e($q)?>" placeholder="Find a skill..."><button class="btn">Search</button></form>
<details><summary class="btn">Share your skill</summary><form method="post" style="margin-top:18px"><div class="form-group"><label>Skill</label><input name="skill_name" placeholder="Coding, tutoring, design..." required></div><div class="form-group"><label>Description</label><textarea name="description"></textarea></div><div class="form-group"><label>Availability</label><input name="availability" placeholder="Weekends, evenings..."></div><button class="btn">Add skill</button></form></details></div>
<?php foreach($skills as $s): ?><div class="card"><div class="post-head"><div class="avatar"><?=e(strtoupper(substr($s['full_name'],0,1)))?></div><div><h3 style="margin:0"><?=e($s['skill_name'])?></h3><span class="muted">by <?=e($s['full_name'])?> · <?=e($s['availability'])?></span></div></div><p><?=nl2br(e($s['description']))?></p><a class="btn btn-small" href="/hit-connect/messages/index.php?to=<?=$s['user_id']?>">Contact</a></div><?php endforeach; ?>
<?php require_once __DIR__.'/../includes/footer.php'; ?>