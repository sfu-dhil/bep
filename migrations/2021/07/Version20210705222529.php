<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210705222529 extends AbstractMigration {
    public function getDescription() : string {
        return '';
    }

    public function up(Schema $schema) : void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE holding_book (holding_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_DCD1DCC6CD5FBA3 (holding_id), INDEX IDX_DCD1DCC16A2B381 (book_id), PRIMARY KEY(holding_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE holding_book ADD CONSTRAINT FK_DCD1DCC6CD5FBA3 FOREIGN KEY (holding_id) REFERENCES holding (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE holding_book ADD CONSTRAINT FK_DCD1DCC16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('INSERT INTO holding_book(holding_id, book_id) SELECT id, book_id FROM holding');
        $this->addSql('ALTER TABLE holding DROP FOREIGN KEY FK_5BBFD81616A2B381');
        $this->addSql('DROP INDEX IDX_5BBFD81616A2B381 ON holding');
        $this->addSql('ALTER TABLE holding DROP book_id');
    }

    public function down(Schema $schema) : void {
        $this->throwIrreversibleMigrationException();
    }
}
