<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509214529 extends AbstractMigration {
    public function getDescription() : string {
        return '';
    }

    public function up(Schema $schema) : void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nines_blog_page DROP FOREIGN KEY FK_F4DA3AB0A76ED395');
        $this->addSql('ALTER TABLE nines_blog_page ADD CONSTRAINT FK_23FD24C7A76ED395 FOREIGN KEY (user_id) REFERENCES nines_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nines_blog_post DROP FOREIGN KEY FK_BA5AE01D6BF700BD');
        $this->addSql('ALTER TABLE nines_blog_post DROP FOREIGN KEY FK_BA5AE01DA76ED395');
        $this->addSql('ALTER TABLE nines_blog_post DROP FOREIGN KEY FK_BA5AE01D12469DE2');
        $this->addSql('ALTER TABLE nines_blog_post ADD CONSTRAINT FK_6D7DFE6A12469DE2 FOREIGN KEY (category_id) REFERENCES nines_blog_post_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nines_blog_post ADD CONSTRAINT FK_6D7DFE6A6BF700BD FOREIGN KEY (status_id) REFERENCES nines_blog_post_status (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nines_blog_post ADD CONSTRAINT FK_6D7DFE6AA76ED395 FOREIGN KEY (user_id) REFERENCES nines_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nines_media_audio ADD checksum VARCHAR(32) DEFAULT NULL, ADD source_url LONGTEXT DEFAULT NULL, DROP public');
        $this->addSql('CREATE INDEX IDX_9D15F751DE6FDF9A ON nines_media_audio (checksum)');
        $this->addSql('CREATE FULLTEXT INDEX IDX_9D15F751A58240EF ON nines_media_audio (source_url)');
        $this->addSql('ALTER TABLE nines_media_image ADD checksum VARCHAR(32) DEFAULT NULL, ADD source_url LONGTEXT DEFAULT NULL, DROP public');
        $this->addSql('CREATE INDEX IDX_4055C59BDE6FDF9A ON nines_media_image (checksum)');
        $this->addSql('CREATE FULLTEXT INDEX IDX_4055C59BA58240EF ON nines_media_image (source_url)');
        $this->addSql('ALTER TABLE nines_media_pdf ADD checksum VARCHAR(32) DEFAULT NULL, ADD source_url LONGTEXT DEFAULT NULL, DROP public');
        $this->addSql('CREATE INDEX IDX_9286B706DE6FDF9A ON nines_media_pdf (checksum)');
        $this->addSql('CREATE FULLTEXT INDEX IDX_9286B706A58240EF ON nines_media_pdf (source_url)');
        $this->addSql('ALTER TABLE transaction_transaction_category DROP FOREIGN KEY FK_7F5D163D2FC0CB0F');
        $this->addSql('ALTER TABLE transaction_transaction_category ADD CONSTRAINT FK_7F5D163D2FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transact (id)');
    }

    public function down(Schema $schema) : void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_4055C59BDE6FDF9A ON nines_media_image');
        $this->addSql('DROP INDEX IDX_4055C59BA58240EF ON nines_media_image');
        $this->addSql('ALTER TABLE nines_media_image ADD public TINYINT(1) NOT NULL, DROP checksum, DROP source_url');
        $this->addSql('ALTER TABLE nines_blog_post DROP FOREIGN KEY FK_6D7DFE6A12469DE2');
        $this->addSql('ALTER TABLE nines_blog_post DROP FOREIGN KEY FK_6D7DFE6A6BF700BD');
        $this->addSql('ALTER TABLE nines_blog_post DROP FOREIGN KEY FK_6D7DFE6AA76ED395');
        $this->addSql('ALTER TABLE nines_blog_post ADD CONSTRAINT FK_BA5AE01D6BF700BD FOREIGN KEY (status_id) REFERENCES nines_blog_post_status (id)');
        $this->addSql('ALTER TABLE nines_blog_post ADD CONSTRAINT FK_BA5AE01DA76ED395 FOREIGN KEY (user_id) REFERENCES nines_user (id)');
        $this->addSql('ALTER TABLE nines_blog_post ADD CONSTRAINT FK_BA5AE01D12469DE2 FOREIGN KEY (category_id) REFERENCES nines_blog_post_category (id)');
        $this->addSql('DROP INDEX IDX_9D15F751DE6FDF9A ON nines_media_audio');
        $this->addSql('DROP INDEX IDX_9D15F751A58240EF ON nines_media_audio');
        $this->addSql('ALTER TABLE nines_media_audio ADD public TINYINT(1) NOT NULL, DROP checksum, DROP source_url');
        $this->addSql('ALTER TABLE transaction_transaction_category DROP FOREIGN KEY FK_7F5D163D2FC0CB0F');
        $this->addSql('ALTER TABLE transaction_transaction_category ADD CONSTRAINT FK_7F5D163D2FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transact (id) ON DELETE CASCADE');
        $this->addSql('DROP INDEX IDX_9286B706DE6FDF9A ON nines_media_pdf');
        $this->addSql('DROP INDEX IDX_9286B706A58240EF ON nines_media_pdf');
        $this->addSql('ALTER TABLE nines_media_pdf ADD public TINYINT(1) NOT NULL, DROP checksum, DROP source_url');
        $this->addSql('ALTER TABLE nines_blog_page DROP FOREIGN KEY FK_23FD24C7A76ED395');
        $this->addSql('ALTER TABLE nines_blog_page ADD CONSTRAINT FK_F4DA3AB0A76ED395 FOREIGN KEY (user_id) REFERENCES nines_user (id)');
    }
}
