<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230630084907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AC74095A989D9B62 ON activity (slug)');
        $this->addSql('ALTER TABLE ess DROP  sector_activity');
        $this->addSql('ALTER TABLE ess ADD sector_activity JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_AC74095A989D9B62 ON activity');
        $this->addSql('ALTER TABLE ess DROP  sector_activity');
        $this->addSql('ALTER TABLE ess ADD sector_activity VARCHAR(255) NOT NULL');
    }
}