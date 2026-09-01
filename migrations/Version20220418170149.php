<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220418170149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        if ($this->connection->getDatabasePlatform()->getName() === 'postgresql') {
            $this->addSql('CREATE SEQUENCE jinxes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
            $this->addSql("CREATE TABLE jinxes (id INT NOT NULL, reason TEXT DEFAULT '' NOT NULL, PRIMARY KEY(id))");
            $this->addSql('ALTER TABLE roles ADD targets_id INT DEFAULT NULL');
            $this->addSql('ALTER TABLE roles ADD tricks_id INT DEFAULT NULL');
            $this->addSql('ALTER TABLE roles ADD CONSTRAINT FK_B63E2EC743B5F743 FOREIGN KEY (targets_id) REFERENCES jinxes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
            $this->addSql('ALTER TABLE roles ADD CONSTRAINT FK_B63E2EC73B153154 FOREIGN KEY (tricks_id) REFERENCES jinxes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
            $this->addSql('CREATE INDEX IDX_B63E2EC743B5F743 ON roles (targets_id)');
            $this->addSql('CREATE INDEX IDX_B63E2EC73B153154 ON roles (tricks_id)');

            return;
        }

        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE jinxes (id INT AUTO_INCREMENT NOT NULL, reason LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE roles ADD targets_id INT DEFAULT NULL, ADD tricks_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE roles ADD CONSTRAINT FK_B63E2EC743B5F743 FOREIGN KEY (targets_id) REFERENCES jinxes (id)');
        $this->addSql('ALTER TABLE roles ADD CONSTRAINT FK_B63E2EC73B153154 FOREIGN KEY (tricks_id) REFERENCES jinxes (id)');
        $this->addSql('CREATE INDEX IDX_B63E2EC743B5F743 ON roles (targets_id)');
        $this->addSql('CREATE INDEX IDX_B63E2EC73B153154 ON roles (tricks_id)');
    }

    public function down(Schema $schema): void
    {
        if ($this->connection->getDatabasePlatform()->getName() === 'postgresql') {
            $this->addSql('ALTER TABLE roles DROP CONSTRAINT FK_B63E2EC743B5F743');
            $this->addSql('ALTER TABLE roles DROP CONSTRAINT FK_B63E2EC73B153154');
            $this->addSql('DROP INDEX IDX_B63E2EC743B5F743');
            $this->addSql('DROP INDEX IDX_B63E2EC73B153154');
            $this->addSql('ALTER TABLE roles DROP COLUMN targets_id');
            $this->addSql('ALTER TABLE roles DROP COLUMN tricks_id');
            $this->addSql('DROP TABLE jinxes');
            $this->addSql('DROP SEQUENCE jinxes_id_seq CASCADE');

            return;
        }

        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE roles DROP FOREIGN KEY FK_B63E2EC743B5F743');
        $this->addSql('ALTER TABLE roles DROP FOREIGN KEY FK_B63E2EC73B153154');
        $this->addSql('DROP TABLE jinxes');
        $this->addSql('DROP INDEX IDX_B63E2EC743B5F743 ON roles');
        $this->addSql('DROP INDEX IDX_B63E2EC73B153154 ON roles');
        $this->addSql('ALTER TABLE roles DROP targets_id, DROP tricks_id');
    }
}
