<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230604140229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_AC74095A727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A727ACA70 FOREIGN KEY (parent_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE comments CHANGE articlepresse_id articlepresse_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ess ADD activity_id INT NOT NULL, DROP activity');
        $this->addSql('ALTER TABLE ess ADD CONSTRAINT FK_7C43DA6A81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('CREATE INDEX IDX_7C43DA6A81C06096 ON ess (activity_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ess DROP FOREIGN KEY FK_7C43DA6A81C06096');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A727ACA70');
        $this->addSql('DROP TABLE activity');
        $this->addSql('ALTER TABLE comments CHANGE articlepresse_id articlepresse_id INT NOT NULL');
        $this->addSql('DROP INDEX IDX_7C43DA6A81C06096 ON ess');
        $this->addSql('ALTER TABLE ess ADD activity VARCHAR(255) NOT NULL, DROP activity_id');
    }
}
