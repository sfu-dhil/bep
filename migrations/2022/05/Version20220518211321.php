<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220518211321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('RENAME TABLE source TO manuscript_source');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36953C1C61');
        $this->addSql('DROP INDEX IDX_B12D4A36953C1C61 ON inventory');
        $this->addSql('ALTER TABLE inventory CHANGE source_id manuscript_source_id INT NOT NULL');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36320375DF FOREIGN KEY (manuscript_source_id) REFERENCES manuscript_source (id)');
        $this->addSql('CREATE INDEX IDX_B12D4A36320375DF ON inventory (manuscript_source_id)');
        $this->addSql('ALTER TABLE manuscript_source DROP FOREIGN KEY FK_5F8A7F732956195F');
        $this->addSql('ALTER TABLE manuscript_source DROP FOREIGN KEY FK_5F8A7F732E39CD42');
        $this->addSql('ALTER TABLE manuscript_source CHANGE name name VARCHAR(191) NOT NULL');
        $this->addSql('DROP INDEX idx_5f8a7f732e39cd42 ON manuscript_source');
        $this->addSql('CREATE INDEX IDX_CE3EE8022E39CD42 ON manuscript_source (source_category_id)');
        $this->addSql('DROP INDEX idx_5f8a7f732956195f ON manuscript_source');
        $this->addSql('CREATE INDEX IDX_CE3EE8022956195F ON manuscript_source (archive_id)');
        $this->addSql('DROP INDEX idx_5f8a7f73ea750e8 ON manuscript_source');
        $this->addSql('CREATE FULLTEXT INDEX IDX_CE3EE802EA750E8 ON manuscript_source (label)');
        $this->addSql('DROP INDEX idx_5f8a7f736de44026 ON manuscript_source');
        $this->addSql('CREATE FULLTEXT INDEX IDX_CE3EE8026DE44026 ON manuscript_source (description)');
        $this->addSql('DROP INDEX idx_5f8a7f73ea750e86de44026 ON manuscript_source');
        $this->addSql('CREATE FULLTEXT INDEX IDX_CE3EE802EA750E86DE44026 ON manuscript_source (label, description)');
        $this->addSql('DROP INDEX uniq_5f8a7f735e237e06 ON manuscript_source');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CE3EE8025E237E06 ON manuscript_source (name)');
        $this->addSql('ALTER TABLE manuscript_source ADD CONSTRAINT FK_5F8A7F732956195F FOREIGN KEY (archive_id) REFERENCES archive (id)');
        $this->addSql('ALTER TABLE manuscript_source ADD CONSTRAINT FK_5F8A7F732E39CD42 FOREIGN KEY (source_category_id) REFERENCES source_category (id)');
        $this->addSql('ALTER TABLE transact DROP FOREIGN KEY FK_FA42B7F6953C1C61');
        $this->addSql('DROP INDEX IDX_FA42B7F6953C1C61 ON transact');
        $this->addSql('ALTER TABLE transact CHANGE source_id manuscript_source_id INT NOT NULL');
        $this->addSql('ALTER TABLE transact ADD CONSTRAINT FK_FA42B7F6320375DF FOREIGN KEY (manuscript_source_id) REFERENCES manuscript_source (id)');
        $this->addSql('CREATE INDEX IDX_FA42B7F6320375DF ON transact (manuscript_source_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('RENAME TABLE manuscript_source TO source');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36320375DF');
        $this->addSql('DROP INDEX IDX_B12D4A36320375DF ON inventory');
        $this->addSql('ALTER TABLE inventory CHANGE manuscript_source_id source_id INT NOT NULL');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36953C1C61 FOREIGN KEY (source_id) REFERENCES manuscript_source (id)');
        $this->addSql('CREATE INDEX IDX_B12D4A36953C1C61 ON inventory (source_id)');
        $this->addSql('ALTER TABLE manuscript_source DROP FOREIGN KEY FK_CE3EE8022E39CD42');
        $this->addSql('ALTER TABLE manuscript_source DROP FOREIGN KEY FK_CE3EE8022956195F');
        $this->addSql('ALTER TABLE manuscript_source CHANGE name name VARCHAR(200) NOT NULL');
        $this->addSql('DROP INDEX idx_ce3ee8022956195f ON manuscript_source');
        $this->addSql('CREATE INDEX IDX_5F8A7F732956195F ON manuscript_source (archive_id)');
        $this->addSql('DROP INDEX idx_ce3ee802ea750e8 ON manuscript_source');
        $this->addSql('CREATE FULLTEXT INDEX IDX_5F8A7F73EA750E8 ON manuscript_source (label)');
        $this->addSql('DROP INDEX uniq_ce3ee8025e237e06 ON manuscript_source');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5F8A7F735E237E06 ON manuscript_source (name)');
        $this->addSql('DROP INDEX idx_ce3ee8026de44026 ON manuscript_source');
        $this->addSql('CREATE FULLTEXT INDEX IDX_5F8A7F736DE44026 ON manuscript_source (description)');
        $this->addSql('DROP INDEX idx_ce3ee8022e39cd42 ON manuscript_source');
        $this->addSql('CREATE INDEX IDX_5F8A7F732E39CD42 ON manuscript_source (source_category_id)');
        $this->addSql('DROP INDEX idx_ce3ee802ea750e86de44026 ON manuscript_source');
        $this->addSql('CREATE FULLTEXT INDEX IDX_5F8A7F73EA750E86DE44026 ON manuscript_source (label, description)');
        $this->addSql('ALTER TABLE manuscript_source ADD CONSTRAINT FK_CE3EE8022E39CD42 FOREIGN KEY (source_category_id) REFERENCES source_category (id)');
        $this->addSql('ALTER TABLE manuscript_source ADD CONSTRAINT FK_CE3EE8022956195F FOREIGN KEY (archive_id) REFERENCES archive (id)');
        $this->addSql('ALTER TABLE transact DROP FOREIGN KEY FK_FA42B7F6320375DF');
        $this->addSql('DROP INDEX IDX_FA42B7F6320375DF ON transact');
        $this->addSql('ALTER TABLE transact CHANGE manuscript_source_id source_id INT NOT NULL');
        $this->addSql('ALTER TABLE transact ADD CONSTRAINT FK_FA42B7F6953C1C61 FOREIGN KEY (source_id) REFERENCES manuscript_source (id)');
        $this->addSql('CREATE INDEX IDX_FA42B7F6953C1C61 ON transact (source_id)');
    }
}
