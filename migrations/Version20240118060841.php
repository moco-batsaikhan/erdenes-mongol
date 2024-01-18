<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240118060841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE map ADD latitude INT NOT NULL, ADD longitude INT NOT NULL, ADD name VARCHAR(255) NOT NULL, ADD information VARCHAR(255) DEFAULT NULL, DROP coordinates, DROP data, DROP offset_x, DROP offset_y');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE map ADD coordinates JSON NOT NULL, ADD data JSON DEFAULT NULL, ADD offset_x INT DEFAULT NULL, ADD offset_y INT DEFAULT NULL, DROP latitude, DROP longitude, DROP name, DROP information');
    }
}
