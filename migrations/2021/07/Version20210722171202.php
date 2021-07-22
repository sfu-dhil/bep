<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210722171202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX book_ft ON book');
        $this->addSql('ALTER TABLE book ADD variant_imprint LONGTEXT DEFAULT NULL, CHANGE publisher imprint LONGTEXT DEFAULT NULL');
        $this->addSql('CREATE FULLTEXT INDEX book_ft ON book (title, uniform_title, variant_titles, description, author, imprint, variant_imprint, notes)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX book_ft ON book');
        $this->addSql('ALTER TABLE book ADD publisher LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP imprint, DROP variant_imprint');
        $this->addSql('CREATE FULLTEXT INDEX book_ft ON book (title, uniform_title, variant_titles, description, author, publisher, notes)');
    }
}
