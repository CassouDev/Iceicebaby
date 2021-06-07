<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210606164357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE factory_order (id INT AUTO_INCREMENT NOT NULL, factory_firstname VARCHAR(255) NOT NULL, factory_lastname VARCHAR(255) NOT NULL, factory_mail VARCHAR(255) NOT NULL, factory_date DATETIME NOT NULL, factory_deadline DATETIME NOT NULL, factory_request LONGTEXT NOT NULL, factory_status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, oder_date DATETIME NOT NULL, order_price INT NOT NULL, oder_delivery_date DATETIME NOT NULL, order_status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_order (id INT AUTO_INCREMENT NOT NULL, order_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, user_gender VARCHAR(255) NOT NULL, user_firstname VARCHAR(255) NOT NULL, user_lastname VARCHAR(255) NOT NULL, user_mail VARCHAR(255) NOT NULL, user_phone_number INT DEFAULT NULL, user_password VARCHAR(255) NOT NULL, user_adress VARCHAR(255) NOT NULL, user_complement VARCHAR(255) DEFAULT NULL, user_city VARCHAR(255) NOT NULL, user_postcode INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product CHANGE product_type product_type LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE factory_order');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE product_order');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE product CHANGE product_type product_type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
