<?php

use Symfony\Component\Dotenv\Dotenv;
use Doctrine\DBAL\DriverManager;

require_once __DIR__.'/vendor/autoload.php';

(new Dotenv())->bootEnv(__DIR__.'/.env');

$conn = DriverManager::getConnection(['url' => $_ENV['DATABASE_URL']]);

$hashedPassword = password_hash('password', PASSWORD_BCRYPT, ['cost' => 13]);

$conn->executeStatement('DELETE FROM user WHERE email = "admin@local.dev"');

$conn->executeStatement('
    INSERT INTO user (
        email, password, roles, last_name, first_name, address, zip_code, birth_date, created_at, updated_at
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )
', [
    'admin@local.dev',
    $hashedPassword,
    '["ROLE_ADMIN"]',
    'Admin',
    'Super',
    '1 rue locale',
    '75000',
    '1990-01-01',
    (new DateTimeImmutable())->format('Y-m-d H:i:s'),
    (new DateTimeImmutable())->format('Y-m-d H:i:s'),
]);

echo "✅ Admin inséré ! Email: admin@local.dev | Mot de passe: password\n";
