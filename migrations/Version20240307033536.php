<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240307033536 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about_us ADD mn_vision LONGTEXT DEFAULT NULL, ADD en_vision LONGTEXT DEFAULT NULL, ADD cn_vision LONGTEXT DEFAULT NULL, ADD en_value LONGTEXT NOT NULL, ADD mn_value LONGTEXT DEFAULT NULL, ADD cn_value LONGTEXT DEFAULT NULL, ADD en_strategy_purpose LONGTEXT DEFAULT NULL, ADD mn_strategy_purppose LONGTEXT DEFAULT NULL, ADD cn_strategy_purpose LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about_us DROP mn_vision, DROP en_vision, DROP cn_vision, DROP en_value, DROP mn_value, DROP cn_value, DROP en_strategy_purpose, DROP mn_strategy_purppose, DROP cn_strategy_purpose');
    }
}
