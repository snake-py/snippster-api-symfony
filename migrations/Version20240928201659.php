<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240928201659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE snippet (id BLOB NOT NULL --(DC2Type:uuid)
        , owner_id BLOB NOT NULL --(DC2Type:uuid)
        , title VARCHAR(255) NOT NULL, code CLOB DEFAULT NULL, is_public BOOLEAN NOT NULL, language VARCHAR(255) DEFAULT NULL, framework VARCHAR(255) DEFAULT NULL, likes INTEGER NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_961C8CD57E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_961C8CD57E3C61F9 ON snippet (owner_id)');
        $this->addSql('CREATE TABLE user (id BLOB NOT NULL --(DC2Type:uuid)
        , username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE snippet');
        $this->addSql('DROP TABLE user');
    }
}
