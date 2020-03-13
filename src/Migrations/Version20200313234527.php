<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200313234527 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE history (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, source_id INT NOT NULL, target_id INT NOT NULL, searched_at DATETIME NOT NULL, is_memorised TINYINT(1) DEFAULT NULL, INDEX IDX_27BA704BA76ED395 (user_id), UNIQUE INDEX UNIQ_27BA704B953C1C61 (source_id), UNIQUE INDEX UNIQ_27BA704B158E0B66 (target_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704B953C1C61 FOREIGN KEY (source_id) REFERENCES translate (id)');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704B158E0B66 FOREIGN KEY (target_id) REFERENCES translate (id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE translate CHANGE is_suggestion is_suggestion TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE suggestion CHANGE accepted_at accepted_at DATETIME DEFAULT NULL, CHANGE status status VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE history');
        $this->addSql('ALTER TABLE suggestion CHANGE accepted_at accepted_at DATETIME DEFAULT \'NULL\', CHANGE status status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE translate CHANGE is_suggestion is_suggestion TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
