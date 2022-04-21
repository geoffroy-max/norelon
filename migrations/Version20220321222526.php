<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220321222526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE orderdetail_s1 (id INT AUTO_INCREMENT NOT NULL, product VARCHAR(255) NOT NULL, quantity INT NOT NULL, price DOUBLE PRECISION NOT NULL, total DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE order_detail1');
        $this->addSql('ALTER TABLE order1 ADD orderdetail_s1_id INT NOT NULL');
        $this->addSql('ALTER TABLE order1 ADD CONSTRAINT FK_7DFDDD529138E8C5 FOREIGN KEY (orderdetail_s1_id) REFERENCES orderdetail_s1 (id)');
        $this->addSql('CREATE INDEX IDX_7DFDDD529138E8C5 ON order1 (orderdetail_s1_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order1 DROP FOREIGN KEY FK_7DFDDD529138E8C5');
        $this->addSql('CREATE TABLE order_detail1 (id INT AUTO_INCREMENT NOT NULL, order1_id INT NOT NULL, product VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, quantity INT NOT NULL, price DOUBLE PRECISION NOT NULL, total DOUBLE PRECISION NOT NULL, INDEX IDX_1C8E827DFEE30A60 (order1_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE order_detail1 ADD CONSTRAINT FK_1C8E827DFEE30A60 FOREIGN KEY (order1_id) REFERENCES order1 (id)');
        $this->addSql('DROP TABLE orderdetail_s1');
        $this->addSql('DROP INDEX IDX_7DFDDD529138E8C5 ON order1');
        $this->addSql('ALTER TABLE order1 DROP orderdetail_s1_id');
    }
}
