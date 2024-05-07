<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220527224759 extends AbstractMigration {
    public function getDescription() : string {
        return '';
    }

    public function up(Schema $schema) : void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE archdeaconry (id INT AUTO_INCREMENT NOT NULL, diocese_id INT NOT NULL, name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, label VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', FULLTEXT INDEX IDX_36CE5E07EA750E8 (label), FULLTEXT INDEX IDX_36CE5E076DE44026 (description), UNIQUE INDEX UNIQ_36CE5E075E237E06 (name), FULLTEXT INDEX IDX_36CE5E07EA750E86DE44026 (label, description), INDEX IDX_36CE5E07B600009 (diocese_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE archive (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, label VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', FULLTEXT INDEX IDX_D5FC5D9C6DE44026 (description), FULLTEXT INDEX IDX_D5FC5D9CEA750E86DE44026 (label, description), UNIQUE INDEX UNIQ_D5FC5D9C5E237E06 (name), FULLTEXT INDEX IDX_D5FC5D9CEA750E8 (label), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, format_id INT DEFAULT NULL, monarch_id INT DEFAULT NULL, title LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, date VARCHAR(12) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', variant_titles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', uniform_title LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, author VARCHAR(160) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, imprint LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, notes LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, variant_imprint LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, estc VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, physical_description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, FULLTEXT INDEX book_ft (title, uniform_title, variant_titles, description, author, imprint, variant_imprint, notes), INDEX IDX_CBE5A331D629F605 (format_id), INDEX IDX_CBE5A33153033E82 (monarch_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE county (id INT AUTO_INCREMENT NOT NULL, nation_id INT NOT NULL, name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, label VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', FULLTEXT INDEX IDX_58E2FF25EA750E8 (label), FULLTEXT INDEX IDX_58E2FF256DE44026 (description), UNIQUE INDEX UNIQ_58E2FF255E237E06 (name), FULLTEXT INDEX IDX_58E2FF25EA750E86DE44026 (label, description), INDEX IDX_58E2FF25AE3899 (nation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE diocese (id INT AUTO_INCREMENT NOT NULL, province_id INT NOT NULL, name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, label VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', FULLTEXT INDEX IDX_8849E742EA750E8 (label), FULLTEXT INDEX IDX_8849E7426DE44026 (description), UNIQUE INDEX UNIQ_8849E7425E237E06 (name), FULLTEXT INDEX IDX_8849E742EA750E86DE44026 (label, description), INDEX IDX_8849E742E946114A (province_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE format (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, label VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', FULLTEXT INDEX IDX_DEBA72DF6DE44026 (description), FULLTEXT INDEX IDX_DEBA72DFEA750E86DE44026 (label, description), UNIQUE INDEX UNIQ_DEBA72DF5E237E06 (name), FULLTEXT INDEX IDX_DEBA72DFEA750E8 (label), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE holding (id INT AUTO_INCREMENT NOT NULL, parish_id INT NOT NULL, archive_id INT DEFAULT NULL, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', start_date VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, end_date VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, notes LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, written_date VARCHAR(60) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_5BBFD8168707B11F (parish_id), INDEX IDX_5BBFD8162956195F (archive_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE holding_book (holding_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_DCD1DCC16A2B381 (book_id), INDEX IDX_DCD1DCC6CD5FBA3 (holding_id), PRIMARY KEY(holding_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE injunction (id INT AUTO_INCREMENT NOT NULL, monarch_id INT DEFAULT NULL, title LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, transcription LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, estc VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date VARCHAR(12) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, uniform_title LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, variant_titles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', author VARCHAR(160) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, imprint LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, variant_imprint LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, physical_description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, notes LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, modern_transcription LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_A2FAC1E153033E82 (monarch_id), FULLTEXT INDEX injunction_ft (title, uniform_title, variant_titles, transcription, modern_transcription, author, imprint, variant_imprint), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE inventory (id INT AUTO_INCREMENT NOT NULL, manuscript_source_id INT DEFAULT NULL, parish_id INT NOT NULL, monarch_id INT DEFAULT NULL, print_source_id INT DEFAULT NULL, transcription LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, modifications LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', start_date VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, end_date VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, notes LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, written_date VARCHAR(60) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, page_number LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_B12D4A36320375DF (manuscript_source_id), INDEX IDX_B12D4A36E75A3578 (print_source_id), INDEX IDX_B12D4A368707B11F (parish_id), FULLTEXT INDEX inventory_ft (transcription, modifications, description, notes), INDEX IDX_B12D4A3653033E82 (monarch_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE inventory_book (inventory_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_81436C1F16A2B381 (book_id), INDEX IDX_81436C1F9EEA759 (inventory_id), PRIMARY KEY(inventory_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE manuscript_source (id INT AUTO_INCREMENT NOT NULL, source_category_id INT NOT NULL, archive_id INT NOT NULL, name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, label VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, call_number VARCHAR(64) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_CE3EE8022956195F (archive_id), FULLTEXT INDEX IDX_CE3EE802EA750E8 (label), UNIQUE INDEX UNIQ_CE3EE8025E237E06 (name), FULLTEXT INDEX IDX_CE3EE8026DE44026 (description), INDEX IDX_CE3EE8022E39CD42 (source_category_id), FULLTEXT INDEX IDX_CE3EE802EA750E86DE44026 (label, description), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE monarch (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, label VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', start_date VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, end_date VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, FULLTEXT INDEX IDX_71FB7BAE6DE44026 (description), FULLTEXT INDEX IDX_71FB7BAEEA750E86DE44026 (label, description), UNIQUE INDEX UNIQ_71FB7BAE5E237E06 (name), FULLTEXT INDEX IDX_71FB7BAEEA750E8 (label), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE nation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, label VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', FULLTEXT INDEX IDX_CC5A6D276DE44026 (description), FULLTEXT INDEX IDX_CC5A6D27EA750E86DE44026 (label, description), UNIQUE INDEX UNIQ_CC5A6D275E237E06 (name), FULLTEXT INDEX IDX_CC5A6D27EA750E8 (label), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE nines_blog_page (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, weight INT NOT NULL, public TINYINT(1) NOT NULL, homepage TINYINT(1) DEFAULT 0 NOT NULL, include_comments TINYINT(1) NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, searchable LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', excerpt LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, in_menu TINYINT(1) NOT NULL, INDEX IDX_23FD24C7A76ED395 (user_id), FULLTEXT INDEX blog_page_ft (title, searchable), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE nines_blog_post (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, status_id INT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, include_comments TINYINT(1) NOT NULL, searchable LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', excerpt LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_6D7DFE6AA76ED395 (user_id), FULLTEXT INDEX blog_post_ft (title, searchable), INDEX IDX_6D7DFE6A12469DE2 (category_id), INDEX IDX_6D7DFE6A6BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE nines_blog_post_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, label VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', FULLTEXT INDEX IDX_32F5FC8C6DE44026 (description), FULLTEXT INDEX IDX_32F5FC8CEA750E86DE44026 (label, description), UNIQUE INDEX UNIQ_32F5FC8C5E237E06 (name), FULLTEXT INDEX IDX_32F5FC8CEA750E8 (label), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE nines_blog_post_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, label VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, public TINYINT(1) NOT NULL, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', FULLTEXT INDEX IDX_4A63E2FD6DE44026 (description), FULLTEXT INDEX IDX_4A63E2FDEA750E86DE44026 (label, description), UNIQUE INDEX UNIQ_4A63E2FD5E237E06 (name), FULLTEXT INDEX IDX_4A63E2FDEA750E8 (label), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE nines_media_audio (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', entity VARCHAR(120) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, license LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, public TINYINT(1) NOT NULL, original_name VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, path VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, mime_type VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, file_size INT NOT NULL, INDEX IDX_9D15F751E284468 (entity), FULLTEXT INDEX nines_media_audio_ft (original_name, description), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE nines_media_image (id INT AUTO_INCREMENT NOT NULL, public TINYINT(1) NOT NULL, original_name VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, path VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, thumb_path VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, file_size INT NOT NULL, image_width INT NOT NULL, image_height INT NOT NULL, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, license LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, entity VARCHAR(120) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, mime_type VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_4055C59BE284468 (entity), FULLTEXT INDEX nines_media_image_ft (original_name, description), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE nines_media_link (id INT AUTO_INCREMENT NOT NULL, entity VARCHAR(120) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, url VARCHAR(500) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, text VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_3B5D85A3E284468 (entity), FULLTEXT INDEX nines_media_link_ft (url, text), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE nines_media_pdf (id INT AUTO_INCREMENT NOT NULL, thumb_path VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', entity VARCHAR(120) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, license LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, public TINYINT(1) NOT NULL, original_name VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, path VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, mime_type VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, file_size INT NOT NULL, INDEX IDX_9286B706E284468 (entity), FULLTEXT INDEX nines_media_pdf_ft (original_name, description), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE nines_user (id INT AUTO_INCREMENT NOT NULL, active TINYINT(1) NOT NULL, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, reset_token VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reset_expiry DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', fullname VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, affiliation VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', login DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_5BA994A1E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE parish (id INT AUTO_INCREMENT NOT NULL, archdeaconry_id INT NOT NULL, town_id INT DEFAULT NULL, name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, label VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', latitude NUMERIC(10, 7) DEFAULT NULL, longitude NUMERIC(10, 7) DEFAULT NULL, address LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_DFF9A97875E23604 (town_id), FULLTEXT INDEX IDX_DFF9A978EA750E8 (label), UNIQUE INDEX UNIQ_DFF9A9785E237E06 (name), FULLTEXT INDEX IDX_DFF9A9786DE44026 (description), INDEX IDX_DFF9A9783BEA4CEE (archdeaconry_id), FULLTEXT INDEX IDX_DFF9A978EA750E86DE44026 (label, description), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE print_source (id INT AUTO_INCREMENT NOT NULL, source_category_id INT NOT NULL, title VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, author VARCHAR(200) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, date VARCHAR(16) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, publisher VARCHAR(200) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', notes LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_534D01C12E39CD42 (source_category_id), FULLTEXT INDEX print_source_ft (title, author, publisher), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE province (id INT AUTO_INCREMENT NOT NULL, nation_id INT NOT NULL, name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, label VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', FULLTEXT INDEX IDX_4ADAD40BEA750E8 (label), FULLTEXT INDEX IDX_4ADAD40B6DE44026 (description), UNIQUE INDEX UNIQ_4ADAD40B5E237E06 (name), FULLTEXT INDEX IDX_4ADAD40BEA750E86DE44026 (label, description), INDEX IDX_4ADAD40BAE3899 (nation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE source_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, label VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', FULLTEXT INDEX IDX_456C2F136DE44026 (description), FULLTEXT INDEX IDX_456C2F13EA750E86DE44026 (label, description), UNIQUE INDEX UNIQ_456C2F135E237E06 (name), FULLTEXT INDEX IDX_456C2F13EA750E8 (label), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE town (id INT AUTO_INCREMENT NOT NULL, county_id INT NOT NULL, name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, label VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, in_london TINYINT(1) NOT NULL, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', FULLTEXT INDEX IDX_4CE6C7A4EA750E8 (label), FULLTEXT INDEX IDX_4CE6C7A46DE44026 (description), UNIQUE INDEX UNIQ_4CE6C7A45E237E06 (name), FULLTEXT INDEX IDX_4CE6C7A4EA750E86DE44026 (label, description), INDEX IDX_4CE6C7A485E73F45 (county_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE transact (id INT AUTO_INCREMENT NOT NULL, parish_id INT NOT NULL, manuscript_source_id INT DEFAULT NULL, injunction_id INT DEFAULT NULL, monarch_id INT DEFAULT NULL, print_source_id INT DEFAULT NULL, value INT DEFAULT NULL, copies INT DEFAULT NULL, transcription LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, modern_transcription LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', shipping INT DEFAULT NULL, page VARCHAR(24) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, start_date VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, end_date VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, location VARCHAR(160) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, notes LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, written_date VARCHAR(60) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, public_notes LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_FA42B7F653033E82 (monarch_id), INDEX IDX_FA42B7F6320375DF (manuscript_source_id), INDEX IDX_FA42B7F68707B11F (parish_id), INDEX IDX_FA42B7F6E75A3578 (print_source_id), INDEX IDX_FA42B7F641E88208 (injunction_id), FULLTEXT INDEX transaction_ft (transcription, modern_transcription, notes), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE transaction_book (transaction_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_29A69D9016A2B381 (book_id), INDEX IDX_29A69D902FC0CB0F (transaction_id), PRIMARY KEY(transaction_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE transaction_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, label VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', FULLTEXT INDEX IDX_483E30A96DE44026 (description), FULLTEXT INDEX IDX_483E30A9EA750E86DE44026 (label, description), UNIQUE INDEX UNIQ_483E30A95E237E06 (name), FULLTEXT INDEX IDX_483E30A9EA750E8 (label), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('CREATE TABLE transaction_transaction_category (transaction_id INT NOT NULL, transaction_category_id INT NOT NULL, INDEX IDX_7F5D163DAECF88CF (transaction_category_id), INDEX IDX_7F5D163D2FC0CB0F (transaction_id), PRIMARY KEY(transaction_id, transaction_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
    }

    public function down(Schema $schema) : void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE archdeaconry');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE archive');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE book');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE county');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE diocese');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE format');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE holding');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE holding_book');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE injunction');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE inventory');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE inventory_book');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE manuscript_source');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE monarch');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE nation');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE nines_blog_page');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE nines_blog_post');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE nines_blog_post_category');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE nines_blog_post_status');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE nines_media_audio');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE nines_media_image');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE nines_media_link');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE nines_media_pdf');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE nines_user');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE parish');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE print_source');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE province');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE source_category');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE town');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE transact');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE transaction_book');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE transaction_category');
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\\Doctrine\\DBAL\\Platforms\\MariaDb1027Platform'."
        );

        $this->addSql('DROP TABLE transaction_transaction_category');
    }
}
