<?php
$db = __DIR__ . '/../laravel.db';
if (!file_exists($db)) {
    echo "DB file not found: $db\n";
    exit(1);
}
$pdo = new PDO('sqlite:' . $db);
// Check if role column exists
$stmt = $pdo->query("PRAGMA table_info('users')");
$cols = $stmt->fetchAll(PDO::FETCH_ASSOC);
$hasRole = false;
foreach ($cols as $c) {
    if ($c['name'] === 'role') { $hasRole = true; break; }
}
if (!$hasRole) {
    echo "users.role column not found, cannot set admin role.\n";
    exit(1);
}
$email = 'ahmed@moi.com';
$upd = $pdo->prepare('UPDATE users SET role = :role WHERE email = :email');
$res = $upd->execute([':role' => 'admin', ':email' => $email]);
if ($res) {
    echo "Updated role to 'admin' for $email\n";
} else {
    echo "Failed to update role for $email\n";
}
