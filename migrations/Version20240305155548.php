<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305155548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recipe_allergens (recipe_id INT NOT NULL, allergens_id INT NOT NULL, INDEX IDX_7036B15259D8A214 (recipe_id), INDEX IDX_7036B152711662F1 (allergens_id), PRIMARY KEY(recipe_id, allergens_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_diet (recipe_id INT NOT NULL, diet_id INT NOT NULL, INDEX IDX_E2FF3FFF59D8A214 (recipe_id), INDEX IDX_E2FF3FFFE1E13ACE (diet_id), PRIMARY KEY(recipe_id, diet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE view (id INT AUTO_INCREMENT NOT NULL, recipe_id INT DEFAULT NULL, score INT NOT NULL, comment VARCHAR(255) NOT NULL, INDEX IDX_FEFDAB8E59D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipe_allergens ADD CONSTRAINT FK_7036B15259D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_allergens ADD CONSTRAINT FK_7036B152711662F1 FOREIGN KEY (allergens_id) REFERENCES allergens (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_diet ADD CONSTRAINT FK_E2FF3FFF59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_diet ADD CONSTRAINT FK_E2FF3FFFE1E13ACE FOREIGN KEY (diet_id) REFERENCES diet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE view ADD CONSTRAINT FK_FEFDAB8E59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE recipe DROP note');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe_allergens DROP FOREIGN KEY FK_7036B15259D8A214');
        $this->addSql('ALTER TABLE recipe_allergens DROP FOREIGN KEY FK_7036B152711662F1');
        $this->addSql('ALTER TABLE recipe_diet DROP FOREIGN KEY FK_E2FF3FFF59D8A214');
        $this->addSql('ALTER TABLE recipe_diet DROP FOREIGN KEY FK_E2FF3FFFE1E13ACE');
        $this->addSql('ALTER TABLE view DROP FOREIGN KEY FK_FEFDAB8E59D8A214');
        $this->addSql('DROP TABLE recipe_allergens');
        $this->addSql('DROP TABLE recipe_diet');
        $this->addSql('DROP TABLE view');
        $this->addSql('ALTER TABLE recipe ADD note INT DEFAULT NULL');
    }
}
