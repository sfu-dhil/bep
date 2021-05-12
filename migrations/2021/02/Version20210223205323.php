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
final class Version20210223205323 extends AbstractMigration {
    public function getDescription() : string {
        return '';
    }

    public function up(Schema $schema) : void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transaction_book (transaction_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_29A69D902FC0CB0F (transaction_id), INDEX IDX_29A69D9016A2B381 (book_id), PRIMARY KEY(transaction_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction_book ADD CONSTRAINT FK_29A69D902FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transaction_book ADD CONSTRAINT FK_29A69D9016A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transact DROP FOREIGN KEY FK_FA42B7F616A2B381');
        $this->addSql('DROP INDEX IDX_FA42B7F616A2B381 ON transact');
        $this->addSql('INSERT INTO transaction_book SELECT id, book_id FROM bep.transact');
        $this->addSql('ALTER TABLE transact DROP book_id');
    }

    public function down(Schema $schema) : void {
        $this->throwIrreversibleMigrationException();
    }
}
