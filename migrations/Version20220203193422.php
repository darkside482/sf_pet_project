<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220203193422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notes (id UUID NOT NULL, user_id UUID DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, name VARCHAR(255) NOT NULL, link VARCHAR(255) DEFAULT NULL, comment TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_11BA68CA76ED395 ON notes (user_id)');
        $this->addSql('COMMENT ON COLUMN notes.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN notes.user_id IS \'(DC2Type:ulid)\'');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE notes');
    }
}
