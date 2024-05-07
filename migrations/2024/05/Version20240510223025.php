<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240510223025 extends AbstractMigration {
    public function getDescription() : string {
        return '';
    }

    public function up(Schema $schema) : void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE archdeaconry DROP FOREIGN KEY FK_36CE5E07B600009');
        $this->addSql('ALTER TABLE archdeaconry ADD CONSTRAINT FK_36CE5E07B600009 FOREIGN KEY (diocese_id) REFERENCES diocese (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A33153033E82');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33153033E82 FOREIGN KEY (monarch_id) REFERENCES monarch (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE county DROP FOREIGN KEY FK_58E2FF25AE3899');
        $this->addSql('ALTER TABLE county ADD CONSTRAINT FK_58E2FF25AE3899 FOREIGN KEY (nation_id) REFERENCES nation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE diocese DROP FOREIGN KEY FK_8849E742E946114A');
        $this->addSql('ALTER TABLE diocese ADD CONSTRAINT FK_8849E742E946114A FOREIGN KEY (province_id) REFERENCES province (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE holding DROP FOREIGN KEY FK_5BBFD8168707B11F');
        $this->addSql('ALTER TABLE holding ADD CONSTRAINT FK_5BBFD8168707B11F FOREIGN KEY (parish_id) REFERENCES parish (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE injunction DROP FOREIGN KEY FK_A2FAC1E153033E82');
        $this->addSql('ALTER TABLE injunction DROP FOREIGN KEY FK_A2FAC1E1E946114A');
        $this->addSql('ALTER TABLE injunction DROP FOREIGN KEY FK_A2FAC1E1AE3899');
        $this->addSql('ALTER TABLE injunction DROP FOREIGN KEY FK_A2FAC1E13BEA4CEE');
        $this->addSql('ALTER TABLE injunction DROP FOREIGN KEY FK_A2FAC1E1B600009');
        $this->addSql('ALTER TABLE injunction ADD CONSTRAINT FK_A2FAC1E153033E82 FOREIGN KEY (monarch_id) REFERENCES monarch (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE injunction ADD CONSTRAINT FK_A2FAC1E1E946114A FOREIGN KEY (province_id) REFERENCES province (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE injunction ADD CONSTRAINT FK_A2FAC1E1AE3899 FOREIGN KEY (nation_id) REFERENCES nation (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE injunction ADD CONSTRAINT FK_A2FAC1E13BEA4CEE FOREIGN KEY (archdeaconry_id) REFERENCES archdeaconry (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE injunction ADD CONSTRAINT FK_A2FAC1E1B600009 FOREIGN KEY (diocese_id) REFERENCES diocese (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A3653033E82');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36320375DF');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A368707B11F');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36E75A3578');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A3653033E82 FOREIGN KEY (monarch_id) REFERENCES monarch (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36320375DF FOREIGN KEY (manuscript_source_id) REFERENCES manuscript_source (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A368707B11F FOREIGN KEY (parish_id) REFERENCES parish (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36E75A3578 FOREIGN KEY (print_source_id) REFERENCES print_source (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE manuscript_source DROP FOREIGN KEY FK_5F8A7F732956195F');
        $this->addSql('ALTER TABLE manuscript_source DROP FOREIGN KEY FK_5F8A7F732E39CD42');
        $this->addSql('ALTER TABLE manuscript_source ADD CONSTRAINT FK_CE3EE8022E39CD42 FOREIGN KEY (source_category_id) REFERENCES source_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manuscript_source ADD CONSTRAINT FK_CE3EE8022956195F FOREIGN KEY (archive_id) REFERENCES archive (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parish DROP FOREIGN KEY FK_DFF9A9783BEA4CEE');
        $this->addSql('ALTER TABLE parish DROP FOREIGN KEY FK_DFF9A97875E23604');
        $this->addSql('ALTER TABLE parish ADD CONSTRAINT FK_DFF9A9783BEA4CEE FOREIGN KEY (archdeaconry_id) REFERENCES archdeaconry (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parish ADD CONSTRAINT FK_DFF9A97875E23604 FOREIGN KEY (town_id) REFERENCES town (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE print_source DROP FOREIGN KEY FK_534D01C12E39CD42');
        $this->addSql('ALTER TABLE print_source ADD CONSTRAINT FK_534D01C12E39CD42 FOREIGN KEY (source_category_id) REFERENCES source_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE province DROP FOREIGN KEY FK_4ADAD40BAE3899');
        $this->addSql('ALTER TABLE province ADD CONSTRAINT FK_4ADAD40BAE3899 FOREIGN KEY (nation_id) REFERENCES nation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE town DROP FOREIGN KEY FK_4CE6C7A485E73F45');
        $this->addSql('ALTER TABLE town ADD CONSTRAINT FK_4CE6C7A485E73F45 FOREIGN KEY (county_id) REFERENCES county (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transact DROP FOREIGN KEY FK_FA42B7F653033E82');
        $this->addSql('ALTER TABLE transact DROP FOREIGN KEY FK_FA42B7F6320375DF');
        $this->addSql('ALTER TABLE transact DROP FOREIGN KEY FK_FA42B7F68707B11F');
        $this->addSql('ALTER TABLE transact DROP FOREIGN KEY FK_FA42B7F6E75A3578');
        $this->addSql('ALTER TABLE transact ADD CONSTRAINT FK_FA42B7F653033E82 FOREIGN KEY (monarch_id) REFERENCES monarch (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE transact ADD CONSTRAINT FK_FA42B7F6320375DF FOREIGN KEY (manuscript_source_id) REFERENCES manuscript_source (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE transact ADD CONSTRAINT FK_FA42B7F68707B11F FOREIGN KEY (parish_id) REFERENCES parish (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transact ADD CONSTRAINT FK_FA42B7F6E75A3578 FOREIGN KEY (print_source_id) REFERENCES print_source (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE transaction_transaction_category DROP FOREIGN KEY FK_7F5D163D2FC0CB0F');
        $this->addSql('ALTER TABLE transaction_transaction_category ADD CONSTRAINT FK_7F5D163D2FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transact (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE archdeaconry DROP FOREIGN KEY FK_36CE5E07B600009');
        $this->addSql('ALTER TABLE archdeaconry ADD CONSTRAINT FK_36CE5E07B600009 FOREIGN KEY (diocese_id) REFERENCES diocese (id)');
        $this->addSql('ALTER TABLE holding DROP FOREIGN KEY FK_5BBFD8168707B11F');
        $this->addSql('ALTER TABLE holding ADD CONSTRAINT FK_5BBFD8168707B11F FOREIGN KEY (parish_id) REFERENCES parish (id)');
        $this->addSql('ALTER TABLE transaction_transaction_category DROP FOREIGN KEY FK_7F5D163D2FC0CB0F');
        $this->addSql('ALTER TABLE transaction_transaction_category ADD CONSTRAINT FK_7F5D163D2FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transact (id)');
        $this->addSql('ALTER TABLE injunction DROP FOREIGN KEY FK_A2FAC1E1AE3899');
        $this->addSql('ALTER TABLE injunction DROP FOREIGN KEY FK_A2FAC1E1B600009');
        $this->addSql('ALTER TABLE injunction DROP FOREIGN KEY FK_A2FAC1E1E946114A');
        $this->addSql('ALTER TABLE injunction DROP FOREIGN KEY FK_A2FAC1E13BEA4CEE');
        $this->addSql('ALTER TABLE injunction DROP FOREIGN KEY FK_A2FAC1E153033E82');
        $this->addSql('ALTER TABLE injunction ADD CONSTRAINT FK_A2FAC1E1AE3899 FOREIGN KEY (nation_id) REFERENCES nation (id)');
        $this->addSql('ALTER TABLE injunction ADD CONSTRAINT FK_A2FAC1E1B600009 FOREIGN KEY (diocese_id) REFERENCES diocese (id)');
        $this->addSql('ALTER TABLE injunction ADD CONSTRAINT FK_A2FAC1E1E946114A FOREIGN KEY (province_id) REFERENCES province (id)');
        $this->addSql('ALTER TABLE injunction ADD CONSTRAINT FK_A2FAC1E13BEA4CEE FOREIGN KEY (archdeaconry_id) REFERENCES archdeaconry (id)');
        $this->addSql('ALTER TABLE injunction ADD CONSTRAINT FK_A2FAC1E153033E82 FOREIGN KEY (monarch_id) REFERENCES monarch (id)');
        $this->addSql('ALTER TABLE transact DROP FOREIGN KEY FK_FA42B7F68707B11F');
        $this->addSql('ALTER TABLE transact DROP FOREIGN KEY FK_FA42B7F6320375DF');
        $this->addSql('ALTER TABLE transact DROP FOREIGN KEY FK_FA42B7F6E75A3578');
        $this->addSql('ALTER TABLE transact DROP FOREIGN KEY FK_FA42B7F653033E82');
        $this->addSql('ALTER TABLE transact ADD CONSTRAINT FK_FA42B7F68707B11F FOREIGN KEY (parish_id) REFERENCES parish (id)');
        $this->addSql('ALTER TABLE transact ADD CONSTRAINT FK_FA42B7F6320375DF FOREIGN KEY (manuscript_source_id) REFERENCES manuscript_source (id)');
        $this->addSql('ALTER TABLE transact ADD CONSTRAINT FK_FA42B7F6E75A3578 FOREIGN KEY (print_source_id) REFERENCES print_source (id)');
        $this->addSql('ALTER TABLE transact ADD CONSTRAINT FK_FA42B7F653033E82 FOREIGN KEY (monarch_id) REFERENCES monarch (id)');
        $this->addSql('ALTER TABLE parish DROP FOREIGN KEY FK_DFF9A9783BEA4CEE');
        $this->addSql('ALTER TABLE parish DROP FOREIGN KEY FK_DFF9A97875E23604');
        $this->addSql('ALTER TABLE parish ADD CONSTRAINT FK_DFF9A9783BEA4CEE FOREIGN KEY (archdeaconry_id) REFERENCES archdeaconry (id)');
        $this->addSql('ALTER TABLE parish ADD CONSTRAINT FK_DFF9A97875E23604 FOREIGN KEY (town_id) REFERENCES town (id)');
        $this->addSql('ALTER TABLE county DROP FOREIGN KEY FK_58E2FF25AE3899');
        $this->addSql('ALTER TABLE county ADD CONSTRAINT FK_58E2FF25AE3899 FOREIGN KEY (nation_id) REFERENCES nation (id)');
        $this->addSql('ALTER TABLE province DROP FOREIGN KEY FK_4ADAD40BAE3899');
        $this->addSql('ALTER TABLE province ADD CONSTRAINT FK_4ADAD40BAE3899 FOREIGN KEY (nation_id) REFERENCES nation (id)');
        $this->addSql('ALTER TABLE print_source DROP FOREIGN KEY FK_534D01C12E39CD42');
        $this->addSql('ALTER TABLE print_source ADD CONSTRAINT FK_534D01C12E39CD42 FOREIGN KEY (source_category_id) REFERENCES source_category (id)');
        $this->addSql('ALTER TABLE diocese DROP FOREIGN KEY FK_8849E742E946114A');
        $this->addSql('ALTER TABLE diocese ADD CONSTRAINT FK_8849E742E946114A FOREIGN KEY (province_id) REFERENCES province (id)');
        $this->addSql('ALTER TABLE town DROP FOREIGN KEY FK_4CE6C7A485E73F45');
        $this->addSql('ALTER TABLE town ADD CONSTRAINT FK_4CE6C7A485E73F45 FOREIGN KEY (county_id) REFERENCES county (id)');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36320375DF');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36E75A3578');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A368707B11F');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A3653033E82');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36320375DF FOREIGN KEY (manuscript_source_id) REFERENCES manuscript_source (id)');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36E75A3578 FOREIGN KEY (print_source_id) REFERENCES print_source (id)');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A368707B11F FOREIGN KEY (parish_id) REFERENCES parish (id)');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A3653033E82 FOREIGN KEY (monarch_id) REFERENCES monarch (id)');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A33153033E82');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33153033E82 FOREIGN KEY (monarch_id) REFERENCES monarch (id)');
        $this->addSql('ALTER TABLE manuscript_source DROP FOREIGN KEY FK_CE3EE8022E39CD42');
        $this->addSql('ALTER TABLE manuscript_source DROP FOREIGN KEY FK_CE3EE8022956195F');
        $this->addSql('ALTER TABLE manuscript_source ADD CONSTRAINT FK_5F8A7F732956195F FOREIGN KEY (archive_id) REFERENCES archive (id)');
        $this->addSql('ALTER TABLE manuscript_source ADD CONSTRAINT FK_5F8A7F732E39CD42 FOREIGN KEY (source_category_id) REFERENCES source_category (id)');
    }
}
