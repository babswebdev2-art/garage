<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260106080036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ad DROP FOREIGN KEY FK_77E0ED5844F5D008');
        $this->addSql('DROP INDEX IDX_77E0ED5844F5D008 ON ad');
        $this->addSql('ALTER TABLE ad ADD kilometers INT NOT NULL, ADD cover_image VARCHAR(255) NOT NULL, ADD brand VARCHAR(255) NOT NULL, ADD owners INT NOT NULL, ADD engine VARCHAR(100) NOT NULL, ADD power INT NOT NULL, ADD fuel VARCHAR(100) NOT NULL, ADD year INT NOT NULL, DROP brand_id, DROP km, DROP image, DROP annee, DROP nb_proprietaires, DROP cylindree, DROP puissance, DROP carburant, CHANGE author_id author_id INT DEFAULT NULL, CHANGE slug slug VARCHAR(255) NOT NULL, CHANGE price price DOUBLE PRECISION NOT NULL, CHANGE transmission transmission VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE image CHANGE ad_id ad_id INT NOT NULL, CHANGE url url VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ad ADD brand_id INT NOT NULL, ADD km INT NOT NULL, ADD image VARCHAR(255) NOT NULL, ADD annee INT NOT NULL, ADD nb_proprietaires INT NOT NULL, ADD cylindree VARCHAR(255) NOT NULL, ADD puissance INT NOT NULL, ADD carburant VARCHAR(255) NOT NULL, DROP kilometers, DROP cover_image, DROP brand, DROP owners, DROP engine, DROP power, DROP fuel, DROP year, CHANGE author_id author_id INT NOT NULL, CHANGE slug slug LONGTEXT NOT NULL, CHANGE price price INT NOT NULL, CHANGE transmission transmission VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE ad ADD CONSTRAINT FK_77E0ED5844F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_77E0ED5844F5D008 ON ad (brand_id)');
        $this->addSql('ALTER TABLE image CHANGE ad_id ad_id INT DEFAULT NULL, CHANGE url url LONGTEXT NOT NULL');
    }
}
