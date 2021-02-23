<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210223183621 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE holding ADD archive_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE holding ADD CONSTRAINT FK_5BBFD8162956195F FOREIGN KEY (archive_id) REFERENCES archive (id)');
        $this->addSql('CREATE INDEX IDX_5BBFD8162956195F ON holding (archive_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE holding DROP FOREIGN KEY FK_5BBFD8162956195F');
        $this->addSql('DROP INDEX IDX_5BBFD8162956195F ON holding');
        $this->addSql('ALTER TABLE holding DROP archive_id');
    }
}
