<?php
require_once __DIR__.'/../includes/auth.php'; require_login(); $user=current_user($pdo);
if($_SERVER['REQUEST_METHOD']!=='POST') redirect('/hit-connect/profile/index.php');
$reviewed=(int)($_POST['reviewed_user_id']??0);$rating=(int)($_POST['rating']??0);$comment=trim($_POST['comment']??'');
if($reviewed && $reviewed!==$user['id'] && $rating>=1 && $rating<=5){
  $s=$pdo->prepare("INSERT INTO reviews(reviewer_id,reviewed_user_id,rating,comment) VALUES(?,?,?,?)");
  $s->execute([$user['id'],$reviewed,$rating,$comment]); flash('success','Review submitted.');
}
redirect('/hit-connect/profile/index.php');
?>