<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220418091605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        if ($this->connection->getDatabasePlatform()->getName() === 'postgresql') {
            $this->addSql('CREATE INDEX editions_identifier_idx ON editions (identifier)');
            $this->addSql('CREATE INDEX roles_identifier_idx ON roles (identifier)');
            $this->addSql('CREATE INDEX teams_identifier_idx ON teams (identifier)');

            return;
        }

        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE INDEX identifier_idx ON editions (identifier)');
        $this->addSql('CREATE INDEX identifier_idx ON roles (identifier)');
        $this->addSql('CREATE INDEX identifier_idx ON teams (identifier)');
    }

    public function down(Schema $schema): void
    {
        if ($this->connection->getDatabasePlatform()->getName() === 'postgresql') {
            $this->addSql('DROP INDEX editions_identifier_idx');
            $this->addSql('DROP INDEX roles_identifier_idx');
            $this->addSql('DROP INDEX teams_identifier_idx');

            return;
        }

        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX identifier_idx ON editions');
        $this->addSql('DROP INDEX identifier_idx ON roles');
        $this->addSql('DROP INDEX identifier_idx ON teams');
    }
}
