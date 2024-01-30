<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231221073355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD3995092A89075 FOREIGN KEY (news_type_id) REFERENCES news_type (id)');
        $this->addSql('CREATE INDEX IDX_1DD3995092A89075 ON news (news_type_id)');
        $this->addSql('ALTER TABLE sub_category ADD news_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F79892A89075 FOREIGN KEY (news_type_id) REFERENCES news_type (id)');
        $this->addSql('CREATE INDEX IDX_BCE3F79892A89075 ON sub_category (news_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD3995092A89075');
        $this->addSql('DROP INDEX IDX_1DD3995092A89075 ON news');
        $this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F79892A89075');
        $this->addSql('DROP INDEX IDX_BCE3F79892A89075 ON sub_category');
        $this->addSql('ALTER TABLE sub_category DROP news_type_id');
    }
}
