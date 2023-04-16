<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230416123108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE geo_localisation_ess ADD ess_id INT NOT NULL');
        $this->addSql('ALTER TABLE geo_localisation_ess ADD CONSTRAINT FK_BE1D4C2B703B605 FOREIGN KEY (ess_id) REFERENCES ess (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BE1D4C2B703B605 ON geo_localisation_ess (ess_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE geo_localisation_ess DROP FOREIGN KEY FK_BE1D4C2B703B605');
        $this->addSql('DROP INDEX UNIQ_BE1D4C2B703B605 ON geo_localisation_ess');
        $this->addSql('ALTER TABLE geo_localisation_ess DROP ess_id');
    }
}
