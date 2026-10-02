<?php
$page_title='Register';
require_once __DIR__.'/includes/auth.php';
if(is_logged_in()) redirect('/hit-connect/index.php');
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name=trim($_POST['full_name']??''); $username=trim($_POST['username']??'');
    $email=trim($_POST['email']??''); $password=$_POST['password']??'';
    try{
        if($name===''||$username===''||$email===''||strlen($password)<8) throw new RuntimeException('Fill all fields. Password must be at least 8 characters.');
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)) throw new RuntimeException('Enter a valid email address.');
        $stmt=$pdo->prepare("SELECT id FROM users WHERE email=? OR username=?"); $stmt->execute([$email,$username]);
        if($stmt->fetch()) throw new RuntimeException('Email or username already exists.');
        $hash=password_hash($password,PASSWORD_DEFAULT);
        $stmt=$pdo->prepare("INSERT INTO users(full_name,username,email,password) VALUES(?,?,?,?)");
        $stmt->execute([$name,$username,$email,$hash]);
        flash('success','Account created. You can now log in.');
        redirect('/hit-connect/login.php');
    }catch(Throwable $e){ flash('error',$e->getMessage()); }
}
require_once __DIR__.'/includes/header.php'; ?>
<div class="card" style="max-width:600px;margin:auto"><h2>Create your account</h2>
<form method="post">
<div class="form-group"><label>Full name</label><input name="full_name" required></div>
<div class="form-group"><label>Username</label><input name="username" required></div>
<div class="form-group"><label>Email</label><input type="email" name="email" required></div>
<div class="form-group"><label>Password</label><input type="password" name="password" minlength="8" required></div>
<button class="btn">Register</button>
</form></div>
<?php require_once __DIR__.'/includes/footer.php'; ?>