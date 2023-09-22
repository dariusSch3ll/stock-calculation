<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230614135531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE stock_calculation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE warehouse_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE stock_calculation (id INT NOT NULL, shop VARCHAR(255) NOT NULL, sku VARCHAR(255) NOT NULL, minimum_stock INT DEFAULT 0 NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE stock_calculation_warehouse (stock_calculation_id INT NOT NULL, warehouse_id INT NOT NULL, PRIMARY KEY(stock_calculation_id, warehouse_id))');
        $this->addSql('CREATE INDEX IDX_C481867D69DEF278 ON stock_calculation_warehouse (stock_calculation_id)');
        $this->addSql('CREATE INDEX IDX_C481867D5080ECDE ON stock_calculation_warehouse (warehouse_id)');
        $this->addSql('CREATE TABLE warehouse (id INT NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE stock_calculation_warehouse ADD CONSTRAINT FK_C481867D69DEF278 FOREIGN KEY (stock_calculation_id) REFERENCES stock_calculation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE stock_calculation_warehouse ADD CONSTRAINT FK_C481867D5080ECDE FOREIGN KEY (warehouse_id) REFERENCES warehouse (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE stock_calculation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE warehouse_id_seq CASCADE');
        $this->addSql('ALTER TABLE stock_calculation_warehouse DROP CONSTRAINT FK_C481867D69DEF278');
        $this->addSql('ALTER TABLE stock_calculation_warehouse DROP CONSTRAINT FK_C481867D5080ECDE');
        $this->addSql('DROP TABLE stock_calculation');
        $this->addSql('DROP TABLE stock_calculation_warehouse');
        $this->addSql('DROP TABLE warehouse');
    }
}
