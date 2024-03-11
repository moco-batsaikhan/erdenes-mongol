<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240311080308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_structure ADD en_name VARCHAR(255) DEFAULT NULL, ADD cn_name VARCHAR(255) DEFAULT NULL, ADD en_body LONGTEXT DEFAULT NULL, ADD cn_body LONGTEXT DEFAULT NULL, ADD en_address VARCHAR(255) DEFAULT NULL, ADD cn_address VARCHAR(255) DEFAULT NULL, CHANGE name mn_name VARCHAR(255) NOT NULL, CHANGE address mn_address VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_structure ADD address VARCHAR(255) DEFAULT NULL, DROP mn_address, DROP en_name, DROP cn_name, DROP en_body, DROP cn_body, DROP en_address, DROP cn_address, CHANGE mn_name name VARCHAR(255) NOT NULL');
    }
}
