<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230425200246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE favoris (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, ess_id INT DEFAULT NULL, INDEX IDX_8933C432A76ED395 (user_id), INDEX IDX_8933C432B703B605 (ess_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, ess_id INT NOT NULL, image VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6A2CA10CB703B605 (ess_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C432A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C432B703B605 FOREIGN KEY (ess_id) REFERENCES ess (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CB703B605 FOREIGN KEY (ess_id) REFERENCES ess (id)');
        $this->addSql('ALTER TABLE articlespress DROP sent_at');
        $this->addSql('ALTER TABLE contact_messages CHANGE creates_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE ess ADD activity VARCHAR(255) NOT NULL, ADD economie_sociale_et_solidaire VARCHAR(255) NOT NULL, ADD entreprise_amission VARCHAR(255) NOT NULL, CHANGE phone_number phone_number VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE news_letters DROP tile, DROP sent_at, DROP image');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C432A76ED395');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C432B703B605');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CB703B605');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE media');
        $this->addSql('ALTER TABLE articlespress ADD sent_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE news_letters ADD tile VARCHAR(255) NOT NULL, ADD sent_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE contact_messages CHANGE created_at creates_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE ess DROP activity, DROP economie_sociale_et_solidaire, DROP entreprise_amission, CHANGE phone_number phone_number VARCHAR(10) NOT NULL');
    }
}
