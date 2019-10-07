<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191005083949 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, type INT NOT NULL, img VARCHAR(100) NOT NULL, rarity INT NOT NULL, abimee INT DEFAULT 0 NOT NULL, occasion INT DEFAULT 0 NOT NULL, correct INT DEFAULT 0 NOT NULL, neuve INT DEFAULT 0 NOT NULL, cost DOUBLE PRECISION DEFAULT \'0\' NOT NULL, price DOUBLE PRECISION DEFAULT \'0\' NOT NULL, atk VARCHAR(6) NOT NULL, def VARCHAR(6) NOT NULL, text LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, adresse VARCHAR(150) NOT NULL, code_postal VARCHAR(10) NOT NULL, ville VARCHAR(100) NOT NULL, email VARCHAR(150) NOT NULL, telephone VARCHAR(20) NOT NULL, password VARCHAR(64) NOT NULL, code_validation VARCHAR(64) NOT NULL, valide TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE user');
    }
}
