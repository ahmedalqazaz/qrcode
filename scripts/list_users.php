<?php
$db = __DIR__ . '/../laravel.db';
if (!file_exists($db)) {
    echo "DB file not found: $db\n";
    exit(1);
}
$pdo = new PDO('sqlite:' . $db);
$stmt = $pdo->query("SELECT id, name, email, role FROM users ORDER BY id ASC");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!$rows) {
    echo "No users found\n";
    exit(0);
}
foreach ($rows as $r) {
    echo "id={$r['id']} name={$r['name']} email={$r['email']} role=" . (isset($r['role']) ? $r['role'] : 'NULL') . "\n";
}
