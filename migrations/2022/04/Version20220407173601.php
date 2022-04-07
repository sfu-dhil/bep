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
final class Version20220407173601 extends AbstractMigration {
    public function getDescription() : string {
        return '';
    }

    public function up(Schema $schema) : void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX injunction_ft ON injunction');
        $this->addSql('ALTER TABLE injunction CHANGE description transcription LONGTEXT DEFAULT NULL');
        $this->addSql('CREATE FULLTEXT INDEX injunction_ft ON injunction (title, uniform_title, variant_titles, transcription, author, imprint, variant_imprint)');
    }

    public function down(Schema $schema) : void {
        $this->throwIrreversibleMigrationException();
    }
}
