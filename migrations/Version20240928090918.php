<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240928090918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE snippet (id BLOB NOT NULL --(DC2Type:uuid)
        , title VARCHAR(255) NOT NULL, code CLOB DEFAULT NULL, owner BLOB NOT NULL --(DC2Type:uuid)
        , is_public BOOLEAN NOT NULL, language VARCHAR(255) DEFAULT NULL, framework VARCHAR(255) DEFAULT NULL, likes INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user (id BLOB NOT NULL --(DC2Type:uuid)
        , username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE snippet');
        $this->addSql('DROP TABLE user');
    }
}
