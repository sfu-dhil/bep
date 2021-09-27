<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210927220325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX injunction_ft ON injunction');
        $this->addSql('CREATE FULLTEXT INDEX injunction_ft ON injunction (title, uniform_title, variant_titles, description, author, imprint, variant_imprint)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX injunction_ft ON injunction');
        $this->addSql('CREATE FULLTEXT INDEX injunction_ft ON injunction (title, description, estc)');
    }
}
