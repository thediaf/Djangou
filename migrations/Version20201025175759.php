<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201025175759 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE suggestion (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, translate_id INT NOT NULL, suggested_at DATETIME NOT NULL, accepted_at DATETIME DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, INDEX IDX_DD80F31BA76ED395 (user_id), INDEX IDX_DD80F31B649893AF (translate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE translate (id INT AUTO_INCREMENT NOT NULL, language_id INT NOT NULL, word VARCHAR(255) NOT NULL, classe VARCHAR(255) NOT NULL, is_suggestion TINYINT(1) DEFAULT NULL, INDEX IDX_4A10637782F1BAF4 (language_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE translate_translate (translate_source INT NOT NULL, translate_target INT NOT NULL, INDEX IDX_EA37FAF6955F247A (translate_source), INDEX IDX_EA37FAF68CBA74F5 (translate_target), PRIMARY KEY(translate_source, translate_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE history (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, source_id INT NOT NULL, target_id INT NOT NULL, searched_at DATETIME NOT NULL, is_memorised TINYINT(1) DEFAULT NULL, token VARCHAR(255) NOT NULL, INDEX IDX_27BA704BA76ED395 (user_id), INDEX IDX_27BA704B953C1C61 (source_id), INDEX IDX_27BA704B158E0B66 (target_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE suggestion ADD CONSTRAINT FK_DD80F31BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE suggestion ADD CONSTRAINT FK_DD80F31B649893AF FOREIGN KEY (translate_id) REFERENCES translate (id)');
        $this->addSql('ALTER TABLE translate ADD CONSTRAINT FK_4A10637782F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE translate_translate ADD CONSTRAINT FK_EA37FAF6955F247A FOREIGN KEY (translate_source) REFERENCES translate (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE translate_translate ADD CONSTRAINT FK_EA37FAF68CBA74F5 FOREIGN KEY (translate_target) REFERENCES translate (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704B953C1C61 FOREIGN KEY (source_id) REFERENCES translate (id)');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704B158E0B66 FOREIGN KEY (target_id) REFERENCES translate (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE suggestion DROP FOREIGN KEY FK_DD80F31B649893AF');
        $this->addSql('ALTER TABLE translate_translate DROP FOREIGN KEY FK_EA37FAF6955F247A');
        $this->addSql('ALTER TABLE translate_translate DROP FOREIGN KEY FK_EA37FAF68CBA74F5');
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704B953C1C61');
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704B158E0B66');
        $this->addSql('ALTER TABLE suggestion DROP FOREIGN KEY FK_DD80F31BA76ED395');
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704BA76ED395');
        $this->addSql('ALTER TABLE translate DROP FOREIGN KEY FK_4A10637782F1BAF4');
        $this->addSql('DROP TABLE suggestion');
        $this->addSql('DROP TABLE translate');
        $this->addSql('DROP TABLE translate_translate');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE history');
    }
}
