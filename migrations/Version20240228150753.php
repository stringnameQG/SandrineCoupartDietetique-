<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240228150753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE form_patients (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, UNIQUE INDEX UNIQ_9DF6AB6879F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, picture_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, preparation_time TIME NOT NULL, break_time TIME DEFAULT NULL, cooking_time TIME DEFAULT NULL, ingredients VARCHAR(255) NOT NULL, public TINYINT(1) NOT NULL, note INT DEFAULT NULL, UNIQUE INDEX UNIQ_DA88B137EE45BDBF (picture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_picture (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE steps (id INT AUTO_INCREMENT NOT NULL, recipe_id INT NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_34220A7259D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE form_patients ADD CONSTRAINT FK_9DF6AB6879F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137EE45BDBF FOREIGN KEY (picture_id) REFERENCES recipe_picture (id)');
        $this->addSql('ALTER TABLE steps ADD CONSTRAINT FK_34220A7259D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE allergens ADD form_patients_id INT DEFAULT NULL, ADD recipe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE allergens ADD CONSTRAINT FK_67F79FB439A86D3E FOREIGN KEY (form_patients_id) REFERENCES form_patients (id)');
        $this->addSql('ALTER TABLE allergens ADD CONSTRAINT FK_67F79FB459D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('CREATE INDEX IDX_67F79FB439A86D3E ON allergens (form_patients_id)');
        $this->addSql('CREATE INDEX IDX_67F79FB459D8A214 ON allergens (recipe_id)');
        $this->addSql('ALTER TABLE diet ADD form_patients_id INT DEFAULT NULL, ADD recipe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE diet ADD CONSTRAINT FK_9DE4652039A86D3E FOREIGN KEY (form_patients_id) REFERENCES form_patients (id)');
        $this->addSql('ALTER TABLE diet ADD CONSTRAINT FK_9DE4652059D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('CREATE INDEX IDX_9DE4652039A86D3E ON diet (form_patients_id)');
        $this->addSql('CREATE INDEX IDX_9DE4652059D8A214 ON diet (recipe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE allergens DROP FOREIGN KEY FK_67F79FB439A86D3E');
        $this->addSql('ALTER TABLE diet DROP FOREIGN KEY FK_9DE4652039A86D3E');
        $this->addSql('ALTER TABLE allergens DROP FOREIGN KEY FK_67F79FB459D8A214');
        $this->addSql('ALTER TABLE diet DROP FOREIGN KEY FK_9DE4652059D8A214');
        $this->addSql('ALTER TABLE form_patients DROP FOREIGN KEY FK_9DF6AB6879F37AE5');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B137EE45BDBF');
        $this->addSql('ALTER TABLE steps DROP FOREIGN KEY FK_34220A7259D8A214');
        $this->addSql('DROP TABLE form_patients');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE recipe_picture');
        $this->addSql('DROP TABLE steps');
        $this->addSql('DROP INDEX IDX_67F79FB439A86D3E ON allergens');
        $this->addSql('DROP INDEX IDX_67F79FB459D8A214 ON allergens');
        $this->addSql('ALTER TABLE allergens DROP form_patients_id, DROP recipe_id');
        $this->addSql('DROP INDEX IDX_9DE4652039A86D3E ON diet');
        $this->addSql('DROP INDEX IDX_9DE4652059D8A214 ON diet');
        $this->addSql('ALTER TABLE diet DROP form_patients_id, DROP recipe_id');
    }
}
