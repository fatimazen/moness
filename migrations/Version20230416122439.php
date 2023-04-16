<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230416122439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE news_letters ADD users_id INT NOT NULL');
        $this->addSql('ALTER TABLE news_letters ADD CONSTRAINT FK_ACB1381D67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_ACB1381D67B3B43D ON news_letters (users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE news_letters DROP FOREIGN KEY FK_ACB1381D67B3B43D');
        $this->addSql('DROP INDEX IDX_ACB1381D67B3B43D ON news_letters');
        $this->addSql('ALTER TABLE news_letters DROP users_id');
    }
}
