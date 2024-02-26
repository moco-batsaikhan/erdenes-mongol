<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240226041218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE map ADD en_description LONGTEXT DEFAULT NULL, ADD mn_body LONGTEXT DEFAULT NULL, ADD mn_description LONGTEXT DEFAULT NULL, ADD cn_description LONGTEXT DEFAULT NULL, ADD en_body LONGTEXT DEFAULT NULL, ADD cn_body LONGTEXT DEFAULT NULL, DROP description, DROP body');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE map ADD description LONGTEXT DEFAULT NULL, ADD body LONGTEXT DEFAULT NULL, DROP en_description, DROP mn_body, DROP mn_description, DROP cn_description, DROP en_body, DROP cn_body');
    }
}
