<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231109042435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_click (id INT AUTO_INCREMENT NOT NULL, news_id INT NOT NULL, main_category_id INT NOT NULL, sub_category_id INT NOT NULL, INDEX IDX_52C58D69B5A459A0 (news_id), INDEX IDX_52C58D69C6C55574 (main_category_id), INDEX IDX_52C58D69F7BFE87C (sub_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_connection (id INT AUTO_INCREMENT NOT NULL, news_id INT NOT NULL, content_id INT NOT NULL, INDEX IDX_B0CEC594B5A459A0 (news_id), INDEX IDX_B0CEC59484A0A3ED (content_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, created_user_id INT NOT NULL, en_title VARCHAR(255) DEFAULT NULL, mn_title VARCHAR(255) DEFAULT NULL, cn_title VARCHAR(255) DEFAULT NULL, is_special TINYINT(1) DEFAULT NULL, created_at DATE DEFAULT NULL, updated_at DATE DEFAULT NULL, image_url VARCHAR(255) DEFAULT NULL, mn_headline VARCHAR(255) DEFAULT NULL, en_headline VARCHAR(255) DEFAULT NULL, cn_headline VARCHAR(255) DEFAULT NULL, INDEX IDX_1DD39950E104C1D3 (created_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_click ADD CONSTRAINT FK_52C58D69B5A459A0 FOREIGN KEY (news_id) REFERENCES news (id)');
        $this->addSql('ALTER TABLE category_click ADD CONSTRAINT FK_52C58D69C6C55574 FOREIGN KEY (main_category_id) REFERENCES main_category (id)');
        $this->addSql('ALTER TABLE category_click ADD CONSTRAINT FK_52C58D69F7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id)');
        $this->addSql('ALTER TABLE content_connection ADD CONSTRAINT FK_B0CEC594B5A459A0 FOREIGN KEY (news_id) REFERENCES news (id)');
        $this->addSql('ALTER TABLE content_connection ADD CONSTRAINT FK_B0CEC59484A0A3ED FOREIGN KEY (content_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD39950E104C1D3 FOREIGN KEY (created_user_id) REFERENCES cms_user (id)');
        $this->addSql('DROP TABLE admin_roles');
        $this->addSql('DROP TABLE chart_value');
        $this->addSql('DROP TABLE charts');
        $this->addSql('DROP TABLE content_type');
        $this->addSql('DROP TABLE pdf');
        $this->addSql('ALTER TABLE banner ADD created_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE banner ADD CONSTRAINT FK_6F9DB8E7E104C1D3 FOREIGN KEY (created_user_id) REFERENCES cms_user (id)');
        $this->addSql('CREATE INDEX IDX_6F9DB8E7E104C1D3 ON banner (created_user_id)');
        $this->addSql('ALTER TABLE cms_user ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE content ADD name VARCHAR(255) DEFAULT NULL, ADD type VARCHAR(255) NOT NULL, ADD body LONGTEXT NOT NULL, ADD priority INT NOT NULL, DROP en_title, DROP mn_title, DROP cn_title, DROP mn_content, DROP en_content, DROP cn_content, DROP is_special, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE currency ADD created_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE currency ADD CONSTRAINT FK_6956883FE104C1D3 FOREIGN KEY (created_user_id) REFERENCES cms_user (id)');
        $this->addSql('CREATE INDEX IDX_6956883FE104C1D3 ON currency (created_user_id)');
        $this->addSql('ALTER TABLE main_category ADD created_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE main_category ADD CONSTRAINT FK_DF6E08B4E104C1D3 FOREIGN KEY (created_user_id) REFERENCES cms_user (id)');
        $this->addSql('CREATE INDEX IDX_DF6E08B4E104C1D3 ON main_category (created_user_id)');
        $this->addSql('ALTER TABLE map ADD created_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE map ADD CONSTRAINT FK_93ADAABBE104C1D3 FOREIGN KEY (created_user_id) REFERENCES cms_user (id)');
        $this->addSql('CREATE INDEX IDX_93ADAABBE104C1D3 ON map (created_user_id)');
        $this->addSql('ALTER TABLE partner_organization ADD created_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE partner_organization ADD CONSTRAINT FK_50C37C5DE104C1D3 FOREIGN KEY (created_user_id) REFERENCES cms_user (id)');
        $this->addSql('CREATE INDEX IDX_50C37C5DE104C1D3 ON partner_organization (created_user_id)');
        $this->addSql('ALTER TABLE sub_category ADD created_user_id INT NOT NULL, ADD main_category_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F798E104C1D3 FOREIGN KEY (created_user_id) REFERENCES cms_user (id)');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F798197B9A54 FOREIGN KEY (main_category_id_id) REFERENCES main_category (id)');
        $this->addSql('CREATE INDEX IDX_BCE3F798E104C1D3 ON sub_category (created_user_id)');
        $this->addSql('CREATE INDEX IDX_BCE3F798197B9A54 ON sub_category (main_category_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin_roles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(32) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, code VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, roles VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE chart_value (id INT AUTO_INCREMENT NOT NULL, value JSON DEFAULT NULL, active TINYINT(1) NOT NULL, created_at DATE NOT NULL, updated_at DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE charts (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(32) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, value JSON DEFAULT NULL, active TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE content_type (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(16) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATE NOT NULL, updated_at VARCHAR(16) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE pdf (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(16) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATE NOT NULL, updated_at DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE category_click DROP FOREIGN KEY FK_52C58D69B5A459A0');
        $this->addSql('ALTER TABLE category_click DROP FOREIGN KEY FK_52C58D69C6C55574');
        $this->addSql('ALTER TABLE category_click DROP FOREIGN KEY FK_52C58D69F7BFE87C');
        $this->addSql('ALTER TABLE content_connection DROP FOREIGN KEY FK_B0CEC594B5A459A0');
        $this->addSql('ALTER TABLE content_connection DROP FOREIGN KEY FK_B0CEC59484A0A3ED');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD39950E104C1D3');
        $this->addSql('DROP TABLE category_click');
        $this->addSql('DROP TABLE content_connection');
        $this->addSql('DROP TABLE news');
        $this->addSql('ALTER TABLE banner DROP FOREIGN KEY FK_6F9DB8E7E104C1D3');
        $this->addSql('DROP INDEX IDX_6F9DB8E7E104C1D3 ON banner');
        $this->addSql('ALTER TABLE banner DROP created_user_id');
        $this->addSql('ALTER TABLE cms_user DROP roles');
        $this->addSql('ALTER TABLE content ADD mn_title VARCHAR(255) DEFAULT NULL, ADD cn_title VARCHAR(255) DEFAULT NULL, ADD mn_content LONGTEXT DEFAULT NULL, ADD en_content LONGTEXT DEFAULT NULL, ADD cn_content LONGTEXT DEFAULT NULL, ADD is_special TINYINT(1) DEFAULT NULL, ADD created_at DATE DEFAULT NULL, ADD updated_at DATE DEFAULT NULL, DROP type, DROP body, DROP priority, CHANGE name en_title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE currency DROP FOREIGN KEY FK_6956883FE104C1D3');
        $this->addSql('DROP INDEX IDX_6956883FE104C1D3 ON currency');
        $this->addSql('ALTER TABLE currency DROP created_user_id');
        $this->addSql('ALTER TABLE main_category DROP FOREIGN KEY FK_DF6E08B4E104C1D3');
        $this->addSql('DROP INDEX IDX_DF6E08B4E104C1D3 ON main_category');
        $this->addSql('ALTER TABLE main_category DROP created_user_id');
        $this->addSql('ALTER TABLE map DROP FOREIGN KEY FK_93ADAABBE104C1D3');
        $this->addSql('DROP INDEX IDX_93ADAABBE104C1D3 ON map');
        $this->addSql('ALTER TABLE map DROP created_user_id');
        $this->addSql('ALTER TABLE partner_organization DROP FOREIGN KEY FK_50C37C5DE104C1D3');
        $this->addSql('DROP INDEX IDX_50C37C5DE104C1D3 ON partner_organization');
        $this->addSql('ALTER TABLE partner_organization DROP created_user_id');
        $this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F798E104C1D3');
        $this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F798197B9A54');
        $this->addSql('DROP INDEX IDX_BCE3F798E104C1D3 ON sub_category');
        $this->addSql('DROP INDEX IDX_BCE3F798197B9A54 ON sub_category');
        $this->addSql('ALTER TABLE sub_category DROP created_user_id, DROP main_category_id_id');
    }
}
