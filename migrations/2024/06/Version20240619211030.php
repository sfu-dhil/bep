<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240619211030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $tables = [
            ['archdeaconry', 'Archdeaconry'],
            ['archive', 'Archive'],
            ['book', 'Book'],
            ['county', 'County'],
            ['diocese', 'Diocese'],
            ['injunction', 'Injunction'],
            ['manuscript_source', 'ManuscriptSource'],
            ['parish', 'Parish'],
            ['print_source', 'PrintSource'],
            ['province', 'Province'],
            ['town', 'Town'],
        ];
        foreach ($tables as $table) {
            $tableName = $table[0];
            $entityName = $table[1];
            $this->addSql("
                UPDATE $tableName, (
                    SELECT $tableName.id, CONCAT('{', GROUP_CONCAT(REPLACE(nines_media_link.url, ',', '%2C') ORDER BY nines_media_link.id SEPARATOR ','), '}') AS links
                    FROM $tableName
                    LEFT JOIN nines_media_link ON nines_media_link.entity = CONCAT('App\\\\Entity\\\\$entityName:', $tableName.id)
                    GROUP BY nines_media_link.entity
                ) as links_query
                SET $tableName.links = links_query.links
                WHERE $tableName.id = links_query.id
            ");
            // set null links fields to empty array '{}'
            $this->addSql("
                UPDATE $tableName
                SET $tableName.links = COALESCE($tableName.links, '{}')
            ");
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
