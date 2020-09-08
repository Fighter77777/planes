<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20200905064041
 */
final class Version20200905064041 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Starting structure';
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE weathers (
                    id INT AUTO_INCREMENT NOT NULL, 
                    name VARCHAR(100) NOT NULL,
                    UNIQUE INDEX UNIQ_B14853875E237E06 (name),
                    PRIMARY KEY(id)
                 ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE surfaces (
                    id INT AUTO_INCREMENT NOT NULL,
                    name VARCHAR(100) NOT NULL,
                    UNIQUE INDEX UNIQ_B1B8C2CA5E237E06 (name),
                    PRIMARY KEY(id)
                 ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE plane_states (
                    id INT AUTO_INCREMENT NOT NULL,
                    name VARCHAR(30) NOT NULL,
                    UNIQUE INDEX UNIQ_624397735E237E06 (name),
                    PRIMARY KEY(id)
                 ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE plane_models (
                    id INT AUTO_INCREMENT NOT NULL,
                    name VARCHAR(100) NOT NULL,
                    UNIQUE INDEX UNIQ_B757D0375E237E06 (name),
                    PRIMARY KEY(id)
                 ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE plane_models_weathers (
                    plane_model_id INT NOT NULL, 
                    weather_id INT NOT NULL, 
                    INDEX IDX_3278391498BA1D63 (plane_model_id), 
                    INDEX IDX_327839148CE675E (weather_id), 
                    PRIMARY KEY(plane_model_id, weather_id)
                 ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE plane_models_surfaces (
                    plane_model_id INT NOT NULL, surface_id INT NOT NULL,
                    INDEX IDX_3288A85998BA1D63 (plane_model_id),
                    INDEX IDX_3288A859CA11F534 (surface_id),
                    PRIMARY KEY(plane_model_id, surface_id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql(
            'CREATE TABLE planes (
                    id INT AUTO_INCREMENT NOT NULL,
                    tail_number VARCHAR(100) DEFAULT NULL,
                    plane_model_id INT DEFAULT NULL,
                    state_id INT DEFAULT NULL,
                    hangar_id INT DEFAULT NULL,                   
                    UNIQUE INDEX UNIQ_F677FF069E125A71 (tail_number),
                    INDEX IDX_F677FF0698BA1D63 (plane_model_id),
                    INDEX IDX_F677FF065D83CC1 (state_id),
                    INDEX IDX_F677FF062FEFB5A5 (hangar_id), 
                    PRIMARY KEY(id)
                 ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
                'CREATE TABLE plane_model_working_hours (
                    id INT AUTO_INCREMENT NOT NULL,
                    plane_model_id INT DEFAULT NULL,
                    name VARCHAR(100) DEFAULT NULL,
                    start TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\',
                    end TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\',
                    INDEX IDX_2BA4B3B498BA1D63 (plane_model_id),
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE hangars (
                    id INT AUTO_INCREMENT NOT NULL,
                    name VARCHAR(50) NOT NULL,
                    UNIQUE INDEX UNIQ_FB7E9D705E237E06 (name),
                    PRIMARY KEY(id)
                 ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'ALTER TABLE planes 
                ADD CONSTRAINT FK_F677FF0698BA1D63 FOREIGN KEY (plane_model_id) REFERENCES plane_models (id)'
        );
        $this->addSql(
            'ALTER TABLE plane_models_weathers
                ADD CONSTRAINT FK_9765467C98BA1D63 FOREIGN KEY (plane_model_id) 
                    REFERENCES plane_models (id) ON DELETE CASCADE'
        );
        $this->addSql(
            'ALTER TABLE plane_models_weathers
                ADD CONSTRAINT FK_9765467C8CE675E FOREIGN KEY (weather_id) 
                    REFERENCES weathers (id) ON DELETE CASCADE'
        );
        $this->addSql(
            'ALTER TABLE plane_models_surfaces
                ADD CONSTRAINT FK_67F40B7C98BA1D63 FOREIGN KEY (plane_model_id) 
                    REFERENCES plane_models (id) ON DELETE CASCADE'
        );
        $this->addSql(
            'ALTER TABLE plane_models_surfaces
                ADD CONSTRAINT FK_67F40B7CCA11F534 FOREIGN KEY (surface_id)
                    REFERENCES surfaces (id) ON DELETE CASCADE'
        );
        $this->addSql(
            'ALTER TABLE planes 
                ADD CONSTRAINT FK_F677FF065D83CC1 FOREIGN KEY (state_id) REFERENCES plane_states (id)'
        );
        $this->addSql(
            'ALTER TABLE planes 
                ADD CONSTRAINT FK_F677FF062FEFB5A5 FOREIGN KEY (hangar_id) REFERENCES hangars (id)');
        $this->addSql(
            'ALTER TABLE plane_model_working_hours 
                ADD CONSTRAINT FK_2BA4B3B498BA1D63 FOREIGN KEY (plane_model_id) REFERENCES plane_models (id)'
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE plane_model_working_hours DROP FOREIGN KEY FK_2BA4B3B498BA1D63');
        $this->addSql('ALTER TABLE planes DROP FOREIGN KEY FK_F677FF062FEFB5A5');
        $this->addSql('ALTER TABLE planes DROP FOREIGN KEY FK_F677FF0698BA1D63');
        $this->addSql('ALTER TABLE planes DROP FOREIGN KEY FK_F677FF065D83CC1');
        $this->addSql('ALTER TABLE plane_models_surfaces DROP FOREIGN KEY FK_67F40B7C98BA1D63');
        $this->addSql('ALTER TABLE plane_models_surfaces DROP FOREIGN KEY FK_67F40B7CCA11F534');
        $this->addSql('ALTER TABLE plane_models_weathers DROP FOREIGN KEY FK_9765467C98BA1D63');
        $this->addSql('ALTER TABLE plane_models_weathers DROP FOREIGN KEY FK_9765467C8CE675E');
        $this->addSql('DROP TABLE hangars');
        $this->addSql('DROP TABLE plane_model_working_hours');
        $this->addSql('DROP TABLE plane_models_surfaces');
        $this->addSql('DROP TABLE plane_models_weathers');
        $this->addSql('DROP TABLE plane_models');
        $this->addSql('DROP TABLE plane_states');
        $this->addSql('DROP TABLE planes');
        $this->addSql('DROP TABLE surfaces');
        $this->addSql('DROP TABLE weathers');
    }
}
