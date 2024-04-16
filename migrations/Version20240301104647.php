<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240301104647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form_patients DROP FOREIGN KEY FK_9DF6AB6879F37AE5');
        $this->addSql('DROP TABLE form_patients');
        $this->addSql('ALTER TABLE user DROP allergen_list, DROP diet_list');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE form_patients (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, UNIQUE INDEX UNIQ_9DF6AB6879F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE form_patients ADD CONSTRAINT FK_9DF6AB6879F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD allergen_list LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD diet_list LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
    }
}
