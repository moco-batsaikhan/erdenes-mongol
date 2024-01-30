<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231206023614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE content ADD active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE main_category DROP icon');
        $this->addSql('ALTER TABLE news ADD active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE sub_category DROP icon');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE news DROP active');
        $this->addSql('ALTER TABLE main_category ADD icon VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sub_category ADD icon VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE content DROP active');
    }
}
