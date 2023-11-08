<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231108034109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin_roles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(32) DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, roles VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE banner (id INT AUTO_INCREMENT NOT NULL, icon VARCHAR(255) DEFAULT NULL, cn_text VARCHAR(255) DEFAULT NULL, mn_text VARCHAR(255) DEFAULT NULL, en_text VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, priority INT DEFAULT NULL, active TINYINT(1) DEFAULT NULL, image_url VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, end_date DATE NOT NULL, started_date DATE DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chart_value (id INT AUTO_INCREMENT NOT NULL, value JSON DEFAULT NULL, active TINYINT(1) NOT NULL, created_at DATE NOT NULL, updated_at DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE charts (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(32) DEFAULT NULL, description LONGTEXT DEFAULT NULL, value JSON DEFAULT NULL, active TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_admin_log (id INT AUTO_INCREMENT NOT NULL, admin_name VARCHAR(32) DEFAULT NULL, value VARCHAR(32) DEFAULT NULL, action VARCHAR(255) DEFAULT NULL, ip_address VARCHAR(32) DEFAULT NULL, created_at DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(16) DEFAULT NULL, password VARCHAR(32) DEFAULT NULL, email VARCHAR(32) DEFAULT NULL, firstname VARCHAR(16) DEFAULT NULL, lastname VARCHAR(16) DEFAULT NULL, phone VARCHAR(16) DEFAULT NULL, created_at DATE NOT NULL, updated_at DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content (id INT AUTO_INCREMENT NOT NULL, en_title VARCHAR(255) DEFAULT NULL, mn_title VARCHAR(255) DEFAULT NULL, cn_title VARCHAR(255) DEFAULT NULL, mn_content LONGTEXT DEFAULT NULL, en_content LONGTEXT DEFAULT NULL, cn_content LONGTEXT DEFAULT NULL, is_special TINYINT(1) DEFAULT NULL, created_at DATE DEFAULT NULL, updated_at DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_type (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(16) NOT NULL, created_at DATE NOT NULL, updated_at VARCHAR(16) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE currency (id INT AUTO_INCREMENT NOT NULL, base VARCHAR(32) DEFAULT NULL, rates LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', created_at DATE NOT NULL, updated_at DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE layout (id INT AUTO_INCREMENT NOT NULL, section_name VARCHAR(255) DEFAULT NULL, code VARCHAR(32) DEFAULT NULL, priority INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE main_category (id INT AUTO_INCREMENT NOT NULL, mn_name VARCHAR(36) DEFAULT NULL, cn_name VARCHAR(36) DEFAULT NULL, en_name VARCHAR(36) DEFAULT NULL, icon VARCHAR(255) DEFAULT NULL, type VARCHAR(36) DEFAULT NULL, priority INT DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, active TINYINT(1) DEFAULT NULL, created_at DATE DEFAULT NULL, updated_at DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE map (id INT AUTO_INCREMENT NOT NULL, coordinates JSON NOT NULL, data JSON DEFAULT NULL, offset_x INT DEFAULT NULL, offset_y INT DEFAULT NULL, data_type VARCHAR(16) NOT NULL, created_at DATE DEFAULT NULL, updated_at TIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partner_organization (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(32) DEFAULT NULL, icon VARCHAR(255) DEFAULT NULL, mn_title VARCHAR(32) DEFAULT NULL, en_title VARCHAR(32) DEFAULT NULL, cn_title VARCHAR(32) DEFAULT NULL, image_url VARCHAR(255) DEFAULT NULL, active TINYINT(1) NOT NULL, en_description VARCHAR(255) DEFAULT NULL, cn_description VARCHAR(255) DEFAULT NULL, mn_description VARCHAR(255) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, address VARCHAR(255) NOT NULL, created_at DATE NOT NULL, updated_at DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pdf (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(16) NOT NULL, created_at DATE NOT NULL, updated_at DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_category (id INT AUTO_INCREMENT NOT NULL, mn_name VARCHAR(32) NOT NULL, cn_name VARCHAR(32) DEFAULT NULL, en_name VARCHAR(32) NOT NULL, icon VARCHAR(255) DEFAULT NULL, priority INT DEFAULT NULL, opentype VARCHAR(16) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, active TINYINT(1) DEFAULT NULL, created_at DATE NOT NULL, updated_at DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_news (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE web_config (id INT AUTO_INCREMENT NOT NULL, color_code VARCHAR(32) DEFAULT NULL, font_size VARCHAR(32) DEFAULT NULL, priority VARCHAR(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE admin_roles');
        $this->addSql('DROP TABLE banner');
        $this->addSql('DROP TABLE chart_value');
        $this->addSql('DROP TABLE charts');
        $this->addSql('DROP TABLE cms_admin_log');
        $this->addSql('DROP TABLE cms_user');
        $this->addSql('DROP TABLE content');
        $this->addSql('DROP TABLE content_type');
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP TABLE layout');
        $this->addSql('DROP TABLE main_category');
        $this->addSql('DROP TABLE map');
        $this->addSql('DROP TABLE partner_organization');
        $this->addSql('DROP TABLE pdf');
        $this->addSql('DROP TABLE sub_category');
        $this->addSql('DROP TABLE video_news');
        $this->addSql('DROP TABLE web_config');
    }
}
