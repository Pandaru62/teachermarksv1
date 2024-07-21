<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240710131848 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE form (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schoolclass (id INT AUTO_INCREMENT NOT NULL, form_id INT NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, is_archived TINYINT(1) NOT NULL, INDEX IDX_F146B6695FF69B7D (form_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE students (id INT AUTO_INCREMENT NOT NULL, class_id INT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, INDEX IDX_A4698DB2EA000B10 (class_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, schoolclass_id INT NOT NULL, date DATE NOT NULL, trimester INT NOT NULL, description VARCHAR(255) NOT NULL, scale INT NOT NULL, coefficient INT NOT NULL, INDEX IDX_D87F7E0CC67D8F5 (schoolclass_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE schoolclass ADD CONSTRAINT FK_F146B6695FF69B7D FOREIGN KEY (form_id) REFERENCES form (id)');
        $this->addSql('ALTER TABLE students ADD CONSTRAINT FK_A4698DB2EA000B10 FOREIGN KEY (class_id) REFERENCES schoolclass (id)');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0CC67D8F5 FOREIGN KEY (schoolclass_id) REFERENCES schoolclass (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE schoolclass CHANGE form_id form_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE students DROP FOREIGN KEY FK_A4698DB2EA000B10');
        $this->addSql('DROP INDEX IDX_A4698DB2EA000B10 ON students');
        $this->addSql('ALTER TABLE test CHANGE schoolclass_id schoolclass_id INT DEFAULT NULL');
    }
}
