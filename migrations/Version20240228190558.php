<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240228190558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE allergens DROP FOREIGN KEY FK_67F79FB439A86D3E');
        $this->addSql('ALTER TABLE allergens DROP FOREIGN KEY FK_67F79FB459D8A214');
        $this->addSql('DROP INDEX IDX_67F79FB439A86D3E ON allergens');
        $this->addSql('DROP INDEX IDX_67F79FB459D8A214 ON allergens');
        $this->addSql('ALTER TABLE allergens DROP form_patients_id, DROP recipe_id');
        $this->addSql('ALTER TABLE diet DROP FOREIGN KEY FK_9DE4652059D8A214');
        $this->addSql('ALTER TABLE diet DROP FOREIGN KEY FK_9DE4652039A86D3E');
        $this->addSql('DROP INDEX IDX_9DE4652039A86D3E ON diet');
        $this->addSql('DROP INDEX IDX_9DE4652059D8A214 ON diet');
        $this->addSql('ALTER TABLE diet DROP form_patients_id, DROP recipe_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE allergens ADD form_patients_id INT DEFAULT NULL, ADD recipe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE allergens ADD CONSTRAINT FK_67F79FB439A86D3E FOREIGN KEY (form_patients_id) REFERENCES form_patients (id)');
        $this->addSql('ALTER TABLE allergens ADD CONSTRAINT FK_67F79FB459D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('CREATE INDEX IDX_67F79FB439A86D3E ON allergens (form_patients_id)');
        $this->addSql('CREATE INDEX IDX_67F79FB459D8A214 ON allergens (recipe_id)');
        $this->addSql('ALTER TABLE diet ADD form_patients_id INT DEFAULT NULL, ADD recipe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE diet ADD CONSTRAINT FK_9DE4652059D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE diet ADD CONSTRAINT FK_9DE4652039A86D3E FOREIGN KEY (form_patients_id) REFERENCES form_patients (id)');
        $this->addSql('CREATE INDEX IDX_9DE4652039A86D3E ON diet (form_patients_id)');
        $this->addSql('CREATE INDEX IDX_9DE4652059D8A214 ON diet (recipe_id)');
    }
}
