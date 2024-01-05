<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240105023930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE main_category DROP FOREIGN KEY FK_DF6E08B49D37CED9');
        $this->addSql('DROP INDEX IDX_DF6E08B49D37CED9 ON main_category');
        $this->addSql('ALTER TABLE main_category CHANGE news_type_id_id news_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE main_category ADD CONSTRAINT FK_DF6E08B492A89075 FOREIGN KEY (news_type_id) REFERENCES news_type (id)');
        $this->addSql('CREATE INDEX IDX_DF6E08B492A89075 ON main_category (news_type_id)');
        $this->addSql('ALTER TABLE news CHANGE mn_headline mn_headline LONGTEXT DEFAULT NULL, CHANGE en_headline en_headline LONGTEXT DEFAULT NULL, CHANGE cn_headline cn_headline LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE main_category DROP FOREIGN KEY FK_DF6E08B492A89075');
        $this->addSql('DROP INDEX IDX_DF6E08B492A89075 ON main_category');
        $this->addSql('ALTER TABLE main_category CHANGE news_type_id news_type_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE main_category ADD CONSTRAINT FK_DF6E08B49D37CED9 FOREIGN KEY (news_type_id_id) REFERENCES news_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_DF6E08B49D37CED9 ON main_category (news_type_id_id)');
        $this->addSql('ALTER TABLE news CHANGE mn_headline mn_headline VARCHAR(255) DEFAULT NULL, CHANGE en_headline en_headline VARCHAR(255) DEFAULT NULL, CHANGE cn_headline cn_headline VARCHAR(255) DEFAULT NULL');
    }
}
