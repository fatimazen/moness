<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230416131913 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_categories ADD blog_id INT NOT NULL');
        $this->addSql('ALTER TABLE article_categories ADD CONSTRAINT FK_62A97E9DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)');
        $this->addSql('CREATE INDEX IDX_62A97E9DAE07E97 ON article_categories (blog_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_categories DROP FOREIGN KEY FK_62A97E9DAE07E97');
        $this->addSql('DROP INDEX IDX_62A97E9DAE07E97 ON article_categories');
        $this->addSql('ALTER TABLE article_categories DROP blog_id');
    }
}
