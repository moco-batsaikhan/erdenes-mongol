<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231228091124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE main_category DROP FOREIGN KEY FK_DF6E08B492A89075');
        $this->addSql('DROP INDEX IDX_DF6E08B492A89075 ON main_category');
        $this->addSql('ALTER TABLE main_category DROP news_type_id');
        $this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F79892A89075');
        $this->addSql('DROP INDEX IDX_BCE3F79892A89075 ON sub_category');
        $this->addSql('ALTER TABLE sub_category DROP news_type_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE main_category ADD news_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE main_category ADD CONSTRAINT FK_DF6E08B492A89075 FOREIGN KEY (news_type_id) REFERENCES news_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_DF6E08B492A89075 ON main_category (news_type_id)');
        $this->addSql('ALTER TABLE sub_category ADD news_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F79892A89075 FOREIGN KEY (news_type_id) REFERENCES news_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_BCE3F79892A89075 ON sub_category (news_type_id)');
    }
}
