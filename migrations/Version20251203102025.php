<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251203102025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__film AS SELECT id, titre, anne_sortie, duree, synopsis, image, prix_default FROM film');
        $this->addSql('DROP TABLE film');
        $this->addSql('CREATE TABLE film (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(100) NOT NULL, anne_sortie DATE NOT NULL, duree DOUBLE PRECISION NOT NULL, synopsis VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, prix_default DOUBLE PRECISION NOT NULL, id_genre_id INTEGER NOT NULL, CONSTRAINT FK_8244BE22124D3F8A FOREIGN KEY (id_genre_id) REFERENCES genre (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO film (id, titre, anne_sortie, duree, synopsis, image, prix_default) SELECT id, titre, anne_sortie, duree, synopsis, image, prix_default FROM __temp__film');
        $this->addSql('DROP TABLE __temp__film');
        $this->addSql('CREATE INDEX IDX_8244BE22124D3F8A ON film (id_genre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__film AS SELECT id, titre, anne_sortie, duree, synopsis, image, prix_default FROM film');
        $this->addSql('DROP TABLE film');
        $this->addSql('CREATE TABLE film (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(100) NOT NULL, anne_sortie DATE NOT NULL, duree DOUBLE PRECISION NOT NULL, synopsis VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, prix_default DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO film (id, titre, anne_sortie, duree, synopsis, image, prix_default) SELECT id, titre, anne_sortie, duree, synopsis, image, prix_default FROM __temp__film');
        $this->addSql('DROP TABLE __temp__film');
    }
}
