<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240321033130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee ADD en_name VARCHAR(32) NOT NULL, ADD cn_name VARCHAR(32) NOT NULL, ADD en_division VARCHAR(255) NOT NULL, ADD cn_division VARCHAR(255) NOT NULL, ADD en_experience LONGTEXT DEFAULT NULL, ADD cn_experience LONGTEXT DEFAULT NULL, CHANGE name mn_name VARCHAR(32) NOT NULL, CHANGE division mn_division VARCHAR(255) NOT NULL, CHANGE experience mn_experience LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee ADD name VARCHAR(32) NOT NULL, ADD division VARCHAR(255) NOT NULL, ADD experience LONGTEXT DEFAULT NULL, DROP mn_name, DROP en_name, DROP cn_name, DROP mn_division, DROP en_division, DROP cn_division, DROP mn_experience, DROP en_experience, DROP cn_experience');
    }
}
