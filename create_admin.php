<?php

use App\Entity\User;
use Symfony\Component\Dotenv\Dotenv;
use App\Kernel;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Doctrine\ORM\EntityManagerInterface;

require_once __DIR__.'/vendor/autoload_runtime.php';

// Charger les variables d’environnement (.env)
$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__.'/.env');

// Démarre Symfony
$kernel = new Kernel('dev', true);
$kernel->boot();

// Récupère l’EntityManager
/** @var EntityManagerInterface $em */
$em = $kernel->getContainer()->get('doctrine')->getManager();

// Création du hasher manuellement
$factory = new PasswordHasherFactory([
    App\Entity\User::class => ['algorithm' => 'bcrypt'],
]);
$hasher = $factory->getPasswordHasher(App\Entity\User::class);

// Supprime l’utilisateur existant
$existing = $em->getRepository(User::class)->findOneBy(['email' => 'admin@local.dev']);
if ($existing) {
    $em->remove($existing);
    $em->flush();
    echo "🗑 Ancien utilisateur supprimé.\n";
}

// Crée le nouvel utilisateur admin
$user = new User();
$user->setEmail('admin@local.dev');
$user->setPassword($hasher->hash('password'));
$user->setRoles(['ROLE_ADMIN']);
$user->setLastName('Admin');
$user->setFirstName('Super');
$user->setAddress('1 rue locale');
$user->setZipCode('75000');
$user->setBirthDate(new DateTime('1990-01-01'));
$user->setCreatedAt(new DateTimeImmutable());
$user->setUpdatedAt(new DateTimeImmutable());

$em->persist($user);
$em->flush();

echo "✅ Nouvel admin créé avec succès : admin@local.dev / password\n";
