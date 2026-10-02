<?php
declare(strict_types=1);

function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function redirect(string $url): never {
    header("Location: $url");
    exit;
}

function is_logged_in(): bool {
    return isset($_SESSION['user_id']);
}

function require_login(): void {
    if (!is_logged_in()) redirect('/hit-connect/login.php');
}

function current_user(PDO $pdo): ?array {
    if (!is_logged_in()) return null;
    static $user = null;
    if ($user === null) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch() ?: null;
    }
    return $user;
}

function flash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function show_flash(): void {
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        echo '<div class="alert '.e($f['type']).'">'.e($f['message']).'</div>';
        unset($_SESSION['flash']);
    }
}

function upload_image(array $file, string $folder, int $maxBytes = 5242880): ?string {
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) return null;
    if ($file['error'] !== UPLOAD_ERR_OK) throw new RuntimeException('Image upload failed.');
    if ($file['size'] > $maxBytes) throw new RuntimeException('Image is too large. Maximum is 5 MB.');
    $allowed = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    if (!isset($allowed[$mime])) throw new RuntimeException('Only JPG, PNG and WebP images are allowed.');
    $name = bin2hex(random_bytes(16)).'.'.$allowed[$mime];
    $root = dirname(__DIR__);
    $destination = $root.'/uploads/'.$folder.'/'.$name;
    if (!move_uploaded_file($file['tmp_name'], $destination)) throw new RuntimeException('Could not save image.');
    return 'uploads/'.$folder.'/'.$name;
}
?>