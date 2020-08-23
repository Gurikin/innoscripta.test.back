<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200823045742 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart_product RENAME INDEX idx_2d2515311ad5cdbf TO IDX_2890CCAA1AD5CDBF');
        $this->addSql('ALTER TABLE cart_product RENAME INDEX idx_2d2515314584665a TO IDX_2890CCAA4584665A');
        $this->addSql('ALTER TABLE customer ADD cart_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E091AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E091AD5CDBF ON customer (cart_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart_product RENAME INDEX idx_2890ccaa1ad5cdbf TO IDX_2D2515311AD5CDBF');
        $this->addSql('ALTER TABLE cart_product RENAME INDEX idx_2890ccaa4584665a TO IDX_2D2515314584665A');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E091AD5CDBF');
        $this->addSql('DROP INDEX UNIQ_81398E091AD5CDBF ON customer');
        $this->addSql('ALTER TABLE customer DROP cart_id');
    }
}
