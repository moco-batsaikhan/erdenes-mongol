<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220061141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sub_category ADD news_id_id INT DEFAULT NULL, ADD redirect_link VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F7985FB1909 FOREIGN KEY (news_id_id) REFERENCES news (id)');
        $this->addSql('CREATE INDEX IDX_BCE3F7985FB1909 ON sub_category (news_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F7985FB1909');
        $this->addSql('DROP INDEX IDX_BCE3F7985FB1909 ON sub_category');
        $this->addSql('ALTER TABLE sub_category DROP news_id_id, DROP redirect_link');
    }
}
