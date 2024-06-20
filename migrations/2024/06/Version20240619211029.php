<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240619211029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_36CE5E075E237E06 ON archdeaconry');
        $this->addSql('ALTER TABLE archdeaconry ADD links LONGTEXT DEFAULT NULL, DROP name');
        $this->addSql('DROP INDEX UNIQ_D5FC5D9C5E237E06 ON archive');
        $this->addSql('ALTER TABLE archive ADD links LONGTEXT DEFAULT NULL, DROP name');
        $this->addSql('ALTER TABLE book ADD links LONGTEXT DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_58E2FF255E237E06 ON county');
        $this->addSql('ALTER TABLE county ADD links LONGTEXT DEFAULT NULL, DROP name');
        $this->addSql('DROP INDEX UNIQ_8849E7425E237E06 ON diocese');
        $this->addSql('ALTER TABLE diocese ADD links LONGTEXT DEFAULT NULL, DROP name');
        $this->addSql('DROP INDEX UNIQ_DEBA72DF5E237E06 ON format');
        $this->addSql('ALTER TABLE format DROP name');
        $this->addSql('ALTER TABLE injunction ADD links LONGTEXT DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_CE3EE8025E237E06 ON manuscript_source');
        $this->addSql('ALTER TABLE manuscript_source ADD links LONGTEXT DEFAULT NULL, DROP name');
        $this->addSql('DROP INDEX UNIQ_71FB7BAE5E237E06 ON monarch');
        $this->addSql('ALTER TABLE monarch DROP name');
        $this->addSql('DROP INDEX UNIQ_CC5A6D275E237E06 ON nation');
        $this->addSql('ALTER TABLE nation DROP name');
        $this->addSql('DROP INDEX UNIQ_DFF9A9785E237E06 ON parish');
        $this->addSql('ALTER TABLE parish ADD links LONGTEXT DEFAULT NULL, DROP name');
        $this->addSql('ALTER TABLE print_source ADD links LONGTEXT DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_4ADAD40B5E237E06 ON province');
        $this->addSql('ALTER TABLE province ADD links LONGTEXT DEFAULT NULL, DROP name');
        $this->addSql('DROP INDEX UNIQ_456C2F135E237E06 ON source_category');
        $this->addSql('ALTER TABLE source_category DROP name');
        $this->addSql('DROP INDEX UNIQ_4CE6C7A45E237E06 ON town');
        $this->addSql('ALTER TABLE town ADD links LONGTEXT DEFAULT NULL, DROP name');
        $this->addSql('DROP INDEX UNIQ_483E30A95E237E06 ON transaction_category');
        $this->addSql('ALTER TABLE transaction_category DROP name');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE source_category ADD name VARCHAR(191) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_456C2F135E237E06 ON source_category (name)');
        $this->addSql('ALTER TABLE format ADD name VARCHAR(191) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DEBA72DF5E237E06 ON format (name)');
        $this->addSql('ALTER TABLE archdeaconry ADD name VARCHAR(191) NOT NULL, DROP links');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_36CE5E075E237E06 ON archdeaconry (name)');
        $this->addSql('ALTER TABLE transaction_category ADD name VARCHAR(191) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_483E30A95E237E06 ON transaction_category (name)');
        $this->addSql('ALTER TABLE nation ADD name VARCHAR(191) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CC5A6D275E237E06 ON nation (name)');
        $this->addSql('ALTER TABLE injunction DROP links');
        $this->addSql('ALTER TABLE parish ADD name VARCHAR(191) NOT NULL, DROP links');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DFF9A9785E237E06 ON parish (name)');
        $this->addSql('ALTER TABLE county ADD name VARCHAR(191) NOT NULL, DROP links');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_58E2FF255E237E06 ON county (name)');
        $this->addSql('ALTER TABLE province ADD name VARCHAR(191) NOT NULL, DROP links');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4ADAD40B5E237E06 ON province (name)');
        $this->addSql('ALTER TABLE print_source DROP links');
        $this->addSql('ALTER TABLE diocese ADD name VARCHAR(191) NOT NULL, DROP links');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8849E7425E237E06 ON diocese (name)');
        $this->addSql('ALTER TABLE town ADD name VARCHAR(191) NOT NULL, DROP links');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4CE6C7A45E237E06 ON town (name)');
        $this->addSql('ALTER TABLE archive ADD name VARCHAR(191) NOT NULL, DROP links');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D5FC5D9C5E237E06 ON archive (name)');
        $this->addSql('ALTER TABLE monarch ADD name VARCHAR(191) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_71FB7BAE5E237E06 ON monarch (name)');
        $this->addSql('ALTER TABLE book DROP links');
        $this->addSql('ALTER TABLE manuscript_source ADD name VARCHAR(191) NOT NULL, DROP links');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CE3EE8025E237E06 ON manuscript_source (name)');
    }
}
