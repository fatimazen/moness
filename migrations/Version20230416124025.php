<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230416124025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_categories (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, article_categories_id INT NOT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_3AF3466825C9FB12 (article_categories_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF3466825C9FB12 FOREIGN KEY (article_categories_id) REFERENCES article_categories (id)');
        $this->addSql('ALTER TABLE articlespress ADD article_categories_id INT NOT NULL');
        $this->addSql('ALTER TABLE articlespress ADD CONSTRAINT FK_7A1DCBE125C9FB12 FOREIGN KEY (article_categories_id) REFERENCES article_categories (id)');
        $this->addSql('CREATE INDEX IDX_7A1DCBE125C9FB12 ON articlespress (article_categories_id)');
        $this->addSql('ALTER TABLE blog ADD article_categories_id INT NOT NULL');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C015514325C9FB12 FOREIGN KEY (article_categories_id) REFERENCES article_categories (id)');
        $this->addSql('CREATE INDEX IDX_C015514325C9FB12 ON blog (article_categories_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articlespress DROP FOREIGN KEY FK_7A1DCBE125C9FB12');
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C015514325C9FB12');
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF3466825C9FB12');
        $this->addSql('DROP TABLE article_categories');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP INDEX IDX_7A1DCBE125C9FB12 ON articlespress');
        $this->addSql('ALTER TABLE articlespress DROP article_categories_id');
        $this->addSql('DROP INDEX IDX_C015514325C9FB12 ON blog');
        $this->addSql('ALTER TABLE blog DROP article_categories_id');
    }
}
