<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200818104912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create product_type table';
    }

    public function up(Schema $schema): void
    {
        $sql = 'CREATE TABLE if not exists `product_types` (
            `id` int NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)) ENGINE=InnoDB';
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $sql = 'DROP TABLE IF EXISTS `product_types`';
        $this->addSql($sql);
    }
}
