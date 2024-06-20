<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240619211032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nines_media_image DROP original_name');
        $this->addSql('ALTER TABLE nines_media_image DROP file_size');
        $this->addSql('ALTER TABLE nines_media_image DROP mime_type');
        $this->addSql('ALTER TABLE nines_media_image DROP `checksum`');
        $this->addSql('ALTER TABLE nines_media_image DROP source_url');
        $this->addSql('ALTER TABLE nines_media_image CHANGE `path` `image` varchar(255)');
        $this->addSql('ALTER TABLE nines_media_image CHANGE `thumb_path` `thumbnail` varchar(255)');

        $this->addSql("
            UPDATE nines_media_image
            SET entity = REGEXP_REPLACE(entity, '^[a-zA-Z]+.[a-zA-Z]+.[a-zA-Z]+.', '')
        ");
        $this->addSql("UPDATE nines_media_image SET image = CONCAT('images/', image)");
        $this->addSql("UPDATE nines_media_image SET thumbnail = CONCAT('thumbnails/', thumbnail)");
        $this->addSql('ALTER TABLE nines_media_image CHANGE `entity` `holding_id` int(11)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
