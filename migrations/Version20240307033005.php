<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240307033005 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about_us DROP mn_purpose, DROP en_purpose, DROP cn_purpose, DROP mn_vision, DROP en_vision, DROP en_slogan, DROP mn_slogan, DROP cn_slogan, DROP cn_vision');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about_us ADD mn_purpose VARCHAR(255) DEFAULT NULL, ADD en_purpose VARCHAR(255) DEFAULT NULL, ADD cn_purpose VARCHAR(255) DEFAULT NULL, ADD mn_vision VARCHAR(255) DEFAULT NULL, ADD en_vision VARCHAR(255) DEFAULT NULL, ADD en_slogan VARCHAR(255) DEFAULT NULL, ADD mn_slogan VARCHAR(255) DEFAULT NULL, ADD cn_slogan VARCHAR(255) DEFAULT NULL, ADD cn_vision VARCHAR(255) DEFAULT NULL');
    }
}
