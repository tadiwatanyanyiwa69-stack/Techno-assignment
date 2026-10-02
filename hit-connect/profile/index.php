<?php
$page_title='Profile';
require_once __DIR__.'/../includes/auth.php'; require_login(); $user=current_user($pdo);
if($_SERVER['REQUEST_METHOD']==='POST'){
    try{
        $bio=trim($_POST['bio']??'');$image=upload_image($_FILES['profile_picture']??[],'profiles');
        if($image){$s=$pdo->prepare("UPDATE users SET bio=?,profile_picture=? WHERE id=?");$s->execute([$bio,$image,$user['id']]);}
        else{$s=$pdo->prepare("UPDATE users SET bio=? WHERE id=?");$s->execute([$bio,$user['id']]);}
        flash('success','Profile updated.');redirect('/hit-connect/profile/index.php');
    }catch(Throwable $e){flash('error',$e->getMessage());}
}
$user=current_user($pdo); require_once __DIR__.'/../includes/header.php'; ?>
<div class="profile-head">
<?php if($user['profile_picture']): ?><img class="profile-big" src="/hit-connect/<?=e($user['profile_picture'])?>" alt="Profile"><?php else: ?><div class="profile-big" style="display:grid;place-items:center;font-size:36px"><?=e(strtoupper(substr($user['full_name'],0,1)))?></div><?php endif; ?>
<div><h2><?=e($user['full_name'])?></h2><p class="muted">@<?=e($user['username'])?> · <?=e($user['email'])?></p><p><?=nl2br(e($user['bio']??''))?></p></div></div>
<div class="card"><h3>Edit profile</h3><form method="post" enctype="multipart/form-data"><div class="form-group"><label>Bio</label><textarea name="bio"><?=e($user['bio']??'')?></textarea></div><div class="form-group"><label>Profile picture</label><input type="file" name="profile_picture" accept="image/*"></div><button class="btn">Save</button></form></div>
<?php require_once __DIR__.'/../includes/footer.php'; ?>