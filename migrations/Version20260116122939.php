<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260116122939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("ALTER TABLE user ADD COLUMN roles CLOB NOT NULL DEFAULT '[]'");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, nom_utilisateur, mot_de_passe FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_utilisateur VARCHAR(100) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, nom_utilisateur, mot_de_passe) SELECT id, nom_utilisateur, mot_de_passe FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649D37CC8AC ON user (nom_utilisateur)');
    }
}
