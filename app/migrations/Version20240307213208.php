<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240307213208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__departure AS SELECT id, time, bus_line, destination, bus_stop FROM departure');
        $this->addSql('DROP TABLE departure');
        $this->addSql('CREATE TABLE departure (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, time VARCHAR(255) NOT NULL, bus_line VARCHAR(255) NOT NULL, destination VARCHAR(255) NOT NULL, bus_stop VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO departure (id, time, bus_line, destination, bus_stop) SELECT id, time, bus_line, destination, bus_stop FROM __temp__departure');
        $this->addSql('DROP TABLE __temp__departure');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('CREATE TEMPORARY TABLE __temp__departure AS SELECT id, time, bus_line, destination, bus_stop FROM departure');
        $this->addSql('DROP TABLE departure');
        $this->addSql('CREATE TABLE departure (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, time DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , bus_line VARCHAR(255) NOT NULL, destination VARCHAR(255) NOT NULL, bus_stop VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO departure (id, time, bus_line, destination, bus_stop) SELECT id, time, bus_line, destination, bus_stop FROM __temp__departure');
        $this->addSql('DROP TABLE __temp__departure');
    }
}
