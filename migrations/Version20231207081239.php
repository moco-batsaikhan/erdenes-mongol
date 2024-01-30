<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231207081239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_click DROP FOREIGN KEY FK_52C58D69B5A459A0');
        $this->addSql('ALTER TABLE category_click DROP FOREIGN KEY FK_52C58D69C6C55574');
        $this->addSql('ALTER TABLE category_click DROP FOREIGN KEY FK_52C58D69F7BFE87C');
        $this->addSql('DROP TABLE category_click');
        $this->addSql('ALTER TABLE news ADD main_category_id_id INT DEFAULT NULL, ADD sub_category_id INT DEFAULT NULL, ADD redirect_type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD39950197B9A54 FOREIGN KEY (main_category_id_id) REFERENCES main_category (id)');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD39950F7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id)');
        $this->addSql('CREATE INDEX IDX_1DD39950197B9A54 ON news (main_category_id_id)');
        $this->addSql('CREATE INDEX IDX_1DD39950F7BFE87C ON news (sub_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_click (id INT AUTO_INCREMENT NOT NULL, news_id INT NOT NULL, main_category_id INT NOT NULL, sub_category_id INT NOT NULL, INDEX IDX_52C58D69F7BFE87C (sub_category_id), INDEX IDX_52C58D69C6C55574 (main_category_id), INDEX IDX_52C58D69B5A459A0 (news_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE category_click ADD CONSTRAINT FK_52C58D69B5A459A0 FOREIGN KEY (news_id) REFERENCES news (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE category_click ADD CONSTRAINT FK_52C58D69C6C55574 FOREIGN KEY (main_category_id) REFERENCES main_category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE category_click ADD CONSTRAINT FK_52C58D69F7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD39950197B9A54');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD39950F7BFE87C');
        $this->addSql('DROP INDEX IDX_1DD39950197B9A54 ON news');
        $this->addSql('DROP INDEX IDX_1DD39950F7BFE87C ON news');
        $this->addSql('ALTER TABLE news DROP main_category_id_id, DROP sub_category_id, DROP redirect_type');
    }
}
