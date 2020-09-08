<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20200908050105
 */
final class Version20200908050105 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription() : string
    {
        return 'Data for this task';
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema) : void
    {
        $this->addSql("INSERT INTO `surfaces`(`id`,`name`) VALUES ('1', 'runway'),('2', 'water')");
        $this->addSql("INSERT INTO `weathers`(`id`,`name`) VALUES ('1', 'good'),('2', 'zero visibility'),('3', 'rain')");
        $this->addSql("INSERT INTO `hangars`(`id`,`name`) VALUES ('1', 'Aeroprakt')");
        $this->addSql(
            "INSERT INTO `plane_models`(`id`,`name`) 
                VALUES ('1', 'Aeroprakt A-24'), ('2','Boeing 747'), ('3','Curtiss NC-4')"
        );
        $this->addSql(
            "INSERT INTO `plane_models_surfaces`(`plane_model_id`,`surface_id`) 
                VALUES ('1', '1'), ('1', '2'), ('2', '1'), ('3', '2')"
        );
        $this->addSql(
            "INSERT INTO `plane_models_weathers`(`plane_model_id`,`weather_id`) 
                VALUES ('1', '1'), ('2', '1'), ('2', '2'), ('2', '3'), ('3', '1')"
        );
        $this->addSql(
            "INSERT INTO `plane_model_working_hours`(`id`,`plane_model_id`,`name`,`start`,`end`) 
                VALUES ('1', '1', 'daytime', '07:00:00', '20:00:00'), ('2', '2', 'any time', '00:00:00', '23:59:59'),
                       ('3', '3', 'daytime', '07:00:00', '20:00:00')"
        );
        $this->addSql("INSERT INTO `plane_states`(`id`,`name`) VALUES ('1', 'takeoff'),('2', 'fly'), ('3', 'land')");
        $this->addSql(
            "INSERT INTO `planes`(`id`,`tail_number`,`plane_model_id`,`state_id`,`hangar_id`) 
                VALUES ('1', 'A-1', '1', '3', '1'), ('2', 'A-2', '1', '3', '1'), ('3', 'A-3', '1', '3', '1'),
                       ('4', 'A-4', '1', '3', '1'), ('5', 'A-5', '1', '3', '1'), ('6', 'B-100', '2', '3', '1'),
                       ('7', 'B-155', '2', '1', '1'), ('8', 'C-1', '3', '3', '1'), ('9', 'C-2', '3', '3', '1'),
                       ('10', 'C-3', '3', '3', '1')"
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema) : void
    {
        $this->addSql("SET FOREIGN_KEY_CHECKS=0");
        $this->addSql("TRUNCATE `planes`");
        $this->addSql("TRUNCATE `plane_states`");
        $this->addSql("TRUNCATE `plane_model_working_hours`");
        $this->addSql("TRUNCATE `plane_models_weathers`");
        $this->addSql("TRUNCATE `plane_models_surfaces`");
        $this->addSql("TRUNCATE `plane_models`");
        $this->addSql("TRUNCATE `hangars`");
        $this->addSql("TRUNCATE `weathers`");
        $this->addSql("TRUNCATE `surfaces`");
        $this->addSql("SET FOREIGN_KEY_CHECKS=1");
    }
}
