<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210223201249 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inventory_book (inventory_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_81436C1F9EEA759 (inventory_id), INDEX IDX_81436C1F16A2B381 (book_id), PRIMARY KEY(inventory_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inventory_book ADD CONSTRAINT FK_81436C1F9EEA759 FOREIGN KEY (inventory_id) REFERENCES inventory (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inventory_book ADD CONSTRAINT FK_81436C1F16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A3616A2B381');
        $this->addSql('DROP INDEX IDX_B12D4A3616A2B381 ON inventory');
        $this->addSql('INSERT INTO inventory_book(inventory_id, book_id) SELECT id,book_id FROM inventory;');
        $this->addSql('ALTER TABLE inventory DROP book_id');
    }

    public function down(Schema $schema) : void
    {
        $this->throwIrreversibleMigrationException();
    }
}
