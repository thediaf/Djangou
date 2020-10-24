<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201024192054 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        )');
        $this->addSql('CREATE TABLE translate (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, language_id INTEGER NOT NULL, word VARCHAR(255) NOT NULL, classe VARCHAR(255) NOT NULL, is_suggestion BOOLEAN DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_4A10637782F1BAF4 ON translate (language_id)');
        $this->addSql('CREATE TABLE translate_translate (translate_source INTEGER NOT NULL, translate_target INTEGER NOT NULL, PRIMARY KEY(translate_source, translate_target))');
        $this->addSql('CREATE INDEX IDX_EA37FAF6955F247A ON translate_translate (translate_source)');
        $this->addSql('CREATE INDEX IDX_EA37FAF68CBA74F5 ON translate_translate (translate_target)');
        $this->addSql('CREATE TABLE suggestion (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, translate_id INTEGER NOT NULL, suggested_at DATETIME NOT NULL, accepted_at DATETIME DEFAULT NULL, status VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_DD80F31BA76ED395 ON suggestion (user_id)');
        $this->addSql('CREATE INDEX IDX_DD80F31B649893AF ON suggestion (translate_id)');
        $this->addSql('CREATE TABLE history (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, source_id INTEGER NOT NULL, target_id INTEGER NOT NULL, searched_at DATETIME NOT NULL, is_memorised BOOLEAN DEFAULT NULL, token VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_27BA704BA76ED395 ON history (user_id)');
        $this->addSql('CREATE INDEX IDX_27BA704B953C1C61 ON history (source_id)');
        $this->addSql('CREATE INDEX IDX_27BA704B158E0B66 ON history (target_id)');
        $this->addSql('CREATE TABLE language (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE translate');
        $this->addSql('DROP TABLE translate_translate');
        $this->addSql('DROP TABLE suggestion');
        $this->addSql('DROP TABLE history');
        $this->addSql('DROP TABLE language');
    }
}
