<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240619211036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $tables_columns = [
            ['bep_transaction', 'page'],
            ['bep_parish', 'description'],
            ['bep_manuscript_source', 'description'],
            ['bep_town', 'description'],
            ['bep_archdeaconry', 'description'],
            ['bep_inventory', 'page_number'],
            ['bep_archive', 'description'],
            ['bep_book', 'uniform_title'],
            ['bep_diocese', 'description'],
            ['bep_transaction_category', 'description'],
            ['bep_holding', 'notes'],
            ['bep_injunction', 'uniform_title'],
            ['bep_source_category', 'description'],
            ['bep_holding_image', 'license'],
            ['bep_monarch', 'description'],
            ['bep_nation', 'description'],
            ['bep_print_source', 'notes'],
            ['bep_format', 'description'],
            ['bep_province', 'description'],
            ['bep_parish', 'address'],
            ['bep_manuscript_source', 'call_number'],
            ['bep_holding', 'written_date'],
            ['bep_transaction', 'public_notes'],
            ['bep_inventory', 'notes'],
            ['bep_book', 'author'],
            ['bep_injunction', 'variant_imprint'],
            ['bep_print_source', 'publisher'],
            ['bep_book', 'imprint'],
            ['bep_transaction', 'notes'],
            ['bep_inventory', 'written_date'],
            ['bep_injunction', 'modern_transcription'],
            ['bep_transaction', 'written_date'],
            ['bep_inventory', 'description'],
            ['bep_book', 'variant_imprint'],
            ['bep_transaction', 'location'],
            ['bep_book', 'estc'],
            ['bep_injunction', 'notes'],
            ['bep_injunction', 'physical_description'],
            ['bep_transaction', 'modern_transcription'],
            ['bep_book', 'physical_description'],
            ['bep_injunction', 'imprint'],
            ['bep_transaction', 'transcription'],
            ['bep_book', 'notes'],
            ['bep_injunction', 'estc'],
            ['bep_book', 'description'],
            ['bep_injunction', 'date'],
            ['bep_book', 'date'],
        ];
        foreach ($tables_columns as $table_column) {
            $tableName = $table_column[0];
            $columnName = $table_column[1];
            $this->addSql("UPDATE $tableName SET $columnName = '' WHERE $columnName IS NULL");
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
