<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210702150219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989D86650F');
        $this->addSql('DROP INDEX IDX_F52993989D86650F ON `order`');
        $this->addSql('ALTER TABLE `order` CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON `order` (user_id)');
        $this->addSql('ALTER TABLE product_order DROP FOREIGN KEY FK_5475E8C4DE18E50B');
        $this->addSql('ALTER TABLE product_order DROP FOREIGN KEY FK_5475E8C4FCDAEAAA');
        $this->addSql('DROP INDEX IDX_5475E8C4DE18E50B ON product_order');
        $this->addSql('DROP INDEX IDX_5475E8C4FCDAEAAA ON product_order');
        $this->addSql('ALTER TABLE product_order ADD order_id INT NOT NULL, ADD product_id INT NOT NULL, DROP order_id_id, DROP product_id_id');
        $this->addSql('ALTER TABLE product_order ADD CONSTRAINT FK_5475E8C48D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE product_order ADD CONSTRAINT FK_5475E8C44584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_5475E8C48D9F6D38 ON product_order (order_id)');
        $this->addSql('CREATE INDEX IDX_5475E8C44584665A ON product_order (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395 ON `order`');
        $this->addSql('ALTER TABLE `order` CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993989D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F52993989D86650F ON `order` (user_id_id)');
        $this->addSql('ALTER TABLE product_order DROP FOREIGN KEY FK_5475E8C48D9F6D38');
        $this->addSql('ALTER TABLE product_order DROP FOREIGN KEY FK_5475E8C44584665A');
        $this->addSql('DROP INDEX IDX_5475E8C48D9F6D38 ON product_order');
        $this->addSql('DROP INDEX IDX_5475E8C44584665A ON product_order');
        $this->addSql('ALTER TABLE product_order ADD order_id_id INT NOT NULL, ADD product_id_id INT NOT NULL, DROP order_id, DROP product_id');
        $this->addSql('ALTER TABLE product_order ADD CONSTRAINT FK_5475E8C4DE18E50B FOREIGN KEY (product_id_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_order ADD CONSTRAINT FK_5475E8C4FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_5475E8C4DE18E50B ON product_order (product_id_id)');
        $this->addSql('CREATE INDEX IDX_5475E8C4FCDAEAAA ON product_order (order_id_id)');
    }
}
