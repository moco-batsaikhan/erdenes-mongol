<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229023054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
       $this->addSql('ALTER TABLE employee ADD type TINYINT(1) DEFAULT NULL, ADD experience LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
       $this->addSql('ALTER TABLE employee DROP type, DROP experience');
    }
}
