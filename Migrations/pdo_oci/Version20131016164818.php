<?php

namespace Innova\PathBundle\Migrations\pdo_oci;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2013/10/16 04:48:19
 */
class Version20131016164818 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE innova_step 
            ADD (
                name VARCHAR2(255) NOT NULL
            )
        ");
        $this->addSql("
            ALTER TABLE innova_step 
            DROP (resourceNode_id)
        ");
        $this->addSql("
            ALTER TABLE innova_step 
            DROP CONSTRAINT FK_86F48567B87FAB32
        ");
        $this->addSql("
            DROP INDEX UNIQ_86F48567B87FAB32
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE innova_step 
            ADD (
                resourceNode_id NUMBER(10) DEFAULT NULL
            )
        ");
        $this->addSql("
            ALTER TABLE innova_step 
            DROP (name)
        ");
        $this->addSql("
            ALTER TABLE innova_step 
            ADD CONSTRAINT FK_86F48567B87FAB32 FOREIGN KEY (resourceNode_id) 
            REFERENCES claro_resource_node (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            CREATE UNIQUE INDEX UNIQ_86F48567B87FAB32 ON innova_step (resourceNode_id)
        ");
    }
}