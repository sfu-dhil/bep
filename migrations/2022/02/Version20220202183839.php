<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220202183839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD monarch_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33153033E82 FOREIGN KEY (monarch_id) REFERENCES monarch (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A33153033E82 ON book (monarch_id)');
        $this->addSql('ALTER TABLE injunction CHANGE variant_titles variant_titles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A33153033E82');
        $this->addSql('DROP INDEX IDX_CBE5A33153033E82 ON book');
        $this->addSql('ALTER TABLE book DROP monarch_id');
        $this->addSql('ALTER TABLE injunction CHANGE variant_titles variant_titles LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'a:0:{}\' NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\'');
    }
}
