<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210227203924 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chambre DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE chambre CHANGE num_chambre num INT NOT NULL');
        $this->addSql('ALTER TABLE chambre ADD PRIMARY KEY (num)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chambre DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE chambre CHANGE num num_chambre INT NOT NULL');
        $this->addSql('ALTER TABLE chambre ADD PRIMARY KEY (num_chambre)');
    }
}
