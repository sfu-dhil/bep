<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210317190058 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_page CHANGE in_menu in_menu TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE source CHANGE call_number call_number VARCHAR(64) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_page CHANGE in_menu in_menu TINYINT(1) DEFAULT \'1\' NOT NULL');
        $this->addSql('ALTER TABLE source CHANGE call_number call_number VARCHAR(24) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
