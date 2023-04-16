<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230416105417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments ADD users_id INT NOT NULL, ADD articlepress_id INT NOT NULL, ADD ess_id INT NOT NULL, ADD blog_id INT NOT NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A2DDE3D97 FOREIGN KEY (articlepress_id) REFERENCES articlespress (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AB703B605 FOREIGN KEY (ess_id) REFERENCES ess (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962ADAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)');
        $this->addSql('CREATE INDEX IDX_5F9E962A67B3B43D ON comments (users_id)');
        $this->addSql('CREATE INDEX IDX_5F9E962A2DDE3D97 ON comments (articlepress_id)');
        $this->addSql('CREATE INDEX IDX_5F9E962AB703B605 ON comments (ess_id)');
        $this->addSql('CREATE INDEX IDX_5F9E962ADAE07E97 ON comments (blog_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A67B3B43D');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A2DDE3D97');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AB703B605');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962ADAE07E97');
        $this->addSql('DROP INDEX IDX_5F9E962A67B3B43D ON comments');
        $this->addSql('DROP INDEX IDX_5F9E962A2DDE3D97 ON comments');
        $this->addSql('DROP INDEX IDX_5F9E962AB703B605 ON comments');
        $this->addSql('DROP INDEX IDX_5F9E962ADAE07E97 ON comments');
        $this->addSql('ALTER TABLE comments DROP users_id, DROP articlepress_id, DROP ess_id, DROP blog_id');
    }
}
