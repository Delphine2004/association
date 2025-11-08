<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251108201720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, type VARCHAR(20) NOT NULL, race VARCHAR(20) NOT NULL, gender VARCHAR(20) NOT NULL, adoption_status VARCHAR(20) NOT NULL, vaccinated TINYINT(1) NOT NULL, sterilized TINYINT(1) NOT NULL, chipped TINYINT(1) NOT NULL, compatible_kid TINYINT(1) NOT NULL, compatible_cat TINYINT(1) NOT NULL, compatible_dog TINYINT(1) NOT NULL, birthday DATE DEFAULT NULL, arrival_date DATE NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6AAB231FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal_specification (animal_id INT NOT NULL, specification_id INT NOT NULL, INDEX IDX_24E22BBF8E962C16 (animal_id), INDEX IDX_24E22BBF908E2FFE (specification_id), PRIMARY KEY(animal_id, specification_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidature (id INT AUTO_INCREMENT NOT NULL, animal_id INT DEFAULT NULL, user_id INT DEFAULT NULL, candidature_status VARCHAR(20) NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_E33BD3B88E962C16 (animal_id), INDEX IDX_E33BD3B8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, animal_id INT DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, main TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_16DB4F898E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specification (id INT AUTO_INCREMENT NOT NULL, specification_name VARCHAR(50) NOT NULL, specification_category VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE animal_specification ADD CONSTRAINT FK_24E22BBF8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE animal_specification ADD CONSTRAINT FK_24E22BBF908E2FFE FOREIGN KEY (specification_id) REFERENCES specification (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B88E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F898E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FA76ED395');
        $this->addSql('ALTER TABLE animal_specification DROP FOREIGN KEY FK_24E22BBF8E962C16');
        $this->addSql('ALTER TABLE animal_specification DROP FOREIGN KEY FK_24E22BBF908E2FFE');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B88E962C16');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B8A76ED395');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F898E962C16');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE animal_specification');
        $this->addSql('DROP TABLE candidature');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE specification');
        $this->addSql('DROP TABLE user');
    }
}
