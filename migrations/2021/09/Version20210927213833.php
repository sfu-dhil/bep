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
final class Version20210927213833 extends AbstractMigration {
    public function getDescription() : string {
        return '';
    }

    public function up(Schema $schema) : void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'ENDSQL'
                ALTER TABLE injunction 
                    ADD uniform_title LONGTEXT DEFAULT NULL, 
                    ADD variant_titles LONGTEXT NOT NULL COMMENT '(DC2Type:array)' DEFAULT 'a:0:{}', 
                    ADD author VARCHAR(160) DEFAULT NULL, 
                    ADD imprint LONGTEXT DEFAULT NULL, 
                    ADD variant_imprint LONGTEXT DEFAULT NULL, 
                    CHANGE `year` `date` VARCHAR(12) NULL DEFAULT NULL 
            ENDSQL);
    }

    public function down(Schema $schema) : void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE injunction ADD year INT DEFAULT NULL, DROP uniform_title, DROP variant_titles, DROP author, DROP imprint, DROP variant_imprint, DROP date');
    }
}
