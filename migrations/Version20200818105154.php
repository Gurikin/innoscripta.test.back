<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200818105154 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'create product table';
    }

    public function up(Schema $schema) : void
    {
        $sql = 'CREATE TABLE `product` (
          `id` int NOT NULL AUTO_INCREMENT,
          `name` varchar(255) NOT NULL,
          `product_type` int NOT NULL,
          `price` float NOT NULL,
          `description` text,
          `image_url` varchar(255) DEFAULT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `name` (`name`,`product_type`),
          KEY `product_type` (`product_type`),
          CONSTRAINT `product_ibfk_1` FOREIGN KEY (`product_type`) REFERENCES `product_types` (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci';
        $this->addSql($sql);
    }

    public function down(Schema $schema) : void
    {
        $sql = 'DROP TABLE IF EXISTS `product`';
        $this->addSql($sql);
    }
}
