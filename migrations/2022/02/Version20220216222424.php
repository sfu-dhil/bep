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
final class Version20220216222424 extends AbstractMigration {
    public function getDescription() : string {
        return '';
    }

    public function up(Schema $schema) : void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE archdeaconry CHANGE name name VARCHAR(200) NOT NULL, CHANGE label label VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE archive CHANGE name name VARCHAR(200) NOT NULL, CHANGE label label VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE county CHANGE name name VARCHAR(200) NOT NULL, CHANGE label label VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE diocese CHANGE name name VARCHAR(200) NOT NULL, CHANGE label label VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE format CHANGE name name VARCHAR(200) NOT NULL, CHANGE label label VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE monarch CHANGE name name VARCHAR(200) NOT NULL, CHANGE label label VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE nation CHANGE name name VARCHAR(200) NOT NULL, CHANGE label label VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE nines_blog_page DROP FOREIGN KEY FK_F4DA3AB0A76ED395');
        $this->addSql('DROP INDEX idx_f4da3ab0a76ed395 ON nines_blog_page');
        $this->addSql('CREATE INDEX IDX_23FD24C7A76ED395 ON nines_blog_page (user_id)');
        $this->addSql('DROP INDEX blog_page_content ON nines_blog_page');
        $this->addSql('CREATE FULLTEXT INDEX blog_page_ft ON nines_blog_page (title, searchable)');
        $this->addSql('ALTER TABLE nines_blog_page ADD CONSTRAINT FK_F4DA3AB0A76ED395 FOREIGN KEY (user_id) REFERENCES nines_user (id)');
        $this->addSql('ALTER TABLE nines_blog_post DROP FOREIGN KEY FK_BA5AE01D12469DE2');
        $this->addSql('ALTER TABLE nines_blog_post DROP FOREIGN KEY FK_BA5AE01DA76ED395');
        $this->addSql('ALTER TABLE nines_blog_post DROP FOREIGN KEY FK_BA5AE01D6BF700BD');
        $this->addSql('DROP INDEX idx_ba5ae01d12469de2 ON nines_blog_post');
        $this->addSql('CREATE INDEX IDX_6D7DFE6A12469DE2 ON nines_blog_post (category_id)');
        $this->addSql('DROP INDEX idx_ba5ae01d6bf700bd ON nines_blog_post');
        $this->addSql('CREATE INDEX IDX_6D7DFE6A6BF700BD ON nines_blog_post (status_id)');
        $this->addSql('DROP INDEX idx_ba5ae01da76ed395 ON nines_blog_post');
        $this->addSql('CREATE INDEX IDX_6D7DFE6AA76ED395 ON nines_blog_post (user_id)');
        $this->addSql('DROP INDEX blog_post_content ON nines_blog_post');
        $this->addSql('CREATE FULLTEXT INDEX blog_post_ft ON nines_blog_post (title, searchable)');
        $this->addSql('ALTER TABLE nines_blog_post ADD CONSTRAINT FK_BA5AE01D12469DE2 FOREIGN KEY (category_id) REFERENCES nines_blog_post_category (id)');
        $this->addSql('ALTER TABLE nines_blog_post ADD CONSTRAINT FK_BA5AE01DA76ED395 FOREIGN KEY (user_id) REFERENCES nines_user (id)');
        $this->addSql('ALTER TABLE nines_blog_post ADD CONSTRAINT FK_BA5AE01D6BF700BD FOREIGN KEY (status_id) REFERENCES nines_blog_post_status (id)');
        $this->addSql('ALTER TABLE nines_blog_post_category CHANGE name name VARCHAR(200) NOT NULL, CHANGE label label VARCHAR(200) NOT NULL');
        $this->addSql('DROP INDEX idx_ca275a0cea750e8 ON nines_blog_post_category');
        $this->addSql('CREATE FULLTEXT INDEX IDX_32F5FC8CEA750E8 ON nines_blog_post_category (label)');
        $this->addSql('DROP INDEX idx_ca275a0c6de44026 ON nines_blog_post_category');
        $this->addSql('CREATE FULLTEXT INDEX IDX_32F5FC8C6DE44026 ON nines_blog_post_category (description)');
        $this->addSql('DROP INDEX idx_ca275a0cea750e86de44026 ON nines_blog_post_category');
        $this->addSql('CREATE FULLTEXT INDEX IDX_32F5FC8CEA750E86DE44026 ON nines_blog_post_category (label, description)');
        $this->addSql('DROP INDEX uniq_ca275a0c5e237e06 ON nines_blog_post_category');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_32F5FC8C5E237E06 ON nines_blog_post_category (name)');
        $this->addSql('ALTER TABLE nines_blog_post_status CHANGE name name VARCHAR(200) NOT NULL, CHANGE label label VARCHAR(200) NOT NULL');
        $this->addSql('DROP INDEX idx_92121d87ea750e8 ON nines_blog_post_status');
        $this->addSql('CREATE FULLTEXT INDEX IDX_4A63E2FDEA750E8 ON nines_blog_post_status (label)');
        $this->addSql('DROP INDEX idx_92121d876de44026 ON nines_blog_post_status');
        $this->addSql('CREATE FULLTEXT INDEX IDX_4A63E2FD6DE44026 ON nines_blog_post_status (description)');
        $this->addSql('DROP INDEX idx_92121d87ea750e86de44026 ON nines_blog_post_status');
        $this->addSql('CREATE FULLTEXT INDEX IDX_4A63E2FDEA750E86DE44026 ON nines_blog_post_status (label, description)');
        $this->addSql('DROP INDEX uniq_92121d875e237e06 ON nines_blog_post_status');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4A63E2FD5E237E06 ON nines_blog_post_status (name)');
        $this->addSql('ALTER TABLE nines_media_audio CHANGE entity entity VARCHAR(120) NOT NULL');
        $this->addSql('CREATE FULLTEXT INDEX nines_media_audio_ft ON nines_media_audio (original_name, description)');
        $this->addSql('CREATE INDEX IDX_9D15F751E284468 ON nines_media_audio (entity)');
        $this->addSql('ALTER TABLE nines_media_image CHANGE entity entity VARCHAR(120) NOT NULL');
        $this->addSql('CREATE INDEX IDX_4055C59BE284468 ON nines_media_image (entity)');
        $this->addSql('DROP INDEX idx_c53d045f545615306de44026 ON nines_media_image');
        $this->addSql('CREATE FULLTEXT INDEX nines_media_image_ft ON nines_media_image (original_name, description)');
        $this->addSql('ALTER TABLE nines_media_link CHANGE entity entity VARCHAR(120) NOT NULL');
        $this->addSql('DROP INDEX idx_36ac99f1f47645ae3b8ba7c7 ON nines_media_link');
        $this->addSql('CREATE FULLTEXT INDEX nines_media_link_ft ON nines_media_link (url, text)');
        $this->addSql('DROP INDEX idx_36ac99f1e284468 ON nines_media_link');
        $this->addSql('CREATE INDEX IDX_3B5D85A3E284468 ON nines_media_link (entity)');
        $this->addSql('ALTER TABLE nines_media_pdf CHANGE entity entity VARCHAR(120) NOT NULL');
        $this->addSql('CREATE INDEX IDX_9286B706E284468 ON nines_media_pdf (entity)');
        $this->addSql('DROP INDEX idx_ef0db8c545615306de44026 ON nines_media_pdf');
        $this->addSql('CREATE FULLTEXT INDEX nines_media_pdf_ft ON nines_media_pdf (original_name, description)');
        $this->addSql('ALTER TABLE parish CHANGE name name VARCHAR(200) NOT NULL, CHANGE label label VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE province CHANGE name name VARCHAR(200) NOT NULL, CHANGE label label VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE source CHANGE name name VARCHAR(200) NOT NULL, CHANGE label label VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE source_category CHANGE name name VARCHAR(200) NOT NULL, CHANGE label label VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE town CHANGE name name VARCHAR(200) NOT NULL, CHANGE label label VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE transaction_category CHANGE name name VARCHAR(200) NOT NULL, CHANGE label label VARCHAR(200) NOT NULL');
    }

    public function down(Schema $schema) : void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE archdeaconry CHANGE name name VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE label label VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE archive CHANGE name name VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE label label VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE book CHANGE title title LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE uniform_title uniform_title LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE variant_titles variant_titles LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE author author VARCHAR(160) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE imprint imprint LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE variant_imprint variant_imprint LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE estc estc VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date date VARCHAR(12) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE physical_description physical_description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE notes notes LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE county CHANGE name name VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE label label VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE diocese CHANGE name name VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE label label VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE format CHANGE name name VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE label label VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE holding CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE start_date start_date VARCHAR(10) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE end_date end_date VARCHAR(10) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE written_date written_date VARCHAR(60) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE notes notes LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE injunction CHANGE title title LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE uniform_title uniform_title LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE variant_titles variant_titles LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE author author VARCHAR(160) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE imprint imprint LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE variant_imprint variant_imprint LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date date VARCHAR(12) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE physical_description physical_description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE estc estc VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE inventory CHANGE page_number page_number LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE transcription transcription LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE modifications modifications LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE start_date start_date VARCHAR(10) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE end_date end_date VARCHAR(10) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE written_date written_date VARCHAR(60) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE notes notes LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE monarch CHANGE name name VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE label label VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE nation CHANGE name name VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE label label VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE nines_blog_page DROP FOREIGN KEY FK_23FD24C7A76ED395');
        $this->addSql('ALTER TABLE nines_blog_page CHANGE title title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE searchable searchable LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE excerpt excerpt LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE content content LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX idx_23fd24c7a76ed395 ON nines_blog_page');
        $this->addSql('CREATE INDEX IDX_F4DA3AB0A76ED395 ON nines_blog_page (user_id)');
        $this->addSql('DROP INDEX blog_page_ft ON nines_blog_page');
        $this->addSql('CREATE FULLTEXT INDEX blog_page_content ON nines_blog_page (title, searchable)');
        $this->addSql('ALTER TABLE nines_blog_page ADD CONSTRAINT FK_23FD24C7A76ED395 FOREIGN KEY (user_id) REFERENCES nines_user (id)');
        $this->addSql('ALTER TABLE nines_blog_post DROP FOREIGN KEY FK_6D7DFE6A12469DE2');
        $this->addSql('ALTER TABLE nines_blog_post DROP FOREIGN KEY FK_6D7DFE6A6BF700BD');
        $this->addSql('ALTER TABLE nines_blog_post DROP FOREIGN KEY FK_6D7DFE6AA76ED395');
        $this->addSql('ALTER TABLE nines_blog_post CHANGE title title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE searchable searchable LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE excerpt excerpt LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE content content LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX idx_6d7dfe6aa76ed395 ON nines_blog_post');
        $this->addSql('CREATE INDEX IDX_BA5AE01DA76ED395 ON nines_blog_post (user_id)');
        $this->addSql('DROP INDEX blog_post_ft ON nines_blog_post');
        $this->addSql('CREATE FULLTEXT INDEX blog_post_content ON nines_blog_post (title, searchable)');
        $this->addSql('DROP INDEX idx_6d7dfe6a12469de2 ON nines_blog_post');
        $this->addSql('CREATE INDEX IDX_BA5AE01D12469DE2 ON nines_blog_post (category_id)');
        $this->addSql('DROP INDEX idx_6d7dfe6a6bf700bd ON nines_blog_post');
        $this->addSql('CREATE INDEX IDX_BA5AE01D6BF700BD ON nines_blog_post (status_id)');
        $this->addSql('ALTER TABLE nines_blog_post ADD CONSTRAINT FK_6D7DFE6A12469DE2 FOREIGN KEY (category_id) REFERENCES nines_blog_post_category (id)');
        $this->addSql('ALTER TABLE nines_blog_post ADD CONSTRAINT FK_6D7DFE6A6BF700BD FOREIGN KEY (status_id) REFERENCES nines_blog_post_status (id)');
        $this->addSql('ALTER TABLE nines_blog_post ADD CONSTRAINT FK_6D7DFE6AA76ED395 FOREIGN KEY (user_id) REFERENCES nines_user (id)');
        $this->addSql('ALTER TABLE nines_blog_post_category CHANGE name name VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE label label VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX idx_32f5fc8c6de44026 ON nines_blog_post_category');
        $this->addSql('CREATE FULLTEXT INDEX IDX_CA275A0C6DE44026 ON nines_blog_post_category (description)');
        $this->addSql('DROP INDEX idx_32f5fc8cea750e86de44026 ON nines_blog_post_category');
        $this->addSql('CREATE FULLTEXT INDEX IDX_CA275A0CEA750E86DE44026 ON nines_blog_post_category (label, description)');
        $this->addSql('DROP INDEX uniq_32f5fc8c5e237e06 ON nines_blog_post_category');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CA275A0C5E237E06 ON nines_blog_post_category (name)');
        $this->addSql('DROP INDEX idx_32f5fc8cea750e8 ON nines_blog_post_category');
        $this->addSql('CREATE FULLTEXT INDEX IDX_CA275A0CEA750E8 ON nines_blog_post_category (label)');
        $this->addSql('ALTER TABLE nines_blog_post_status CHANGE name name VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE label label VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX idx_4a63e2fd6de44026 ON nines_blog_post_status');
        $this->addSql('CREATE FULLTEXT INDEX IDX_92121D876DE44026 ON nines_blog_post_status (description)');
        $this->addSql('DROP INDEX idx_4a63e2fdea750e86de44026 ON nines_blog_post_status');
        $this->addSql('CREATE FULLTEXT INDEX IDX_92121D87EA750E86DE44026 ON nines_blog_post_status (label, description)');
        $this->addSql('DROP INDEX uniq_4a63e2fd5e237e06 ON nines_blog_post_status');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_92121D875E237E06 ON nines_blog_post_status (name)');
        $this->addSql('DROP INDEX idx_4a63e2fdea750e8 ON nines_blog_post_status');
        $this->addSql('CREATE FULLTEXT INDEX IDX_92121D87EA750E8 ON nines_blog_post_status (label)');
        $this->addSql('DROP INDEX nines_media_audio_ft ON nines_media_audio');
        $this->addSql('DROP INDEX IDX_9D15F751E284468 ON nines_media_audio');
        $this->addSql('ALTER TABLE nines_media_audio CHANGE entity entity VARCHAR(128) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE license license LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE original_name original_name VARCHAR(128) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE path path VARCHAR(128) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE mime_type mime_type VARCHAR(64) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX IDX_4055C59BE284468 ON nines_media_image');
        $this->addSql('ALTER TABLE nines_media_image CHANGE thumb_path thumb_path VARCHAR(128) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE entity entity VARCHAR(128) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE license license LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE original_name original_name VARCHAR(128) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE path path VARCHAR(128) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE mime_type mime_type VARCHAR(64) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX nines_media_image_ft ON nines_media_image');
        $this->addSql('CREATE FULLTEXT INDEX IDX_C53D045F545615306DE44026 ON nines_media_image (original_name, description)');
        $this->addSql('ALTER TABLE nines_media_link CHANGE url url VARCHAR(500) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE text text VARCHAR(200) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE entity entity VARCHAR(128) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX idx_3b5d85a3e284468 ON nines_media_link');
        $this->addSql('CREATE INDEX IDX_36AC99F1E284468 ON nines_media_link (entity)');
        $this->addSql('DROP INDEX nines_media_link_ft ON nines_media_link');
        $this->addSql('CREATE FULLTEXT INDEX IDX_36AC99F1F47645AE3B8BA7C7 ON nines_media_link (url, text)');
        $this->addSql('DROP INDEX IDX_9286B706E284468 ON nines_media_pdf');
        $this->addSql('ALTER TABLE nines_media_pdf CHANGE thumb_path thumb_path VARCHAR(128) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE entity entity VARCHAR(128) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE license license LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE original_name original_name VARCHAR(128) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE path path VARCHAR(128) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE mime_type mime_type VARCHAR(64) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX nines_media_pdf_ft ON nines_media_pdf');
        $this->addSql('CREATE FULLTEXT INDEX IDX_EF0DB8C545615306DE44026 ON nines_media_pdf (original_name, description)');
        $this->addSql('ALTER TABLE nines_user CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE reset_token reset_token VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE fullname fullname VARCHAR(64) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE affiliation affiliation VARCHAR(64) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE parish CHANGE name name VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE label label VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE address address LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE province CHANGE name name VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE label label VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE source CHANGE name name VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE label label VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE call_number call_number VARCHAR(64) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE source_category CHANGE name name VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE label label VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE town CHANGE name name VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE label label VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE transact CHANGE location location VARCHAR(160) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE page page VARCHAR(24) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE transcription transcription LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE modern_transcription modern_transcription LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE public_notes public_notes LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE start_date start_date VARCHAR(10) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE end_date end_date VARCHAR(10) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE written_date written_date VARCHAR(60) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE notes notes LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE transaction_category CHANGE name name VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE label label VARCHAR(120) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
