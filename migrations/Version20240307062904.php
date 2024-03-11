<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240307062904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE web_config ADD transparent_image VARCHAR(255) DEFAULT NULL, ADD slogan_image VARCHAR(255) DEFAULT NULL, ADD cover_image VARCHAR(255) DEFAULT NULL, ADD background_color VARCHAR(255) DEFAULT NULL, ADD updated_at DATE DEFAULT NULL, DROP font_size, DROP priority');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE web_config ADD font_size VARCHAR(32) DEFAULT NULL, ADD priority VARCHAR(1) DEFAULT NULL, DROP transparent_image, DROP slogan_image, DROP cover_image, DROP background_color, DROP updated_at');
    }
}
