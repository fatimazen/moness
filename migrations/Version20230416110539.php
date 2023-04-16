<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230416110539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articlespress ADD ess_id INT NOT NULL');
        $this->addSql('ALTER TABLE articlespress ADD CONSTRAINT FK_7A1DCBE1B703B605 FOREIGN KEY (ess_id) REFERENCES ess (id)');
        $this->addSql('CREATE INDEX IDX_7A1DCBE1B703B605 ON articlespress (ess_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articlespress DROP FOREIGN KEY FK_7A1DCBE1B703B605');
        $this->addSql('DROP INDEX IDX_7A1DCBE1B703B605 ON articlespress');
        $this->addSql('ALTER TABLE articlespress DROP ess_id');
    }
}
