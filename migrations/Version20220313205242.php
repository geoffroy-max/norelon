<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220313205242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order1 (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL, is_paid TINYINT(1) NOT NULL, reference VARCHAR(255) NOT NULL, delivery LONGTEXT NOT NULL, carrier_name VARCHAR(255) NOT NULL, carrier_price DOUBLE PRECISION NOT NULL, INDEX IDX_7DFDDD52A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order2 (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, reference VARCHAR(255) NOT NULL, carrier_name VARCHAR(255) NOT NULL, carrier_price DOUBLE PRECISION NOT NULL, delivery LONGTEXT NOT NULL, is_paid TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_detail1 (id INT AUTO_INCREMENT NOT NULL, order1_id INT NOT NULL, product VARCHAR(255) NOT NULL, quantity INT NOT NULL, price DOUBLE PRECISION NOT NULL, total DOUBLE PRECISION NOT NULL, INDEX IDX_1C8E827DFEE30A60 (order1_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order1 ADD CONSTRAINT FK_7DFDDD52A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE order_detail1 ADD CONSTRAINT FK_1C8E827DFEE30A60 FOREIGN KEY (order1_id) REFERENCES order1 (id)');
        $this->addSql('DROP TABLE commande_detail');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_detail1 DROP FOREIGN KEY FK_1C8E827DFEE30A60');
        $this->addSql('CREATE TABLE commande_detail (commande_id INT NOT NULL, INDEX IDX_2C52844682EA2E54 (commande_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commande_detail ADD CONSTRAINT FK_2C52844682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('DROP TABLE order1');
        $this->addSql('DROP TABLE order2');
        $this->addSql('DROP TABLE order_detail1');
    }
}
