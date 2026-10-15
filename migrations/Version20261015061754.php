<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261015061754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appel CHANGE date date DATE NOT NULL');
        $this->addSql('ALTER TABLE creneau CHANGE heure_debut heure_debut TIME NOT NULL, CHANGE heure_fin heure_fin TIME NOT NULL');
        $this->addSql('ALTER TABLE eleve CHANGE date_naissance date_naissance DATE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appel CHANGE date date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE creneau CHANGE heure_debut heure_debut DATETIME NOT NULL, CHANGE heure_fin heure_fin DATETIME NOT NULL');
        $this->addSql('ALTER TABLE eleve CHANGE date_naissance date_naissance DATETIME DEFAULT NULL');
    }
}
