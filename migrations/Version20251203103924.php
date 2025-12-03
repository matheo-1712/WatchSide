<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251203103924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE favoris (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_film_id INTEGER NOT NULL, id_user_id INTEGER NOT NULL, CONSTRAINT FK_8933C43288E2F8F3 FOREIGN KEY (id_film_id) REFERENCES film (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8933C43279F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_8933C43288E2F8F3 ON favoris (id_film_id)');
        $this->addSql('CREATE INDEX IDX_8933C43279F37AE5 ON favoris (id_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE favoris');
    }
}
