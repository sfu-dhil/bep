<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240619211033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql('RENAME TABLE archdeaconry to bep_archdeaconry');
        $this->addSql('RENAME TABLE archive to bep_archive');
        $this->addSql('RENAME TABLE book to bep_book');
        $this->addSql('RENAME TABLE county to bep_county');
        $this->addSql('RENAME TABLE diocese to bep_diocese');
        $this->addSql('RENAME TABLE format to bep_format');
        $this->addSql('RENAME TABLE holding to bep_holding');
        $this->addSql('RENAME TABLE holding_book to bep_holding_books');
        $this->addSql('RENAME TABLE nines_media_image to bep_holding_image');
        $this->addSql('RENAME TABLE injunction to bep_injunction');
        $this->addSql('RENAME TABLE inventory to bep_inventory');
        $this->addSql('RENAME TABLE inventory_book to bep_inventory_books');
        $this->addSql('RENAME TABLE manuscript_source to bep_manuscript_source');
        $this->addSql('RENAME TABLE monarch to bep_monarch');
        $this->addSql('RENAME TABLE nation to bep_nation');
        $this->addSql('RENAME TABLE parish to bep_parish');
        $this->addSql('RENAME TABLE print_source to bep_print_source');
        $this->addSql('RENAME TABLE province to bep_province');
        $this->addSql('RENAME TABLE source_category to bep_source_category');
        $this->addSql('RENAME TABLE town to bep_town');
        $this->addSql('RENAME TABLE transact to bep_transact');
        $this->addSql('RENAME TABLE transaction_book to bep_transaction_books');
        $this->addSql('RENAME TABLE transaction_category to bep_transaction_category');
        $this->addSql('RENAME TABLE transaction_transaction_category to bep_transaction_transaction_categories');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
