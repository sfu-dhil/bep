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
final class Version20220202184642 extends AbstractMigration {
    public function getDescription() : string {
        return '';
    }

    public function up(Schema $schema) : void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE injunction ADD monarch_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE injunction ADD CONSTRAINT FK_A2FAC1E153033E82 FOREIGN KEY (monarch_id) REFERENCES monarch (id)');
        $this->addSql('CREATE INDEX IDX_A2FAC1E153033E82 ON injunction (monarch_id)');
    }

    public function down(Schema $schema) : void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE injunction DROP FOREIGN KEY FK_A2FAC1E153033E82');
        $this->addSql('DROP INDEX IDX_A2FAC1E153033E82 ON injunction');
        $this->addSql('ALTER TABLE injunction DROP monarch_id');
    }
}
