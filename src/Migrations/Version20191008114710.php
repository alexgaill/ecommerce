<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191008114710 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, type VARCHAR(100) NOT NULL, img VARCHAR(100) DEFAULT NULL, img_small VARCHAR(100) DEFAULT NULL, race VARCHAR(100) DEFAULT NULL, archetype VARCHAR(100) DEFAULT NULL, set_name VARCHAR(100) DEFAULT NULL, set_code VARCHAR(100) DEFAULT NULL, set_rarity INT DEFAULT NULL, cost DOUBLE PRECISION DEFAULT \'0\', price DOUBLE PRECISION DEFAULT \'0\', atk VARCHAR(6) DEFAULT NULL, def VARCHAR(6) DEFAULT NULL, level INT DEFAULT NULL, attribute VARCHAR(20) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, card_id_id INT NOT NULL, stock_type VARCHAR(100) NOT NULL, new INT DEFAULT 0 NOT NULL, correct INT DEFAULT 0 NOT NULL, occasion INT DEFAULT 0 NOT NULL, abimee INT DEFAULT 0 NOT NULL, INDEX IDX_4B36566047706F91 (card_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, adresse VARCHAR(150) NOT NULL, code_postal VARCHAR(10) NOT NULL, ville VARCHAR(100) NOT NULL, email VARCHAR(150) NOT NULL, telephone VARCHAR(20) NOT NULL, password VARCHAR(64) NOT NULL, code_validation VARCHAR(64) NOT NULL, valide TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B36566047706F91 FOREIGN KEY (card_id_id) REFERENCES products (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B36566047706F91');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE user');
    }
}
