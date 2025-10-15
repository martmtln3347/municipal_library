<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251015134944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__book AS SELECT id, user_id, isbn, title, summary, publication_year, issue_date, created_at, updated_at FROM book');
        $this->addSql('DROP TABLE book');
        $this->addSql('CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, isbn VARCHAR(20) DEFAULT NULL, title VARCHAR(255) NOT NULL, summary CLOB NOT NULL, publication_year INTEGER NOT NULL, issue_date DATE DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, CONSTRAINT FK_CBE5A331A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO book (id, user_id, isbn, title, summary, publication_year, issue_date, created_at, updated_at) SELECT id, user_id, isbn, title, summary, publication_year, issue_date, created_at, updated_at FROM __temp__book');
        $this->addSql('DROP TABLE __temp__book');
        $this->addSql('CREATE INDEX IDX_CBE5A331A76ED395 ON book (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CBE5A331CC1CF4E6 ON book (isbn)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__book AS SELECT id, user_id, isbn, title, summary, publication_year, issue_date, created_at, updated_at FROM book');
        $this->addSql('DROP TABLE book');
        $this->addSql('CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, isbn VARCHAR(13) NOT NULL, title VARCHAR(50) NOT NULL, summary CLOB NOT NULL, publication_year INTEGER NOT NULL, issue_date DATE DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, CONSTRAINT FK_CBE5A331A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO book (id, user_id, isbn, title, summary, publication_year, issue_date, created_at, updated_at) SELECT id, user_id, isbn, title, summary, publication_year, issue_date, created_at, updated_at FROM __temp__book');
        $this->addSql('DROP TABLE __temp__book');
        $this->addSql('CREATE INDEX IDX_CBE5A331A76ED395 ON book (user_id)');
    }
}
