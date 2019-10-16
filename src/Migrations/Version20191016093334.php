<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191016093334 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE arrivage (id INT AUTO_INCREMENT NOT NULL, id_client_id INT NOT NULL, name VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, type VARCHAR(10) NOT NULL, total_ttc DOUBLE PRECISION NOT NULL, INDEX IDX_C079315899DED506 (id_client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entry (id INT AUTO_INCREMENT NOT NULL, id_arrivage_id INT NOT NULL, id_stock_id INT NOT NULL, new INT NOT NULL, correct INT NOT NULL, occasion INT NOT NULL, abimee INT NOT NULL, total_ttc DOUBLE PRECISION NOT NULL, INDEX IDX_2B219D70F378B925 (id_arrivage_id), INDEX IDX_2B219D705D168D85 (id_stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE arrivage ADD CONSTRAINT FK_C079315899DED506 FOREIGN KEY (id_client_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE entry ADD CONSTRAINT FK_2B219D70F378B925 FOREIGN KEY (id_arrivage_id) REFERENCES arrivage (id)');
        $this->addSql('ALTER TABLE entry ADD CONSTRAINT FK_2B219D705D168D85 FOREIGN KEY (id_stock_id) REFERENCES stock (id)');
        $this->addSql('ALTER TABLE products CHANGE img img VARCHAR(100) DEFAULT NULL, CHANGE img_small img_small VARCHAR(100) DEFAULT NULL, CHANGE race race VARCHAR(100) DEFAULT NULL, CHANGE archetype archetype VARCHAR(100) DEFAULT NULL, CHANGE set_name set_name VARCHAR(100) DEFAULT NULL, CHANGE set_code set_code VARCHAR(100) DEFAULT NULL, CHANGE set_rarity set_rarity INT DEFAULT NULL, CHANGE atk atk VARCHAR(6) DEFAULT NULL, CHANGE def def VARCHAR(6) DEFAULT NULL, CHANGE level level INT DEFAULT NULL, CHANGE attribute attribute VARCHAR(20) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE entry DROP FOREIGN KEY FK_2B219D70F378B925');
        $this->addSql('DROP TABLE arrivage');
        $this->addSql('DROP TABLE entry');
        $this->addSql('ALTER TABLE products CHANGE img img VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE img_small img_small VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE race race VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE archetype archetype VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE set_name set_name VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE set_code set_code VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE set_rarity set_rarity INT DEFAULT NULL, CHANGE atk atk VARCHAR(6) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE def def VARCHAR(6) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE level level INT DEFAULT NULL, CHANGE attribute attribute VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
