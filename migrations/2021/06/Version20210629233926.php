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
final class Version20210629233926 extends AbstractMigration {
    public function getDescription() : string {
        return '';
    }

    public function up(Schema $schema) : void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE FULLTEXT INDEX book_ft ON book (title, uniform_title, variant_titles, description, author, publisher, notes)');
        $this->addSql('CREATE FULLTEXT INDEX inventory_ft ON inventory (transcription, modifications, description, notes)');
        $this->addSql('CREATE FULLTEXT INDEX transaction_ft ON transact (transcription, description, notes)');
    }

    public function down(Schema $schema) : void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX book_ft ON book');
        $this->addSql('DROP INDEX inventory_ft ON inventory');
        $this->addSql('DROP INDEX transaction_ft ON transact');
    }
}
