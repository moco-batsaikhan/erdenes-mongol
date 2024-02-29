<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229013305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE strategy (id INT AUTO_INCREMENT NOT NULL, mn_title VARCHAR(255) DEFAULT NULL, en_title VARCHAR(255) DEFAULT NULL, cn_title VARCHAR(255) DEFAULT NULL, en_vision LONGTEXT DEFAULT NULL, mn_vision LONGTEXT DEFAULT NULL, cn_vision LONGTEXT DEFAULT NULL, mn_mission LONGTEXT DEFAULT NULL, en_mission LONGTEXT DEFAULT NULL, cn_mission LONGTEXT DEFAULT NULL, mn_purpose LONGTEXT DEFAULT NULL, cn_purpose LONGTEXT DEFAULT NULL, mn_target LONGTEXT DEFAULT NULL, en_target LONGTEXT DEFAULT NULL, cn_target LONGTEXT DEFAULT NULL, mn_result LONGTEXT DEFAULT NULL, en_result LONGTEXT DEFAULT NULL, cn_result LONGTEXT DEFAULT NULL, created_at DATE DEFAULT NULL, updated_at DATE DEFAULT NULL, en_purpose LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE strategy');
    }
}
