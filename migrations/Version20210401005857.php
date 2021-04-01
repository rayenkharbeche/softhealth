<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210401005857 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, colors VARCHAR(7) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chambre (num INT NOT NULL, category_id INT DEFAULT NULL, numetage VARCHAR(255) NOT NULL, nbrplace VARCHAR(255) NOT NULL, service VARCHAR(255) NOT NULL, bloc VARCHAR(255) NOT NULL, INDEX IDX_C509E4FF12469DE2 (category_id), PRIMARY KEY(num)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dossier (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) DEFAULT NULL, date_creation DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fichier (id INT AUTO_INCREMENT NOT NULL, dossier_id INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, file VARCHAR(255) DEFAULT NULL, INDEX IDX_9B76551F611C0C56 (dossier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medicament (id INT AUTO_INCREMENT NOT NULL, code INT NOT NULL, name VARCHAR(255) NOT NULL, prix INT NOT NULL, stock INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ordonnance (id INT AUTO_INCREMENT NOT NULL, medicaments_id INT DEFAULT NULL, consultation_id INT DEFAULT NULL, patient_id INT DEFAULT NULL, medecin_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, nbr_jrs INT NOT NULL, nbr_doses DOUBLE PRECISION NOT NULL, nbr_fois INT NOT NULL, nbr_paquets INT NOT NULL, INDEX IDX_924B326CC403D7FB (medicaments_id), INDEX IDX_924B326C62FF6CDF (consultation_id), INDEX IDX_924B326C6B899279 (patient_id), INDEX IDX_924B326C4F31A84 (medecin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT FK_C509E4FF12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE fichier ADD CONSTRAINT FK_9B76551F611C0C56 FOREIGN KEY (dossier_id) REFERENCES dossier (id)');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326CC403D7FB FOREIGN KEY (medicaments_id) REFERENCES medicament (id)');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326C62FF6CDF FOREIGN KEY (consultation_id) REFERENCES consultation (id)');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326C6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326C4F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chambre DROP FOREIGN KEY FK_C509E4FF12469DE2');
        $this->addSql('ALTER TABLE fichier DROP FOREIGN KEY FK_9B76551F611C0C56');
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY FK_924B326CC403D7FB');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE chambre');
        $this->addSql('DROP TABLE dossier');
        $this->addSql('DROP TABLE fichier');
        $this->addSql('DROP TABLE medicament');
        $this->addSql('DROP TABLE ordonnance');
    }
}
