<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230507111709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, ess_id INT NOT NULL, blog_id INT NOT NULL, articlepress_id INT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, image_size INT NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_C53D045FB703B605 (ess_id), INDEX IDX_C53D045FDAE07E97 (blog_id), INDEX IDX_C53D045F2DDE3D97 (articlepress_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FB703B605 FOREIGN KEY (ess_id) REFERENCES ess (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FDAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F2DDE3D97 FOREIGN KEY (articlepress_id) REFERENCES articlespress (id)');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6ADAE07E97');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AB703B605');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A2DDE3D97');
        $this->addSql('DROP TABLE images');
        $this->addSql('ALTER TABLE blog ADD image_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, ess_id INT NOT NULL, blog_id INT NOT NULL, articlepress_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, image_size INT NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_E01FBE6A2DDE3D97 (articlepress_id), INDEX IDX_E01FBE6ADAE07E97 (blog_id), UNIQUE INDEX UNIQ_E01FBE6AB703B605 (ess_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6ADAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AB703B605 FOREIGN KEY (ess_id) REFERENCES ess (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A2DDE3D97 FOREIGN KEY (articlepress_id) REFERENCES articlespress (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FB703B605');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FDAE07E97');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F2DDE3D97');
        $this->addSql('DROP TABLE image');
        $this->addSql('ALTER TABLE blog DROP image_name');
    }
}
