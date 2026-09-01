<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416123353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        if ($this->connection->getDatabasePlatform()->getName() === 'postgresql') {
            $this->addSql('CREATE SEQUENCE editions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
            $this->addSql('CREATE SEQUENCE teams_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
            $this->addSql('CREATE SEQUENCE roles_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
            $this->addSql('CREATE TABLE editions (id INT NOT NULL, identifier VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
            $this->addSql('CREATE TABLE teams (id INT NOT NULL, identifier VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
            $this->addSql("CREATE TABLE roles (id INT NOT NULL, edition_id INT DEFAULT NULL, team_id INT DEFAULT NULL, identifier VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, first_night INT DEFAULT 0 NOT NULL, first_night_reminder TEXT DEFAULT '' NOT NULL, other_night INT DEFAULT 0 NOT NULL, other_night_reminder TEXT DEFAULT '' NOT NULL, reminders TEXT NOT NULL, reminders_global TEXT NOT NULL, setup BOOLEAN DEFAULT FALSE NOT NULL, ability TEXT DEFAULT '' NOT NULL, image VARCHAR(255) DEFAULT '' NOT NULL, PRIMARY KEY(id))");
            $this->addSql("COMMENT ON COLUMN roles.reminders IS '(DC2Type:array)'");
            $this->addSql("COMMENT ON COLUMN roles.reminders_global IS '(DC2Type:array)'");
            $this->addSql('CREATE INDEX IDX_B63E2EC774281A5E ON roles (edition_id)');
            $this->addSql('CREATE INDEX IDX_B63E2EC7296CD8AE ON roles (team_id)');
            $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
            $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
            $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
            $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
            $this->addSql('ALTER TABLE roles ADD CONSTRAINT FK_B63E2EC774281A5E FOREIGN KEY (edition_id) REFERENCES editions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
            $this->addSql('ALTER TABLE roles ADD CONSTRAINT FK_B63E2EC7296CD8AE FOREIGN KEY (team_id) REFERENCES teams (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

            return;
        }

        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE editions (id INT AUTO_INCREMENT NOT NULL, identifier VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, edition_id INT DEFAULT NULL, team_id INT DEFAULT NULL, identifier VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, first_night INT DEFAULT 0 NOT NULL, first_night_reminder LONGTEXT NOT NULL, other_night INT DEFAULT 0 NOT NULL, other_night_reminder LONGTEXT NOT NULL, reminders LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', reminders_global LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', setup TINYINT(1) DEFAULT 0 NOT NULL, ability LONGTEXT NOT NULL, image VARCHAR(255) DEFAULT \'\' NOT NULL, INDEX IDX_B63E2EC774281A5E (edition_id), INDEX IDX_B63E2EC7296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teams (id INT AUTO_INCREMENT NOT NULL, identifier VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE roles ADD CONSTRAINT FK_B63E2EC774281A5E FOREIGN KEY (edition_id) REFERENCES editions (id)');
        $this->addSql('ALTER TABLE roles ADD CONSTRAINT FK_B63E2EC7296CD8AE FOREIGN KEY (team_id) REFERENCES teams (id)');
    }

    public function down(Schema $schema): void
    {
        if ($this->connection->getDatabasePlatform()->getName() === 'postgresql') {
            $this->addSql('ALTER TABLE roles DROP CONSTRAINT FK_B63E2EC774281A5E');
            $this->addSql('ALTER TABLE roles DROP CONSTRAINT FK_B63E2EC7296CD8AE');
            $this->addSql('DROP TABLE roles');
            $this->addSql('DROP TABLE editions');
            $this->addSql('DROP TABLE teams');
            $this->addSql('DROP TABLE messenger_messages');
            $this->addSql('DROP SEQUENCE editions_id_seq CASCADE');
            $this->addSql('DROP SEQUENCE teams_id_seq CASCADE');
            $this->addSql('DROP SEQUENCE roles_id_seq CASCADE');

            return;
        }

        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE roles DROP FOREIGN KEY FK_B63E2EC774281A5E');
        $this->addSql('ALTER TABLE roles DROP FOREIGN KEY FK_B63E2EC7296CD8AE');
        $this->addSql('DROP TABLE editions');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE teams');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
