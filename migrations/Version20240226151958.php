<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240226151958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about_us ADD mn_description LONGTEXT DEFAULT NULL, ADD en_description LONGTEXT DEFAULT NULL, ADD cn_description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE content DROP body');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about_us DROP mn_description, DROP en_description, DROP cn_description');
        $this->addSql('ALTER TABLE content ADD body LONGTEXT DEFAULT NULL');
    }
}
