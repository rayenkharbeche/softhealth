<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210310225857 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medecin (id INT AUTO_INCREMENT NOT NULL, nom_medecin VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, rendez_vous_id INT DEFAULT NULL, nom_patient VARCHAR(255) NOT NULL, INDEX IDX_1ADAD7EB91EF7EAA (rendez_vous_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planning (id INT AUTO_INCREMENT NOT NULL, personnel_id INT DEFAULT NULL, nom_p VARCHAR(255) NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, description_p VARCHAR(255) NOT NULL, INDEX IDX_D499BFF61C109075 (personnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, plannings_id INT DEFAULT NULL, nom_rdv VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, date_rdv DATE NOT NULL, heure_rdv TIME NOT NULL, INDEX IDX_65E8AA0A8DFC1B84 (plannings_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, rendez_vous_id INT DEFAULT NULL, nom_user VARCHAR(255) NOT NULL, INDEX IDX_8D93D64991EF7EAA (rendez_vous_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB91EF7EAA FOREIGN KEY (rendez_vous_id) REFERENCES rendez_vous (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF61C109075 FOREIGN KEY (personnel_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A8DFC1B84 FOREIGN KEY (plannings_id) REFERENCES planning (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D64991EF7EAA FOREIGN KEY (rendez_vous_id) REFERENCES rendez_vous (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A8DFC1B84');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB91EF7EAA');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64991EF7EAA');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF61C109075');
        $this->addSql('DROP TABLE medecin');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE planning');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE `user`');
    }
}
