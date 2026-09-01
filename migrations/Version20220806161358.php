<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220806161358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        if ($this->connection->getDatabasePlatform()->getName() === 'postgresql') {
            $this->addSql('CREATE SEQUENCE homebrew_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
            $this->addSql('CREATE TABLE homebrew (id INT NOT NULL, uuid VARCHAR(255) NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, accessed TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, json JSON NOT NULL, PRIMARY KEY(id))');
            $this->addSql('CREATE INDEX uuid_idx ON homebrew (uuid)');

            return;
        }

        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE homebrew (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(255) NOT NULL, created DATETIME NOT NULL, accessed DATETIME NOT NULL, json JSON NOT NULL, INDEX uuid_idx (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        if ($this->connection->getDatabasePlatform()->getName() === 'postgresql') {
            $this->addSql('DROP TABLE homebrew');
            $this->addSql('DROP SEQUENCE homebrew_id_seq CASCADE');

            return;
        }

        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE homebrew');
    }
}
