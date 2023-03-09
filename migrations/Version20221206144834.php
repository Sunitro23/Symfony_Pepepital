<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221206144834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE assistant (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(180) NOT NULL, UNIQUE INDEX UNIQ_C2997CD1AA08CB10 (login), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE indisponibilite (id INT AUTO_INCREMENT NOT NULL, medecin_id INT NOT NULL, date DATE NOT NULL, libelle VARCHAR(75) NOT NULL, INDEX IDX_8717036F4F31A84 (medecin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medecin (id INT AUTO_INCREMENT NOT NULL, assistant_id INT NOT NULL, nom VARCHAR(180) NOT NULL, UNIQUE INDEX UNIQ_1BDA53C66C6E55B5 (nom), UNIQUE INDEX UNIQ_1BDA53C6E05387EF (assistant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(180) NOT NULL, adresse VARCHAR(50) NOT NULL, mail VARCHAR(30) NOT NULL, UNIQUE INDEX UNIQ_1ADAD7EB6C6E55B5 (nom), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rdv (id INT AUTO_INCREMENT NOT NULL, medecin_id INT NOT NULL, statut_id INT NOT NULL, patient_id INT NOT NULL, date DATE NOT NULL, heure TIME NOT NULL, duree INT NOT NULL, INDEX IDX_10C31F864F31A84 (medecin_id), INDEX IDX_10C31F86F6203804 (statut_id), INDEX IDX_10C31F866B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, medecin_id INT DEFAULT NULL, patient_id INT DEFAULT NULL, assistant_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(25) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6494F31A84 (medecin_id), UNIQUE INDEX UNIQ_8D93D6496B899279 (patient_id), UNIQUE INDEX UNIQ_8D93D649E05387EF (assistant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE indisponibilite ADD CONSTRAINT FK_8717036F4F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id)');
        $this->addSql('ALTER TABLE medecin ADD CONSTRAINT FK_1BDA53C6E05387EF FOREIGN KEY (assistant_id) REFERENCES assistant (id)');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F864F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id)');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F86F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id)');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F866B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649E05387EF FOREIGN KEY (assistant_id) REFERENCES assistant (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE indisponibilite DROP FOREIGN KEY FK_8717036F4F31A84');
        $this->addSql('ALTER TABLE medecin DROP FOREIGN KEY FK_1BDA53C6E05387EF');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F864F31A84');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F86F6203804');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F866B899279');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494F31A84');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496B899279');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E05387EF');
        $this->addSql('DROP TABLE assistant');
        $this->addSql('DROP TABLE indisponibilite');
        $this->addSql('DROP TABLE medecin');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('DROP TABLE statut');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
