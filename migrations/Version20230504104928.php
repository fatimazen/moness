<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230504104928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C0155143989D9B62 ON blog (slug)');
        $this->addSql('ALTER TABLE ess CHANGE phone_number phone_number VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_C0155143989D9B62 ON blog');
        $this->addSql('ALTER TABLE ess CHANGE phone_number phone_number VARCHAR(13) NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
