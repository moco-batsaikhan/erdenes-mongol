<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231228063043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE main_category ADD click_type VARCHAR(255) NOT NULL, DROP url');
        $this->addSql('ALTER TABLE news_type DROP click_type');
        $this->addSql('ALTER TABLE sub_category ADD click_type VARCHAR(255) NOT NULL, DROP url');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE main_category ADD url VARCHAR(255) DEFAULT NULL, DROP click_type');
        $this->addSql('ALTER TABLE news_type ADD click_type VARCHAR(32) NOT NULL');
        $this->addSql('ALTER TABLE sub_category ADD url VARCHAR(255) DEFAULT NULL, DROP click_type');
    }
}
