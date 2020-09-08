<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20200908055331
 */
final class Version20200908055331 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Additional hangar';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql("INSERT INTO `hangars`(`id`,`name`) VALUES ('2', 'Military hangar')");

    }

    public function down(Schema $schema) : void
    {
        $this->addSql("DELETE FROM `hangars` WHERE `id` = 2");
    }
}
