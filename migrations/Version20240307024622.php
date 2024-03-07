<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240307024622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE strategy ADD mn_target LONGTEXT DEFAULT NULL, ADD en_target LONGTEXT DEFAULT NULL, ADD cn_target LONGTEXT DEFAULT NULL, DROP mn_slogan, DROP en_slogan, DROP cn_slogan, CHANGE pdf_file_name pdd_file_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE strategy ADD mn_slogan LONGTEXT DEFAULT NULL, ADD en_slogan LONGTEXT DEFAULT NULL, ADD cn_slogan LONGTEXT DEFAULT NULL, DROP mn_target, DROP en_target, DROP cn_target, CHANGE pdd_file_name pdf_file_name VARCHAR(255) DEFAULT NULL');
    }
}
