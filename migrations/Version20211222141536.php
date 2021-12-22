<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211222141536 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_plat (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_57112550CCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_plat_plat (categorie_plat_id INT NOT NULL, plat_id INT NOT NULL, INDEX IDX_3AFC400F88BE1BC2 (categorie_plat_id), INDEX IDX_3AFC400FD73DB560 (plat_id), PRIMARY KEY(categorie_plat_id, plat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plat (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie_plat ADD CONSTRAINT FK_57112550CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE categorie_plat_plat ADD CONSTRAINT FK_3AFC400F88BE1BC2 FOREIGN KEY (categorie_plat_id) REFERENCES categorie_plat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_plat_plat ADD CONSTRAINT FK_3AFC400FD73DB560 FOREIGN KEY (plat_id) REFERENCES plat (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie_plat_plat DROP FOREIGN KEY FK_3AFC400F88BE1BC2');
        $this->addSql('ALTER TABLE categorie_plat DROP FOREIGN KEY FK_57112550CCD7E912');
        $this->addSql('ALTER TABLE categorie_plat_plat DROP FOREIGN KEY FK_3AFC400FD73DB560');
        $this->addSql('DROP TABLE categorie_plat');
        $this->addSql('DROP TABLE categorie_plat_plat');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE plat');
    }
}
