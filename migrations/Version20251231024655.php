<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251231024655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ad (id INT AUTO_INCREMENT NOT NULL, brand_id INT NOT NULL, title VARCHAR(255) NOT NULL, slug LONGTEXT NOT NULL, model VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price INT NOT NULL, km INT NOT NULL, cover_image VARCHAR(255) NOT NULL, annee INT NOT NULL, nb_proprietaires INT NOT NULL, cylindree VARCHAR(255) NOT NULL, puissance INT NOT NULL, carburant VARCHAR(255) NOT NULL, transmission VARCHAR(255) NOT NULL, options LONGTEXT NOT NULL, INDEX IDX_77E0ED5844F5D008 (brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ad ADD CONSTRAINT FK_77E0ED5844F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ad DROP FOREIGN KEY FK_77E0ED5844F5D008');
        $this->addSql('DROP TABLE ad');
    }
}
