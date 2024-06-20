<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240619211031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $tables = ['book', 'injunction'];
        foreach ($tables as $tableName) {
            $this->addSql("
                UPDATE $tableName
                SET variant_titles = REGEXP_REPLACE(
                    REGEXP_REPLACE(
                        REGEXP_REPLACE(
                            variant_titles, '^a:[0-9]+:|i:[0-9]+;s:[0-9]+:', ''
                        ),
                        '\";}', '\"}'
                    ),
                    '\";\"', '\",\"'
                )
            ");
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
