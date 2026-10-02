<?php
$page_title='Marketplace';
require_once __DIR__.'/../includes/auth.php';
require_login();
$user=current_user($pdo);
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['title'])){
    try{
        $title=trim($_POST['title']);$desc=trim($_POST['description']);$price=(float)$_POST['price'];$cat=trim($_POST['category']);
        if($title===''||$price<0||$cat==='') throw new RuntimeException('Complete the listing fields.');
        $image=upload_image($_FILES['image']??[], 'products');
        $stmt=$pdo->prepare("INSERT INTO products(seller_id,title,description,price,category,image) VALUES(?,?,?,?,?,?)");
        $stmt->execute([$user['id'],$title,$desc,$price,$cat,$image]);
        flash('success','Product listed successfully.'); redirect('/hit-connect/marketplace/index.php');
    }catch(Throwable $e){flash('error',$e->getMessage());}
}
$q=trim($_GET['q']??'');
if($q!==''){ $stmt=$pdo->prepare("SELECT p.*,u.full_name,u.username FROM products p JOIN users u ON u.id=p.seller_id WHERE p.status='available' AND (p.title LIKE ? OR p.category LIKE ?) ORDER BY p.created_at DESC");$stmt->execute(["%$q%","%$q%"]); }
else {$stmt=$pdo->query("SELECT p.*,u.full_name,u.username FROM products p JOIN users u ON u.id=p.seller_id WHERE p.status='available' ORDER BY p.created_at DESC");}
$products=$stmt->fetchAll();
require_once __DIR__.'/../includes/header.php'; ?>
<div class="card"><h2>Marketplace</h2>
<form class="search"><input name="q" placeholder="Search products..." value="<?=e($q)?>"><button class="btn">Search</button></form>
<details><summary class="btn">Sell an item</summary><form method="post" enctype="multipart/form-data" style="margin-top:18px">
<div class="grid-2"><div class="form-group"><label>Product title</label><input name="title" required></div><div class="form-group"><label>Category</label><input name="category" placeholder="Books, Electronics..." required></div></div>
<div class="form-group"><label>Description</label><textarea name="description"></textarea></div>
<div class="grid-2"><div class="form-group"><label>Price</label><input type="number" name="price" step="0.01" min="0" required></div><div class="form-group"><label>Photo</label><input type="file" name="image" accept="image/*"></div></div>
<button class="btn">Publish listing</button></form></details></div>
<div class="product-grid">
<?php foreach($products as $p): ?><div class="product-card">
<?php if($p['image']): ?><img src="/hit-connect/<?=e($p['image'])?>" alt="<?=e($p['title'])?>"><?php else: ?><div style="height:210px;display:grid;place-items:center;background:#eef2f7">No image</div><?php endif; ?>
<div class="body"><span class="tag"><?=e($p['category'])?></span><h3><?=e($p['title'])?></h3><div class="price">$<?=number_format((float)$p['price'],2)?></div><p class="muted"><?=e($p['description'])?></p><a class="btn btn-small" href="/hit-connect/messages/index.php?to=<?=$p['seller_id']?>">Contact seller</a></div>
</div><?php endforeach; ?>
</div>
<?php require_once __DIR__.'/../includes/footer.php'; ?>