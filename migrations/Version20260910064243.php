<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260910064243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acces_dossier (id INT AUTO_INCREMENT NOT NULL, date_consultation DATETIME NOT NULL, autorise TINYINT NOT NULL, utilisateur_id INT NOT NULL, eleve_id INT NOT NULL, INDEX IDX_9829E59FFB88E14F (utilisateur_id), INDEX IDX_9829E59FA6CC7B2 (eleve_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE appel (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, statut VARCHAR(20) NOT NULL, horodatage_validation DATETIME DEFAULT NULL, creneau_id INT NOT NULL, realise_par_id INT DEFAULT NULL, UNIQUE INDEX uniq_creneau_date (creneau_id, date), INDEX IDX_130D3BD7D0729A9 (creneau_id), INDEX IDX_130D3BD7E5383D8 (realise_par_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE creneau (id INT AUTO_INCREMENT NOT NULL, matiere VARCHAR(100) NOT NULL, salle VARCHAR(50) NOT NULL, jour_semaine INT NOT NULL, heure_debut DATETIME NOT NULL, heure_fin DATETIME NOT NULL, classe_id INT NOT NULL, enseignant_id INT NOT NULL, INDEX IDX_F9668B5F8F5EA509 (classe_id), INDEX IDX_F9668B5FE455FCC0 (enseignant_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE eleve (id INT AUTO_INCREMENT NOT NULL, identifiant_externe VARCHAR(50) NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, date_naissance DATETIME DEFAULT NULL, classe_id INT NOT NULL, UNIQUE INDEX uniq_identifiant_externe (identifiant_externe), INDEX IDX_ECA105F78F5EA509 (classe_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE presence (id INT AUTO_INCREMENT NOT NULL, statut VARCHAR(20) NOT NULL, duree_retard_minutes INT DEFAULT NULL, motif VARCHAR(255) DEFAULT NULL, justificatif_texte LONGTEXT DEFAULT NULL, justifiee TINYINT DEFAULT NULL, date_traitement DATETIME DEFAULT NULL, appel_id INT NOT NULL, eleve_id INT NOT NULL, traite_par_id INT DEFAULT NULL, UNIQUE INDEX uniq_appel_eleve (appel_id, eleve_id), INDEX IDX_6977C7A5270B0E02 (appel_id), INDEX IDX_6977C7A5A6CC7B2 (eleve_id), INDEX IDX_6977C7A5167FABE8 (traite_par_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE acces_dossier ADD CONSTRAINT FK_9829E59FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE acces_dossier ADD CONSTRAINT FK_9829E59FA6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE appel ADD CONSTRAINT FK_130D3BD7D0729A9 FOREIGN KEY (creneau_id) REFERENCES creneau (id)');
        $this->addSql('ALTER TABLE appel ADD CONSTRAINT FK_130D3BD7E5383D8 FOREIGN KEY (realise_par_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE creneau ADD CONSTRAINT FK_F9668B5F8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE creneau ADD CONSTRAINT FK_F9668B5FE455FCC0 FOREIGN KEY (enseignant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F78F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE presence ADD CONSTRAINT FK_6977C7A5270B0E02 FOREIGN KEY (appel_id) REFERENCES appel (id)');
        $this->addSql('ALTER TABLE presence ADD CONSTRAINT FK_6977C7A5A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE presence ADD CONSTRAINT FK_6977C7A5167FABE8 FOREIGN KEY (traite_par_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acces_dossier DROP FOREIGN KEY FK_9829E59FFB88E14F');
        $this->addSql('ALTER TABLE acces_dossier DROP FOREIGN KEY FK_9829E59FA6CC7B2');
        $this->addSql('ALTER TABLE appel DROP FOREIGN KEY FK_130D3BD7D0729A9');
        $this->addSql('ALTER TABLE appel DROP FOREIGN KEY FK_130D3BD7E5383D8');
        $this->addSql('ALTER TABLE creneau DROP FOREIGN KEY FK_F9668B5F8F5EA509');
        $this->addSql('ALTER TABLE creneau DROP FOREIGN KEY FK_F9668B5FE455FCC0');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F78F5EA509');
        $this->addSql('ALTER TABLE presence DROP FOREIGN KEY FK_6977C7A5270B0E02');
        $this->addSql('ALTER TABLE presence DROP FOREIGN KEY FK_6977C7A5A6CC7B2');
        $this->addSql('ALTER TABLE presence DROP FOREIGN KEY FK_6977C7A5167FABE8');
        $this->addSql('DROP TABLE acces_dossier');
        $this->addSql('DROP TABLE appel');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE creneau');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE presence');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
