<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230416130552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_categories ADD categories_id INT NOT NULL');
        $this->addSql('ALTER TABLE article_categories ADD CONSTRAINT FK_62A97E9A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_62A97E9A21214B7 ON article_categories (categories_id)');
        $this->addSql('ALTER TABLE categories ADD articlespresse_id INT NOT NULL, ADD blog_id INT NOT NULL');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF346688396FCD FOREIGN KEY (articlespresse_id) REFERENCES articlespress (id)');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)');
        $this->addSql('CREATE INDEX IDX_3AF346688396FCD ON categories (articlespresse_id)');
        $this->addSql('CREATE INDEX IDX_3AF34668DAE07E97 ON categories (blog_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF346688396FCD');
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668DAE07E97');
        $this->addSql('DROP INDEX IDX_3AF346688396FCD ON categories');
        $this->addSql('DROP INDEX IDX_3AF34668DAE07E97 ON categories');
        $this->addSql('ALTER TABLE categories DROP articlespresse_id, DROP blog_id');
        $this->addSql('ALTER TABLE article_categories DROP FOREIGN KEY FK_62A97E9A21214B7');
        $this->addSql('DROP INDEX IDX_62A97E9A21214B7 ON article_categories');
        $this->addSql('ALTER TABLE article_categories DROP categories_id');
    }
}
