<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240304210907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attr (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE device (id INT AUTO_INCREMENT NOT NULL, phone VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, status INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE device_props (id INT AUTO_INCREMENT NOT NULL, device_id INT DEFAULT NULL, prop_id INT DEFAULT NULL, INDEX IDX_9DFB4ACF94A4C7D4 (device_id), INDEX IDX_9DFB4ACFDEB3FFBD (prop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prop (id INT AUTO_INCREMENT NOT NULL, attr_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_AF6EC5EA747AE5C2 (attr_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE device_props ADD CONSTRAINT FK_9DFB4ACF94A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id)');
        $this->addSql('ALTER TABLE device_props ADD CONSTRAINT FK_9DFB4ACFDEB3FFBD FOREIGN KEY (prop_id) REFERENCES prop (id)');
        $this->addSql('ALTER TABLE prop ADD CONSTRAINT FK_AF6EC5EA747AE5C2 FOREIGN KEY (attr_id) REFERENCES attr (id)');
        $this->addSql('ALTER TABLE mobile CHANGE ram sim VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE device_props DROP FOREIGN KEY FK_9DFB4ACF94A4C7D4');
        $this->addSql('ALTER TABLE device_props DROP FOREIGN KEY FK_9DFB4ACFDEB3FFBD');
        $this->addSql('ALTER TABLE prop DROP FOREIGN KEY FK_AF6EC5EA747AE5C2');
        $this->addSql('DROP TABLE attr');
        $this->addSql('DROP TABLE device');
        $this->addSql('DROP TABLE device_props');
        $this->addSql('DROP TABLE prop');
        $this->addSql('ALTER TABLE mobile CHANGE sim ram VARCHAR(255) DEFAULT NULL');
    }
}
