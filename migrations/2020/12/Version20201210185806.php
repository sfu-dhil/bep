<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201210185806 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE archive (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(120) NOT NULL, label VARCHAR(120) NOT NULL, description LONGTEXT DEFAULT NULL, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', FULLTEXT INDEX IDX_D5FC5D9CEA750E8 (label), FULLTEXT INDEX IDX_D5FC5D9C6DE44026 (description), FULLTEXT INDEX IDX_D5FC5D9CEA750E86DE44026 (label, description), UNIQUE INDEX UNIQ_D5FC5D9C5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE format (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(120) NOT NULL, label VARCHAR(120) NOT NULL, description LONGTEXT DEFAULT NULL, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', FULLTEXT INDEX IDX_DEBA72DFEA750E8 (label), FULLTEXT INDEX IDX_DEBA72DF6DE44026 (description), FULLTEXT INDEX IDX_DEBA72DFEA750E86DE44026 (label, description), UNIQUE INDEX UNIQ_DEBA72DF5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE injunction (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, estc VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(120) NOT NULL, label VARCHAR(120) NOT NULL, description LONGTEXT DEFAULT NULL, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', FULLTEXT INDEX IDX_CC5A6D27EA750E8 (label), FULLTEXT INDEX IDX_CC5A6D276DE44026 (description), FULLTEXT INDEX IDX_CC5A6D27EA750E86DE44026 (label, description), UNIQUE INDEX UNIQ_CC5A6D275E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE source (id INT AUTO_INCREMENT NOT NULL, source_category_id INT NOT NULL, archive_id INT NOT NULL, name VARCHAR(120) NOT NULL, label VARCHAR(120) NOT NULL, description LONGTEXT DEFAULT NULL, call_number VARCHAR(24) DEFAULT NULL, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_5F8A7F732E39CD42 (source_category_id), INDEX IDX_5F8A7F732956195F (archive_id), FULLTEXT INDEX IDX_5F8A7F73EA750E8 (label), FULLTEXT INDEX IDX_5F8A7F736DE44026 (description), FULLTEXT INDEX IDX_5F8A7F73EA750E86DE44026 (label, description), UNIQUE INDEX UNIQ_5F8A7F735E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE source_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(120) NOT NULL, label VARCHAR(120) NOT NULL, description LONGTEXT DEFAULT NULL, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', FULLTEXT INDEX IDX_456C2F13EA750E8 (label), FULLTEXT INDEX IDX_456C2F136DE44026 (description), FULLTEXT INDEX IDX_456C2F13EA750E86DE44026 (label, description), UNIQUE INDEX UNIQ_456C2F135E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE source ADD CONSTRAINT FK_5F8A7F732E39CD42 FOREIGN KEY (source_category_id) REFERENCES source_category (id)');
        $this->addSql('ALTER TABLE source ADD CONSTRAINT FK_5F8A7F732956195F FOREIGN KEY (archive_id) REFERENCES archive (id)');
        $this->addSql('ALTER TABLE archdeaconry CHANGE diocese_id diocese_id INT NOT NULL');
        $this->addSql('ALTER TABLE book ADD format_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331D629F605 FOREIGN KEY (format_id) REFERENCES format (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331D629F605 ON book (format_id)');
        $this->addSql('ALTER TABLE county ADD nation_id INT NOT NULL');
        $this->addSql('ALTER TABLE county ADD CONSTRAINT FK_58E2FF25AE3899 FOREIGN KEY (nation_id) REFERENCES nation (id)');
        $this->addSql('CREATE INDEX IDX_58E2FF25AE3899 ON county (nation_id)');
        $this->addSql('ALTER TABLE diocese CHANGE province_id province_id INT NOT NULL');
        $this->addSql('ALTER TABLE parish CHANGE archdeaconry_id archdeaconry_id INT NOT NULL, CHANGE town_id town_id INT NOT NULL');
        $this->addSql('ALTER TABLE province ADD nation_id INT NOT NULL');
        $this->addSql('ALTER TABLE province ADD CONSTRAINT FK_4ADAD40BAE3899 FOREIGN KEY (nation_id) REFERENCES nation (id)');
        $this->addSql('CREATE INDEX IDX_4ADAD40BAE3899 ON province (nation_id)');
        $this->addSql('ALTER TABLE town CHANGE county_id county_id INT NOT NULL');
        $this->addSql('ALTER TABLE transact ADD source_id INT NOT NULL, ADD injunction_id INT DEFAULT NULL, CHANGE parish_id parish_id INT NOT NULL, CHANGE transaction_category_id transaction_category_id INT NOT NULL, CHANGE copies copies INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transact ADD CONSTRAINT FK_FA42B7F6953C1C61 FOREIGN KEY (source_id) REFERENCES source (id)');
        $this->addSql('ALTER TABLE transact ADD CONSTRAINT FK_FA42B7F641E88208 FOREIGN KEY (injunction_id) REFERENCES injunction (id)');
        $this->addSql('CREATE INDEX IDX_FA42B7F6953C1C61 ON transact (source_id)');
        $this->addSql('CREATE INDEX IDX_FA42B7F641E88208 ON transact (injunction_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE source DROP FOREIGN KEY FK_5F8A7F732956195F');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331D629F605');
        $this->addSql('ALTER TABLE transact DROP FOREIGN KEY FK_FA42B7F641E88208');
        $this->addSql('ALTER TABLE county DROP FOREIGN KEY FK_58E2FF25AE3899');
        $this->addSql('ALTER TABLE province DROP FOREIGN KEY FK_4ADAD40BAE3899');
        $this->addSql('ALTER TABLE transact DROP FOREIGN KEY FK_FA42B7F6953C1C61');
        $this->addSql('ALTER TABLE source DROP FOREIGN KEY FK_5F8A7F732E39CD42');
        $this->addSql('DROP TABLE archive');
        $this->addSql('DROP TABLE format');
        $this->addSql('DROP TABLE injunction');
        $this->addSql('DROP TABLE nation');
        $this->addSql('DROP TABLE source');
        $this->addSql('DROP TABLE source_category');
        $this->addSql('ALTER TABLE archdeaconry CHANGE diocese_id diocese_id INT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_CBE5A331D629F605 ON book');
        $this->addSql('ALTER TABLE book DROP format_id');
        $this->addSql('DROP INDEX IDX_58E2FF25AE3899 ON county');
        $this->addSql('ALTER TABLE county DROP nation_id');
        $this->addSql('ALTER TABLE diocese CHANGE province_id province_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parish CHANGE archdeaconry_id archdeaconry_id INT DEFAULT NULL, CHANGE town_id town_id INT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_4ADAD40BAE3899 ON province');
        $this->addSql('ALTER TABLE province DROP nation_id');
        $this->addSql('ALTER TABLE town CHANGE county_id county_id INT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_FA42B7F6953C1C61 ON transact');
        $this->addSql('DROP INDEX IDX_FA42B7F641E88208 ON transact');
        $this->addSql('ALTER TABLE transact DROP source_id, DROP injunction_id, CHANGE parish_id parish_id INT DEFAULT NULL, CHANGE transaction_category_id transaction_category_id INT DEFAULT NULL, CHANGE copies copies INT DEFAULT 1 NOT NULL');
    }
}
