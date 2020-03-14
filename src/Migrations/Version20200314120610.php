<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200314120610 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE suggestion_translate');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE translate CHANGE is_suggestion is_suggestion TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE suggestion ADD translate_id INT NOT NULL, CHANGE accepted_at accepted_at DATETIME DEFAULT NULL, CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE suggestion ADD CONSTRAINT FK_DD80F31B649893AF FOREIGN KEY (translate_id) REFERENCES translate (id)');
        $this->addSql('CREATE INDEX IDX_DD80F31B649893AF ON suggestion (translate_id)');
        $this->addSql('ALTER TABLE history CHANGE is_memorised is_memorised TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE suggestion_translate (suggestion_id INT NOT NULL, translate_id INT NOT NULL, INDEX IDX_EE96A075649893AF (translate_id), INDEX IDX_EE96A075A41BB822 (suggestion_id), PRIMARY KEY(suggestion_id, translate_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE suggestion_translate ADD CONSTRAINT FK_EE96A075649893AF FOREIGN KEY (translate_id) REFERENCES translate (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE suggestion_translate ADD CONSTRAINT FK_EE96A075A41BB822 FOREIGN KEY (suggestion_id) REFERENCES suggestion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE history CHANGE is_memorised is_memorised TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE suggestion DROP FOREIGN KEY FK_DD80F31B649893AF');
        $this->addSql('DROP INDEX IDX_DD80F31B649893AF ON suggestion');
        $this->addSql('ALTER TABLE suggestion DROP translate_id, CHANGE accepted_at accepted_at DATETIME DEFAULT \'NULL\', CHANGE status status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE translate CHANGE is_suggestion is_suggestion TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
