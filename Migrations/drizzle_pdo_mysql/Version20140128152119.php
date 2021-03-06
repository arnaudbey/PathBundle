<?php

namespace Innova\PathBundle\Migrations\drizzle_pdo_mysql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2014/01/28 03:21:20
 */
class Version20140128152119 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE innova_step CHANGE steporder step_order INT NOT NULL
        ");
        $this->addSql("
            ALTER TABLE innova_path CHANGE deployed published BOOLEAN NOT NULL
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE innova_path CHANGE published deployed BOOLEAN NOT NULL
        ");
        $this->addSql("
            ALTER TABLE innova_step CHANGE step_order stepOrder INT NOT NULL
        ");
    }
}