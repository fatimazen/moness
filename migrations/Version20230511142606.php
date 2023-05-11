<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230511142606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articlespresse ADD state VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AFC456DBC FOREIGN KEY (articlepresse_id) REFERENCES articlespresse (id)');
        $this->addSql('CREATE INDEX IDX_5F9E962AFC456DBC ON comments (articlepresse_id)');
        $this->addSql('DROP INDEX IDX_C53D045F2DDE3D97 ON image');
        $this->addSql('ALTER TABLE image CHANGE articlepress_id articlepresse_id INT NOT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FFC456DBC FOREIGN KEY (articlepresse_id) REFERENCES articlespresse (id)');
        $this->addSql('CREATE INDEX IDX_C53D045FFC456DBC ON image (articlepresse_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articlespresse DROP state');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AFC456DBC');
        $this->addSql('DROP INDEX IDX_5F9E962AFC456DBC ON comments');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FFC456DBC');
        $this->addSql('DROP INDEX IDX_C53D045FFC456DBC ON image');
        $this->addSql('ALTER TABLE image CHANGE articlepresse_id articlepress_id INT NOT NULL');
        $this->addSql('CREATE INDEX IDX_C53D045F2DDE3D97 ON image (articlepress_id)');
    }
}
