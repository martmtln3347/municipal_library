<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231002180000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create user and book tables with OneToMany relation (User -> Book)';
    }

    public function up(Schema $schema): void
    {
        // Table user
        $this->addSql('CREATE TABLE user (
            id INT AUTO_INCREMENT NOT NULL,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            roles VARCHAR(255) NOT NULL,
            last_name VARCHAR(50) NOT NULL,
            first_name VARCHAR(50) NOT NULL,
            address VARCHAR(150) NOT NULL,
            zip_code VARCHAR(5) NOT NULL,
            birth_date DATE NOT NULL,
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Table book
        $this->addSql('CREATE TABLE book (
            id INT AUTO_INCREMENT NOT NULL,
            user_id INT DEFAULT NULL,
            isbn VARCHAR(13) NOT NULL,
            title VARCHAR(50) NOT NULL,
            summary LONGTEXT DEFAULT NULL,
            publication_year INT NOT NULL,
            issue_date DATE DEFAULT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            INDEX IDX_CBE5A331A76ED395 (user_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Foreign key
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331A76ED395');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE user');
    }
}

