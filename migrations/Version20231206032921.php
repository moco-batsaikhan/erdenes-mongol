<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231206032921 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE content_connection DROP FOREIGN KEY FK_B0CEC59484A0A3ED');
        $this->addSql('ALTER TABLE content_connection DROP FOREIGN KEY FK_B0CEC594B5A459A0');
        $this->addSql('DROP TABLE content_connection');
        $this->addSql('ALTER TABLE content ADD news_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A9B5A459A0 FOREIGN KEY (news_id) REFERENCES news (id)');
        $this->addSql('CREATE INDEX IDX_FEC530A9B5A459A0 ON content (news_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE content_connection (id INT AUTO_INCREMENT NOT NULL, news_id INT NOT NULL, content_id INT NOT NULL, INDEX IDX_B0CEC59484A0A3ED (content_id), INDEX IDX_B0CEC594B5A459A0 (news_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE content_connection ADD CONSTRAINT FK_B0CEC59484A0A3ED FOREIGN KEY (content_id) REFERENCES content (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE content_connection ADD CONSTRAINT FK_B0CEC594B5A459A0 FOREIGN KEY (news_id) REFERENCES news (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE content DROP FOREIGN KEY FK_FEC530A9B5A459A0');
        $this->addSql('DROP INDEX IDX_FEC530A9B5A459A0 ON content');
        $this->addSql('ALTER TABLE content DROP news_id');
    }
}
