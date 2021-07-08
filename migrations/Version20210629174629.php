<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210629174629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_order ADD order_id_id INT NOT NULL, ADD product_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE product_order ADD CONSTRAINT FK_5475E8C4FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE product_order ADD CONSTRAINT FK_5475E8C4DE18E50B FOREIGN KEY (product_id_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_5475E8C4FCDAEAAA ON product_order (order_id_id)');
        $this->addSql('CREATE INDEX IDX_5475E8C4DE18E50B ON product_order (product_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_order DROP FOREIGN KEY FK_5475E8C4FCDAEAAA');
        $this->addSql('ALTER TABLE product_order DROP FOREIGN KEY FK_5475E8C4DE18E50B');
        $this->addSql('DROP INDEX IDX_5475E8C4FCDAEAAA ON product_order');
        $this->addSql('DROP INDEX IDX_5475E8C4DE18E50B ON product_order');
        $this->addSql('ALTER TABLE product_order DROP order_id_id, DROP product_id_id');
    }
}
