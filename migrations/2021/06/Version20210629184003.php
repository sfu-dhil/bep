<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210629184003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transaction_transaction_category (transaction_id INT NOT NULL, transaction_category_id INT NOT NULL, INDEX IDX_7F5D163D2FC0CB0F (transaction_id), INDEX IDX_7F5D163DAECF88CF (transaction_category_id), PRIMARY KEY(transaction_id, transaction_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction_transaction_category ADD CONSTRAINT FK_7F5D163D2FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transaction_transaction_category ADD CONSTRAINT FK_7F5D163DAECF88CF FOREIGN KEY (transaction_category_id) REFERENCES transaction_category (id) ON DELETE CASCADE');
        $this->addSql('insert into transaction_transaction_category(transaction_id, transaction_category_id) select t.id, t.transaction_category_id from transact t');
        $this->addSql('ALTER TABLE transact DROP FOREIGN KEY FK_FA42B7F6AECF88CF');
        $this->addSql('DROP INDEX IDX_FA42B7F6AECF88CF ON transact');
        $this->addSql('ALTER TABLE transact DROP transaction_category_id');
    }

    public function down(Schema $schema): void
    {
        $this->throwIrreversibleMigrationException();
    }
}
