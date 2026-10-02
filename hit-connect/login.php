<?php
$page_title='Login';
require_once __DIR__.'/includes/auth.php';
if(is_logged_in()) redirect('/hit-connect/index.php');
if($_SERVER['REQUEST_METHOD']==='POST'){
    $email=trim($_POST['email']??''); $password=$_POST['password']??'';
    $stmt=$pdo->prepare("SELECT * FROM users WHERE email=?"); $stmt->execute([$email]); $user=$stmt->fetch();
    if($user && password_verify($password,$user['password'])){
        session_regenerate_id(true); $_SESSION['user_id']=$user['id']; redirect('/hit-connect/feed/index.php');
    }
    flash('error','Incorrect email or password.');
}
require_once __DIR__.'/includes/header.php'; ?>
<div class="card" style="max-width:500px;margin:auto"><h2>Login</h2>
<form method="post">
<div class="form-group"><label>Email</label><input type="email" name="email" required></div>
<div class="form-group"><label>Password</label><input type="password" name="password" required></div>
<button class="btn">Login</button>
</form></div>
<?php require_once __DIR__.'/includes/footer.php'; ?>