<?php

use App\Kernel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Dotenv\Dotenv;

// ✅ On charge le bon autoloader
require_once __DIR__.'/vendor/autoload.php';

// 🧩 On charge les variables d'environnement (.env)
$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__.'/.env');

$kernel = new Kernel('dev', true);
$kernel->boot();

$container = $kernel->getContainer();
/** @var EntityManagerInterface $em */
$em = $container->get('doctrine')->getManager();

$conn = $em->getConnection();

$sql = "
    INSERT INTO user (
        email, password, roles, last_name, first_name, address, zip_code, birth_date, created_at, updated_at
    ) VALUES (
        'admin@local.dev',
        '\$2y\$13\$Zr5K89gtsqklKX1mGkQiDe9/yP0U0vx5MZQk5CzZC6rCa/YzyANQ.',
        '[\"ROLE_ADMIN\"]',
        'Admin',
        'Super',
        '1 rue locale',
        '75000',
        '1990-01-01',
        '2025-10-15 00:00:00',
        '2025-10-15 00:00:00'
    )
";

$conn->executeStatement($sql);

echo "✅ Utilisateur admin@local.dev inséré avec succès ! Mot de passe : password\n";
