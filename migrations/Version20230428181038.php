<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230428181038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, ess_id INT NOT NULL, blog_id INT NOT NULL, articlepress_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E01FBE6AB703B605 (ess_id), INDEX IDX_E01FBE6ADAE07E97 (blog_id), INDEX IDX_E01FBE6A2DDE3D97 (articlepress_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AB703B605 FOREIGN KEY (ess_id) REFERENCES ess (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6ADAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A2DDE3D97 FOREIGN KEY (articlepress_id) REFERENCES articlespress (id)');
        $this->addSql('ALTER TABLE ess DROP economie_sociale_et_solidaire, DROP entreprise_amission, CHANGE label label JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE users CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT \'(DC2Type:datetime_immutable)\', CHANGE is_abonne_news_letter is_abonne_news_letter TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AB703B605');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6ADAE07E97');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A2DDE3D97');
        $this->addSql('DROP TABLE images');
        $this->addSql('ALTER TABLE ess ADD economie_sociale_et_solidaire VARCHAR(255) NOT NULL, ADD entreprise_amission VARCHAR(255) NOT NULL, CHANGE label label VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE is_abonne_news_letter is_abonne_news_letter TINYINT(1) NOT NULL');
    }
}
