<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200309203817 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE translate (id INT AUTO_INCREMENT NOT NULL, language_id_id INT DEFAULT NULL, word VARCHAR(255) NOT NULL, classe VARCHAR(255) NOT NULL, INDEX IDX_4A1063771C9A06 (language_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE translate_translate (translate_source INT NOT NULL, translate_target INT NOT NULL, INDEX IDX_EA37FAF6955F247A (translate_source), INDEX IDX_EA37FAF68CBA74F5 (translate_target), PRIMARY KEY(translate_source, translate_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE translate ADD CONSTRAINT FK_4A1063771C9A06 FOREIGN KEY (language_id_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE translate_translate ADD CONSTRAINT FK_EA37FAF6955F247A FOREIGN KEY (translate_source) REFERENCES translate (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE translate_translate ADD CONSTRAINT FK_EA37FAF68CBA74F5 FOREIGN KEY (translate_target) REFERENCES translate (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE translate_translate DROP FOREIGN KEY FK_EA37FAF6955F247A');
        $this->addSql('ALTER TABLE translate_translate DROP FOREIGN KEY FK_EA37FAF68CBA74F5');
        $this->addSql('DROP TABLE translate');
        $this->addSql('DROP TABLE translate_translate');
    }
}
