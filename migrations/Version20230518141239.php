<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230518141239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_categories (id INT AUTO_INCREMENT NOT NULL, categories_id INT NOT NULL, articlepresse_id INT NOT NULL, blog_id INT NOT NULL, INDEX IDX_62A97E9A21214B7 (categories_id), INDEX IDX_62A97E9FC456DBC (articlepresse_id), INDEX IDX_62A97E9DAE07E97 (blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articlespresse (id INT AUTO_INCREMENT NOT NULL, ess_id INT NOT NULL, title LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_38ADB57F989D9B62 (slug), INDEX IDX_38ADB57FB703B605 (ess_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, content LONGTEXT NOT NULL, state VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_C01551432B36786B (title), UNIQUE INDEX UNIQ_C0155143989D9B62 (slug), INDEX IDX_C015514367B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, articlepresse_id INT NOT NULL, ess_id INT NOT NULL, blog_id INT NOT NULL, comment LONGTEXT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_5F9E962A67B3B43D (users_id), INDEX IDX_5F9E962AFC456DBC (articlepresse_id), INDEX IDX_5F9E962AB703B605 (ess_id), INDEX IDX_5F9E962ADAE07E97 (blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_messages (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, full_name VARCHAR(50) DEFAULT NULL, email VARCHAR(180) NOT NULL, message LONGTEXT NOT NULL, sujet VARCHAR(100) DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_4127820167B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ess (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, email VARCHAR(255) NOT NULL, name_structure VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, zip_code VARCHAR(5) NOT NULL, sector_activity VARCHAR(255) NOT NULL, legal_status VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, phone_number VARCHAR(20) NOT NULL, image VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', web_site VARCHAR(255) DEFAULT NULL, social_networks VARCHAR(255) DEFAULT NULL, opening_hours_monday TIME NOT NULL, closing_hours_monday TIME NOT NULL, opening_hours_tuesday TIME NOT NULL, closing_hours_tuesday TIME NOT NULL, opening_hours_wednesday TIME NOT NULL, closing_hours_wednesday TIME NOT NULL, opening_hours_thursday TIME NOT NULL, closing_hours_thursday TIME NOT NULL, opening_hours_friday TIME NOT NULL, closing_hours_friday TIME NOT NULL, opening_hours_saturday TIME NOT NULL, closing_hours_saturday TIME NOT NULL, opening_hours_sunday TIME NOT NULL, closing_hours_sunday TIME NOT NULL, region VARCHAR(255) NOT NULL, label JSON DEFAULT NULL, siret_number VARCHAR(14) NOT NULL, activity VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_7C43DA6AE7927C74 (email), INDEX IDX_7C43DA6AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favoris (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, ess_id INT DEFAULT NULL, INDEX IDX_8933C432A76ED395 (user_id), INDEX IDX_8933C432B703B605 (ess_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE geo_localisation_ess (id INT AUTO_INCREMENT NOT NULL, ess_id INT NOT NULL, latitude NUMERIC(10, 0) NOT NULL, longitude NUMERIC(10, 0) NOT NULL, UNIQUE INDEX UNIQ_BE1D4C2B703B605 (ess_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, blog_id INT NOT NULL, articlepresse_id INT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, image_size INT NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C53D045FDAE07E97 (blog_id), INDEX IDX_C53D045FFC456DBC (articlepresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_letters (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', content LONGTEXT NOT NULL, INDEX IDX_ACB1381D67B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_abonne_news_letter TINYINT(1) DEFAULT NULL, birthdate VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, token_registration VARCHAR(255) DEFAULT NULL, token_registration_life_time DATETIME DEFAULT NULL, is_verfied TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_categories ADD CONSTRAINT FK_62A97E9A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE article_categories ADD CONSTRAINT FK_62A97E9FC456DBC FOREIGN KEY (articlepresse_id) REFERENCES articlespresse (id)');
        $this->addSql('ALTER TABLE article_categories ADD CONSTRAINT FK_62A97E9DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)');
        $this->addSql('ALTER TABLE articlespresse ADD CONSTRAINT FK_38ADB57FB703B605 FOREIGN KEY (ess_id) REFERENCES ess (id)');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C015514367B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AFC456DBC FOREIGN KEY (articlepresse_id) REFERENCES articlespresse (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AB703B605 FOREIGN KEY (ess_id) REFERENCES ess (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962ADAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)');
        $this->addSql('ALTER TABLE contact_messages ADD CONSTRAINT FK_4127820167B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE ess ADD CONSTRAINT FK_7C43DA6AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C432A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C432B703B605 FOREIGN KEY (ess_id) REFERENCES ess (id)');
        $this->addSql('ALTER TABLE geo_localisation_ess ADD CONSTRAINT FK_BE1D4C2B703B605 FOREIGN KEY (ess_id) REFERENCES ess (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FDAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FFC456DBC FOREIGN KEY (articlepresse_id) REFERENCES articlespresse (id)');
        $this->addSql('ALTER TABLE news_letters ADD CONSTRAINT FK_ACB1381D67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_categories DROP FOREIGN KEY FK_62A97E9A21214B7');
        $this->addSql('ALTER TABLE article_categories DROP FOREIGN KEY FK_62A97E9FC456DBC');
        $this->addSql('ALTER TABLE article_categories DROP FOREIGN KEY FK_62A97E9DAE07E97');
        $this->addSql('ALTER TABLE articlespresse DROP FOREIGN KEY FK_38ADB57FB703B605');
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C015514367B3B43D');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A67B3B43D');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AFC456DBC');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AB703B605');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962ADAE07E97');
        $this->addSql('ALTER TABLE contact_messages DROP FOREIGN KEY FK_4127820167B3B43D');
        $this->addSql('ALTER TABLE ess DROP FOREIGN KEY FK_7C43DA6AA76ED395');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C432A76ED395');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C432B703B605');
        $this->addSql('ALTER TABLE geo_localisation_ess DROP FOREIGN KEY FK_BE1D4C2B703B605');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FDAE07E97');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FFC456DBC');
        $this->addSql('ALTER TABLE news_letters DROP FOREIGN KEY FK_ACB1381D67B3B43D');
        $this->addSql('DROP TABLE article_categories');
        $this->addSql('DROP TABLE articlespresse');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE contact_messages');
        $this->addSql('DROP TABLE ess');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE geo_localisation_ess');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE news_letters');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
