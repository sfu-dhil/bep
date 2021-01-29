<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210129205822 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE holding (id INT AUTO_INCREMENT NOT NULL, parish_id INT NOT NULL, book_id INT NOT NULL, description LONGTEXT NOT NULL, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', start_date VARCHAR(10) DEFAULT NULL, end_date VARCHAR(10) DEFAULT NULL, INDEX IDX_5BBFD8168707B11F (parish_id), INDEX IDX_5BBFD81616A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory (id INT AUTO_INCREMENT NOT NULL, source_id INT NOT NULL, parish_id INT NOT NULL, book_id INT NOT NULL, transcription LONGTEXT NOT NULL, modifications LONGTEXT NOT NULL, description LONGTEXT NOT NULL, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', start_date VARCHAR(10) DEFAULT NULL, end_date VARCHAR(10) DEFAULT NULL, INDEX IDX_B12D4A36953C1C61 (source_id), INDEX IDX_B12D4A368707B11F (parish_id), INDEX IDX_B12D4A3616A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE holding ADD CONSTRAINT FK_5BBFD8168707B11F FOREIGN KEY (parish_id) REFERENCES parish (id)');
        $this->addSql('ALTER TABLE holding ADD CONSTRAINT FK_5BBFD81616A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36953C1C61 FOREIGN KEY (source_id) REFERENCES source (id)');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A368707B11F FOREIGN KEY (parish_id) REFERENCES parish (id)');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A3616A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE holding');
        $this->addSql('DROP TABLE inventory');
    }
}
