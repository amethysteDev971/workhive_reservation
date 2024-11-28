<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241127190208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE date_schedules (id INT AUTO_INCREMENT NOT NULL, room_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, date DATE NOT NULL, started_at TIME NOT NULL, ended_at TIME NOT NULL, is_open TINYINT(1) NOT NULL, INDEX IDX_E4DEF3A54177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment_role_rate (id INT AUTO_INCREMENT NOT NULL, equipment_id INT NOT NULL, user_role VARCHAR(255) NOT NULL, hourly_rate NUMERIC(10, 2) NOT NULL, INDEX IDX_B36E0BD4517FE9FE (equipment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipments (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, total_stock INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_methods (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, label VARCHAR(100) NOT NULL, type VARCHAR(50) NOT NULL, data JSON NOT NULL COMMENT \'(DC2Type:json)\', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_4FABF983A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_equipment (id INT AUTO_INCREMENT NOT NULL, reservation_id INT NOT NULL, equipment_id INT NOT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_C97FB41CB83297E7 (reservation_id), INDEX IDX_C97FB41C517FE9FE (equipment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, room_id INT NOT NULL, user_id INT NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_4DA23954177093 (room_id), INDEX IDX_4DA239A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room_equipment (id INT AUTO_INCREMENT NOT NULL, room_id INT NOT NULL, equipment_id INT NOT NULL, quantity INT NOT NULL, assigned_at DATETIME NOT NULL, INDEX IDX_4F9135EA54177093 (room_id), INDEX IDX_4F9135EA517FE9FE (equipment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room_role_rate (id INT AUTO_INCREMENT NOT NULL, room_id INT NOT NULL, user_role VARCHAR(255) NOT NULL, hourly_rate NUMERIC(10, 2) NOT NULL, INDEX IDX_FDFAADC454177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rooms (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, capacity INT NOT NULL, width DOUBLE PRECISION NOT NULL, length DOUBLE PRECISION NOT NULL, status VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, photo VARCHAR(255) DEFAULT NULL, user_role VARCHAR(255) NOT NULL, phone VARCHAR(15) DEFAULT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE week_schedules (id INT AUTO_INCREMENT NOT NULL, room_id INT NOT NULL, started_at TIME NOT NULL, ended_at TIME NOT NULL, week_day SMALLINT NOT NULL, INDEX IDX_11EC168E54177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE date_schedules ADD CONSTRAINT FK_E4DEF3A54177093 FOREIGN KEY (room_id) REFERENCES rooms (id)');
        $this->addSql('ALTER TABLE equipment_role_rate ADD CONSTRAINT FK_B36E0BD4517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipments (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE payment_methods ADD CONSTRAINT FK_4FABF983A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE reservation_equipment ADD CONSTRAINT FK_C97FB41CB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_equipment ADD CONSTRAINT FK_C97FB41C517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipments (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA23954177093 FOREIGN KEY (room_id) REFERENCES rooms (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE room_equipment ADD CONSTRAINT FK_4F9135EA54177093 FOREIGN KEY (room_id) REFERENCES rooms (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room_equipment ADD CONSTRAINT FK_4F9135EA517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipments (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room_role_rate ADD CONSTRAINT FK_FDFAADC454177093 FOREIGN KEY (room_id) REFERENCES rooms (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE week_schedules ADD CONSTRAINT FK_11EC168E54177093 FOREIGN KEY (room_id) REFERENCES rooms (id)');
        $this->addSql('ALTER TABLE hours DROP FOREIGN KEY FK_8A1ABD8DA4AEAFEA');
        $this->addSql('ALTER TABLE special_days DROP FOREIGN KEY FK_69B3FD4D1A867E8F');
        $this->addSql('ALTER TABLE days DROP FOREIGN KEY FK_EBE4FC66737E8873');
        $this->addSql('DROP TABLE hours');
        $this->addSql('DROP TABLE special_days');
        $this->addSql('DROP TABLE days');
        $this->addSql('DROP TABLE entreprise');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hours (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT NOT NULL, start_at TIME NOT NULL, end_at TIME NOT NULL, INDEX IDX_8A1ABD8DA4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE special_days (id INT AUTO_INCREMENT NOT NULL, id_entreprise_id INT DEFAULT NULL, name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date DATE NOT NULL, start_at TIME NOT NULL, end_at TIME NOT NULL, is_open TINYINT(1) NOT NULL, INDEX IDX_69B3FD4D1A867E8F (id_entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE days (id INT AUTO_INCREMENT NOT NULL, id_hours_id INT DEFAULT NULL, name VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_EBE4FC66737E8873 (id_hours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE hours ADD CONSTRAINT FK_8A1ABD8DA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE special_days ADD CONSTRAINT FK_69B3FD4D1A867E8F FOREIGN KEY (id_entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE days ADD CONSTRAINT FK_EBE4FC66737E8873 FOREIGN KEY (id_hours_id) REFERENCES hours (id)');
        $this->addSql('ALTER TABLE date_schedules DROP FOREIGN KEY FK_E4DEF3A54177093');
        $this->addSql('ALTER TABLE equipment_role_rate DROP FOREIGN KEY FK_B36E0BD4517FE9FE');
        $this->addSql('ALTER TABLE payment_methods DROP FOREIGN KEY FK_4FABF983A76ED395');
        $this->addSql('ALTER TABLE reservation_equipment DROP FOREIGN KEY FK_C97FB41CB83297E7');
        $this->addSql('ALTER TABLE reservation_equipment DROP FOREIGN KEY FK_C97FB41C517FE9FE');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA23954177093');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239A76ED395');
        $this->addSql('ALTER TABLE room_equipment DROP FOREIGN KEY FK_4F9135EA54177093');
        $this->addSql('ALTER TABLE room_equipment DROP FOREIGN KEY FK_4F9135EA517FE9FE');
        $this->addSql('ALTER TABLE room_role_rate DROP FOREIGN KEY FK_FDFAADC454177093');
        $this->addSql('ALTER TABLE week_schedules DROP FOREIGN KEY FK_11EC168E54177093');
        $this->addSql('DROP TABLE date_schedules');
        $this->addSql('DROP TABLE equipment_role_rate');
        $this->addSql('DROP TABLE equipments');
        $this->addSql('DROP TABLE payment_methods');
        $this->addSql('DROP TABLE reservation_equipment');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE room_equipment');
        $this->addSql('DROP TABLE room_role_rate');
        $this->addSql('DROP TABLE rooms');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE week_schedules');
    }
}
