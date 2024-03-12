<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240312092922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE map ADD map_type_id INT DEFAULT NULL, DROP data_type');
        $this->addSql('ALTER TABLE map ADD CONSTRAINT FK_93ADAABBEA6774CF FOREIGN KEY (map_type_id) REFERENCES map_type (id)');
        $this->addSql('CREATE INDEX IDX_93ADAABBEA6774CF ON map (map_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE map DROP FOREIGN KEY FK_93ADAABBEA6774CF');
        $this->addSql('DROP INDEX IDX_93ADAABBEA6774CF ON map');
        $this->addSql('ALTER TABLE map ADD data_type VARCHAR(16) NOT NULL, DROP map_type_id');
    }
}
