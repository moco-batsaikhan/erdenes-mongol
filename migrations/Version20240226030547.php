<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240226030547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE currency ADD file JSON DEFAULT NULL, DROP base, DROP rates');
        $this->addSql('ALTER TABLE map ADD description LONGTEXT DEFAULT NULL, ADD body LONGTEXT DEFAULT NULL, DROP information');
        $this->addSql('ALTER TABLE news ADD body_image_url VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE currency ADD base VARCHAR(32) DEFAULT NULL, ADD rates LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', DROP file');
        $this->addSql('ALTER TABLE map ADD information VARCHAR(255) DEFAULT NULL, DROP description, DROP body');
        $this->addSql('ALTER TABLE news DROP body_image_url');
    }
}
