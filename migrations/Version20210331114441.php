<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331114441 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medecin (id INT AUTO_INCREMENT NOT NULL, nom_medecin VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planning (id INT AUTO_INCREMENT NOT NULL, personnel_id INT NOT NULL, nom_p VARCHAR(255) NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, description_p VARCHAR(255) NOT NULL, INDEX IDX_D499BFF61C109075 (personnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF61C109075 FOREIGN KEY (personnel_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD plannings_id INT DEFAULT NULL, ADD user_id INT NOT NULL, ADD nom_rdv VARCHAR(255) NOT NULL, ADD description VARCHAR(255) DEFAULT NULL, ADD date_rdv DATETIME NOT NULL');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A8DFC1B84 FOREIGN KEY (plannings_id) REFERENCES planning (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_65E8AA0A8DFC1B84 ON rendez_vous (plannings_id)');
        $this->addSql('CREATE INDEX IDX_65E8AA0AA76ED395 ON rendez_vous (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A8DFC1B84');
        $this->addSql('DROP TABLE medecin');
        $this->addSql('DROP TABLE planning');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AA76ED395');
        $this->addSql('DROP INDEX IDX_65E8AA0A8DFC1B84 ON rendez_vous');
        $this->addSql('DROP INDEX IDX_65E8AA0AA76ED395 ON rendez_vous');
        $this->addSql('ALTER TABLE rendez_vous DROP plannings_id, DROP user_id, DROP nom_rdv, DROP description, DROP date_rdv');
    }
}
