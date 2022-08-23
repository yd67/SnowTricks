<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220823133035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, triks_id INT DEFAULT NULL, creator_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, created_at DATETIME NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_5F9E962A175C8A9F (triks_id), INDEX IDX_5F9E962A61220EA6 (creator_id), INDEX IDX_5F9E962A727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, triks_id INT DEFAULT NULL, filename VARCHAR(255) NOT NULL, INDEX IDX_C53D045F175C8A9F (triks_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE triks (id INT AUTO_INCREMENT NOT NULL, groupes_id INT DEFAULT NULL, creator_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, description LONGTEXT NOT NULL, INDEX IDX_345BB40305371B (groupes_id), INDEX IDX_345BB4061220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, triks_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_7CC7DA2C175C8A9F (triks_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A175C8A9F FOREIGN KEY (triks_id) REFERENCES triks (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A61220EA6 FOREIGN KEY (creator_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A727ACA70 FOREIGN KEY (parent_id) REFERENCES comments (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F175C8A9F FOREIGN KEY (triks_id) REFERENCES triks (id)');
        $this->addSql('ALTER TABLE triks ADD CONSTRAINT FK_345BB40305371B FOREIGN KEY (groupes_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE triks ADD CONSTRAINT FK_345BB4061220EA6 FOREIGN KEY (creator_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C175C8A9F FOREIGN KEY (triks_id) REFERENCES triks (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A175C8A9F');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A61220EA6');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A727ACA70');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F175C8A9F');
        $this->addSql('ALTER TABLE triks DROP FOREIGN KEY FK_345BB40305371B');
        $this->addSql('ALTER TABLE triks DROP FOREIGN KEY FK_345BB4061220EA6');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C175C8A9F');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE triks');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
