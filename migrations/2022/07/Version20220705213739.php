<?php

declare(strict_types=1);

/*
 * (c) 2022 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705213739 extends AbstractMigration {
    public function getDescription() : string {
        return '';
    }

    public function up(Schema $schema) : void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE injunction ADD nation_id INT DEFAULT NULL, ADD diocese_id INT DEFAULT NULL, ADD province_id INT DEFAULT NULL, ADD archdeaconry_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE injunction ADD CONSTRAINT FK_A2FAC1E1AE3899 FOREIGN KEY (nation_id) REFERENCES nation (id)');
        $this->addSql('ALTER TABLE injunction ADD CONSTRAINT FK_A2FAC1E1B600009 FOREIGN KEY (diocese_id) REFERENCES diocese (id)');
        $this->addSql('ALTER TABLE injunction ADD CONSTRAINT FK_A2FAC1E1E946114A FOREIGN KEY (province_id) REFERENCES province (id)');
        $this->addSql('ALTER TABLE injunction ADD CONSTRAINT FK_A2FAC1E13BEA4CEE FOREIGN KEY (archdeaconry_id) REFERENCES archdeaconry (id)');
        $this->addSql('CREATE INDEX IDX_A2FAC1E1AE3899 ON injunction (nation_id)');
        $this->addSql('CREATE INDEX IDX_A2FAC1E1B600009 ON injunction (diocese_id)');
        $this->addSql('CREATE INDEX IDX_A2FAC1E1E946114A ON injunction (province_id)');
        $this->addSql('CREATE INDEX IDX_A2FAC1E13BEA4CEE ON injunction (archdeaconry_id)');
    }

    public function down(Schema $schema) : void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE injunction DROP FOREIGN KEY FK_A2FAC1E1AE3899');
        $this->addSql('ALTER TABLE injunction DROP FOREIGN KEY FK_A2FAC1E1B600009');
        $this->addSql('ALTER TABLE injunction DROP FOREIGN KEY FK_A2FAC1E1E946114A');
        $this->addSql('ALTER TABLE injunction DROP FOREIGN KEY FK_A2FAC1E13BEA4CEE');
        $this->addSql('DROP INDEX IDX_A2FAC1E1AE3899 ON injunction');
        $this->addSql('DROP INDEX IDX_A2FAC1E1B600009 ON injunction');
        $this->addSql('DROP INDEX IDX_A2FAC1E1E946114A ON injunction');
        $this->addSql('DROP INDEX IDX_A2FAC1E13BEA4CEE ON injunction');
        $this->addSql('ALTER TABLE injunction DROP nation_id, DROP diocese_id, DROP province_id, DROP archdeaconry_id');
    }
}
