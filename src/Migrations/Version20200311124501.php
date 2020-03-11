<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200311124501 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE translate DROP FOREIGN KEY FK_4A1063771C9A06');
        $this->addSql('DROP INDEX IDX_4A1063771C9A06 ON translate');
        $this->addSql('ALTER TABLE translate CHANGE language_id_id language_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE translate ADD CONSTRAINT FK_4A10637782F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('CREATE INDEX IDX_4A10637782F1BAF4 ON translate (language_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE translate DROP FOREIGN KEY FK_4A10637782F1BAF4');
        $this->addSql('DROP INDEX IDX_4A10637782F1BAF4 ON translate');
        $this->addSql('ALTER TABLE translate CHANGE language_id language_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE translate ADD CONSTRAINT FK_4A1063771C9A06 FOREIGN KEY (language_id_id) REFERENCES language (id)');
        $this->addSql('CREATE INDEX IDX_4A1063771C9A06 ON translate (language_id_id)');
    }
}
