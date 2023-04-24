<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230424084530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favoris ADD ess_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C432B703B605 FOREIGN KEY (ess_id) REFERENCES ess (id)');
        $this->addSql('CREATE INDEX IDX_8933C432B703B605 ON favoris (ess_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C432B703B605');
        $this->addSql('DROP INDEX IDX_8933C432B703B605 ON favoris');
        $this->addSql('ALTER TABLE favoris DROP ess_id');
    }
}
