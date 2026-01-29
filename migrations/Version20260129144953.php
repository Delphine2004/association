<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260129144953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, type VARCHAR(50) NOT NULL, race VARCHAR(50) NOT NULL, gender VARCHAR(50) NOT NULL, picture VARCHAR(255) NOT NULL, status VARCHAR(50) NOT NULL, vaccinated TINYINT(1) DEFAULT 0 NOT NULL, sterilized TINYINT(1) DEFAULT 0 NOT NULL, chipped TINYINT(1) DEFAULT 0 NOT NULL, compatible_kid TINYINT(1) DEFAULT 0 NOT NULL, compatible_cat TINYINT(1) DEFAULT 0 NOT NULL, compatible_dog TINYINT(1) DEFAULT 0 NOT NULL, birthday DATE DEFAULT NULL, arrival_date DATE NOT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6AAB231FB03A8386 (created_by_id), INDEX IDX_6AAB231F896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, date DATE NOT NULL, place VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, picture VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_3BAE0AA7B03A8386 (created_by_id), INDEX IDX_3BAE0AA7896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FB03A8386');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F896DBBDE');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7B03A8386');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7896DBBDE');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE user');
    }
}
