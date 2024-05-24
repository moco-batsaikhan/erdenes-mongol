<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240517024747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job_ads ADD en_title VARCHAR(255) DEFAULT NULL, ADD cn_title VARCHAR(255) DEFAULT NULL, ADD en_profession VARCHAR(255) DEFAULT NULL, ADD cn_profession VARCHAR(255) DEFAULT NULL, ADD en_body LONGTEXT DEFAULT NULL, ADD cn_body LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job_ads DROP en_title, DROP cn_title, DROP en_profession, DROP cn_profession, DROP en_body, DROP cn_body');
    }
}
