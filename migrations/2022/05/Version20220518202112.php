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
final class Version20220518202112 extends AbstractMigration {
    public function getDescription() : string {
        return '';
    }

    public function up(Schema $schema) : void {
        $this->addSql('ALTER TABLE archdeaconry CHANGE name name VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE archive CHANGE name name VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE county CHANGE name name VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE diocese CHANGE name name VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE format CHANGE name name VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE monarch CHANGE name name VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE nation CHANGE name name VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE nines_blog_post_category CHANGE name name VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE nines_blog_post_status CHANGE name name VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE nines_media_link CHANGE text text VARCHAR(191) DEFAULT NULL');
        $this->addSql('ALTER TABLE parish CHANGE name name VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE province CHANGE name name VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE source_category CHANGE name name VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE town CHANGE name name VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE transaction_category CHANGE name name VARCHAR(191) NOT NULL');
    }

    public function down(Schema $schema) : void {
    }
}
