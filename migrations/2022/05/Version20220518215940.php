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
final class Version20220518215940 extends AbstractMigration {
    public function getDescription() : string {
        return '';
    }

    public function up(Schema $schema) : void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE print_source (id INT AUTO_INCREMENT NOT NULL, source_category_id INT NOT NULL, title VARCHAR(200) NOT NULL, author VARCHAR(200) DEFAULT NULL, date VARCHAR(16) DEFAULT NULL, publisher VARCHAR(200) DEFAULT NULL, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', notes LONGTEXT DEFAULT NULL, INDEX IDX_534D01C12E39CD42 (source_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE print_source ADD CONSTRAINT FK_534D01C12E39CD42 FOREIGN KEY (source_category_id) REFERENCES source_category (id)');
        $this->addSql('ALTER TABLE inventory ADD print_source_id INT DEFAULT NULL, CHANGE manuscript_source_id manuscript_source_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36E75A3578 FOREIGN KEY (print_source_id) REFERENCES print_source (id)');
        $this->addSql('CREATE INDEX IDX_B12D4A36E75A3578 ON inventory (print_source_id)');
        $this->addSql('ALTER TABLE transact ADD print_source_id INT DEFAULT NULL, CHANGE manuscript_source_id manuscript_source_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transact ADD CONSTRAINT FK_FA42B7F6E75A3578 FOREIGN KEY (print_source_id) REFERENCES print_source (id)');
        $this->addSql('CREATE INDEX IDX_FA42B7F6E75A3578 ON transact (print_source_id)');
    }

    public function down(Schema $schema) : void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36E75A3578');
        $this->addSql('ALTER TABLE transact DROP FOREIGN KEY FK_FA42B7F6E75A3578');
        $this->addSql('CREATE TABLE printed_source (id INT AUTO_INCREMENT NOT NULL, source_category_id INT NOT NULL, title VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, author VARCHAR(200) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, date VARCHAR(16) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, publisher VARCHAR(200) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', notes LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_D007E02C2E39CD42 (source_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE printed_source ADD CONSTRAINT FK_D007E02C2E39CD42 FOREIGN KEY (source_category_id) REFERENCES source_category (id)');
        $this->addSql('DROP TABLE print_source');
        $this->addSql('DROP INDEX IDX_B12D4A36E75A3578 ON inventory');
        $this->addSql('ALTER TABLE inventory DROP print_source_id, CHANGE manuscript_source_id manuscript_source_id INT NOT NULL');
        $this->addSql('DROP INDEX IDX_FA42B7F6E75A3578 ON transact');
        $this->addSql('ALTER TABLE transact DROP print_source_id, CHANGE manuscript_source_id manuscript_source_id INT NOT NULL');
    }
}
