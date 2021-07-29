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
final class Version20210722174620 extends AbstractMigration {
    public function getDescription() : string {
        return '';
    }

    public function up(Schema $schema) : void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE monarch (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(120) NOT NULL, label VARCHAR(120) NOT NULL, description LONGTEXT DEFAULT NULL, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', FULLTEXT INDEX IDX_71FB7BAEEA750E8 (label), FULLTEXT INDEX IDX_71FB7BAE6DE44026 (description), FULLTEXT INDEX IDX_71FB7BAEEA750E86DE44026 (label, description), UNIQUE INDEX UNIQ_71FB7BAE5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inventory ADD monarch_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A3653033E82 FOREIGN KEY (monarch_id) REFERENCES monarch (id)');
        $this->addSql('CREATE INDEX IDX_B12D4A3653033E82 ON inventory (monarch_id)');
        $this->addSql('ALTER TABLE transact ADD monarch_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transact ADD CONSTRAINT FK_FA42B7F653033E82 FOREIGN KEY (monarch_id) REFERENCES monarch (id)');
        $this->addSql('CREATE INDEX IDX_FA42B7F653033E82 ON transact (monarch_id)');
    }

    public function down(Schema $schema) : void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A3653033E82');
        $this->addSql('ALTER TABLE transact DROP FOREIGN KEY FK_FA42B7F653033E82');
        $this->addSql('DROP TABLE monarch');
        $this->addSql('DROP INDEX IDX_B12D4A3653033E82 ON inventory');
        $this->addSql('ALTER TABLE inventory DROP monarch_id');
        $this->addSql('DROP INDEX IDX_FA42B7F653033E82 ON transact');
        $this->addSql('ALTER TABLE transact DROP monarch_id');
    }
}
