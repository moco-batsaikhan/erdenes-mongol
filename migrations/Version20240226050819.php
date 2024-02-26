<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240226050819 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE organization DROP image_url, DROP mn_description, DROP en_description, DROP cn_description, DROP contact, DROP web_url, DROP address, DROP type');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE organization ADD image_url VARCHAR(255) DEFAULT NULL, ADD mn_description LONGTEXT DEFAULT NULL, ADD en_description VARCHAR(255) DEFAULT NULL, ADD cn_description LONGTEXT NOT NULL, ADD contact VARCHAR(255) DEFAULT NULL, ADD web_url VARCHAR(255) DEFAULT NULL, ADD address VARCHAR(255) NOT NULL, ADD type VARCHAR(32) NOT NULL');
    }
}
