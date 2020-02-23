<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200222173307 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE arrivage (id INT AUTO_INCREMENT NOT NULL, id_client_id INT NOT NULL, name VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, type VARCHAR(10) NOT NULL, total_ttc DOUBLE PRECISION NOT NULL, INDEX IDX_C079315899DED506 (id_client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_commande (id INT AUTO_INCREMENT NOT NULL, commande_id_id INT NOT NULL, product_id_id INT NOT NULL, type VARCHAR(50) NOT NULL, set_code VARCHAR(15) NOT NULL, new INT DEFAULT NULL, correct INT DEFAULT NULL, occasion INT DEFAULT NULL, abimee INT DEFAULT NULL, poids INT NOT NULL, total DOUBLE PRECISION NOT NULL, prix_unitaire DOUBLE PRECISION NOT NULL, INDEX IDX_3170B74B462C4194 (commande_id_id), INDEX IDX_3170B74BDE18E50B (product_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, card_id_id INT NOT NULL, stock_type VARCHAR(100) NOT NULL, new INT DEFAULT 0 NOT NULL, correct INT DEFAULT 0 NOT NULL, occasion INT DEFAULT 0 NOT NULL, abimee INT DEFAULT 0 NOT NULL, INDEX IDX_4B36566047706F91 (card_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, adresse VARCHAR(150) NOT NULL, code_postal VARCHAR(10) NOT NULL, ville VARCHAR(100) NOT NULL, email VARCHAR(150) NOT NULL, telephone VARCHAR(20) NOT NULL, password VARCHAR(64) NOT NULL, code_validation VARCHAR(64) NOT NULL, valide TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entry (id INT AUTO_INCREMENT NOT NULL, id_arrivage_id INT NOT NULL, id_stock_id INT NOT NULL, new INT NOT NULL, correct INT NOT NULL, occasion INT NOT NULL, abimee INT NOT NULL, total_ttc DOUBLE PRECISION NOT NULL, INDEX IDX_2B219D70F378B925 (id_arrivage_id), INDEX IDX_2B219D705D168D85 (id_stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, commande_date DATETIME NOT NULL, montant DOUBLE PRECISION NOT NULL, statut VARCHAR(20) NOT NULL, poids INT NOT NULL, type_paiement VARCHAR(20) NOT NULL, livraison VARCHAR(15) NOT NULL, tarif_livraison DOUBLE PRECISION DEFAULT NULL, montant_total DOUBLE PRECISION NOT NULL, type_livraison VARCHAR(15) DEFAULT NULL, INDEX IDX_6EEAA67D9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, type VARCHAR(100) NOT NULL, race VARCHAR(100) DEFAULT NULL, archetype VARCHAR(100) DEFAULT NULL, set_name VARCHAR(100) DEFAULT NULL, set_code VARCHAR(100) DEFAULT NULL, set_rarity VARCHAR(150) DEFAULT NULL, cost DOUBLE PRECISION DEFAULT \'0\', price DOUBLE PRECISION DEFAULT \'0\', atk VARCHAR(6) DEFAULT NULL, def VARCHAR(6) DEFAULT NULL, level INT DEFAULT NULL, attribute VARCHAR(20) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) DEFAULT NULL, url_small VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images_products (images_id INT NOT NULL, products_id INT NOT NULL, INDEX IDX_10992730D44F05E5 (images_id), INDEX IDX_109927306C8A81A9 (products_id), PRIMARY KEY(images_id, products_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE arrivage ADD CONSTRAINT FK_C079315899DED506 FOREIGN KEY (id_client_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74B462C4194 FOREIGN KEY (commande_id_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74BDE18E50B FOREIGN KEY (product_id_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B36566047706F91 FOREIGN KEY (card_id_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE entry ADD CONSTRAINT FK_2B219D70F378B925 FOREIGN KEY (id_arrivage_id) REFERENCES arrivage (id)');
        $this->addSql('ALTER TABLE entry ADD CONSTRAINT FK_2B219D705D168D85 FOREIGN KEY (id_stock_id) REFERENCES stock (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE images_products ADD CONSTRAINT FK_10992730D44F05E5 FOREIGN KEY (images_id) REFERENCES images (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images_products ADD CONSTRAINT FK_109927306C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE entry DROP FOREIGN KEY FK_2B219D70F378B925');
        $this->addSql('ALTER TABLE entry DROP FOREIGN KEY FK_2B219D705D168D85');
        $this->addSql('ALTER TABLE arrivage DROP FOREIGN KEY FK_C079315899DED506');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D9D86650F');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74B462C4194');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74BDE18E50B');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B36566047706F91');
        $this->addSql('ALTER TABLE images_products DROP FOREIGN KEY FK_109927306C8A81A9');
        $this->addSql('ALTER TABLE images_products DROP FOREIGN KEY FK_10992730D44F05E5');
        $this->addSql('DROP TABLE arrivage');
        $this->addSql('DROP TABLE ligne_commande');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE entry');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE images_products');
    }
}
