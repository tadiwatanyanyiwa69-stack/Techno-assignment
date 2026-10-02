<?php
$page_title='HIT Connect';
require_once __DIR__.'/includes/auth.php';
require_once __DIR__.'/includes/header.php';
?>
<section class="hero">
<h1>Connect. Share. Trade. Grow.</h1>
<p>A campus community platform for conversations, skills, buying and selling, and finding students with similar interests.</p>
<?php if(is_logged_in()): ?>
<a class="btn" href="/hit-connect/feed/index.php">Open your feed</a>
<?php else: ?>
<a class="btn" href="/hit-connect/register.php">Create your account</a>
<a class="btn btn-secondary" href="/hit-connect/login.php">Login</a>
<?php endif; ?>
</section>
<h2>Everything in one campus platform</h2>
<div class="grid">
<div class="card"><h3>🗣 Campus Feed</h3><p>Share updates, images, questions and ideas with the campus community.</p></div>
<div class="card"><h3>🛒 Marketplace</h3><p>List textbooks, electronics, clothes, equipment and other items for sale.</p></div>
<div class="card"><h3>🧠 Skills</h3><p>Show your skills and find students who can provide useful services.</p></div>
<div class="card"><h3>🤝 Campus Connect</h3><p>Find study, project, sports and hobby partners based on shared interests.</p></div>
<div class="card"><h3>💬 Messages</h3><p>Communicate privately with other registered users.</p></div>
<div class="card"><h3>⭐ Reviews</h3><p>Leave reviews for completed marketplace transactions and services.</p></div>
</div>
<?php require_once __DIR__.'/includes/footer.php'; ?>