<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230925095802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE simulation (id INT AUTO_INCREMENT NOT NULL, facturation_id INT NOT NULL, data_id INT NOT NULL, date DATETIME NOT NULL, resultat LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_CBDA467BDBC5F284 (facturation_id), INDEX IDX_CBDA467B37F5A13C (data_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE simulation ADD CONSTRAINT FK_CBDA467BDBC5F284 FOREIGN KEY (facturation_id) REFERENCES facturation (id)');
        $this->addSql('ALTER TABLE simulation ADD CONSTRAINT FK_CBDA467B37F5A13C FOREIGN KEY (data_id) REFERENCES import (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE simulation DROP FOREIGN KEY FK_CBDA467BDBC5F284');
        $this->addSql('ALTER TABLE simulation DROP FOREIGN KEY FK_CBDA467B37F5A13C');
        $this->addSql('DROP TABLE simulation');
    }
}
