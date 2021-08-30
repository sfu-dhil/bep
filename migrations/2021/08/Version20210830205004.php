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
final class Version20210830205004 extends AbstractMigration {
    public function getDescription() : string {
        return '';
    }

    public function up(Schema $schema) : void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE citation');
        $this->addSql('DROP INDEX transaction_ft ON transact');
        $this->addSql('ALTER TABLE transact ADD public_notes LONGTEXT DEFAULT NULL, CHANGE description modern_transcription LONGTEXT DEFAULT NULL');
        $this->addSql('CREATE FULLTEXT INDEX transaction_ft ON transact (transcription, modern_transcription, notes)');
    }

    public function down(Schema $schema) : void {
        $this->throwIrreversibleMigrationException();
    }
}
