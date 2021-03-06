<?php

namespace Innova\PathBundle\Migrations\pdo_sqlite;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2013/10/22 08:56:30
 */
class Version20131022085629 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE innova_step 
            ADD COLUMN lvl INTEGER NOT NULL
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            DROP INDEX IDX_86F48567727ACA70
        ");
        $this->addSql("
            DROP INDEX IDX_86F48567D96C566B
        ");
        $this->addSql("
            DROP INDEX IDX_86F48567DEDC9FF6
        ");
        $this->addSql("
            DROP INDEX IDX_86F4856765544574
        ");
        $this->addSql("
            DROP INDEX IDX_86F485678FE76F3
        ");
        $this->addSql("
            CREATE TEMPORARY TABLE __temp__innova_step AS 
            SELECT id, 
            parent_id, 
            path_id, 
            name, 
            stepOrder, 
            expanded, 
            instructions, 
            image, 
            withTutor, 
            withComputer, 
            duration, 
            stepType_id, 
            stepWho_id, 
            stepWhere_id 
            FROM innova_step
        ");
        $this->addSql("
            DROP TABLE innova_step
        ");
        $this->addSql("
            CREATE TABLE innova_step (
                id INTEGER NOT NULL, 
                parent_id INTEGER DEFAULT NULL, 
                path_id INTEGER DEFAULT NULL, 
                name VARCHAR(255) NOT NULL, 
                stepOrder INTEGER NOT NULL, 
                expanded BOOLEAN NOT NULL, 
                instructions CLOB DEFAULT NULL, 
                image VARCHAR(255) DEFAULT NULL, 
                withTutor BOOLEAN NOT NULL, 
                withComputer BOOLEAN NOT NULL, 
                duration DATETIME NOT NULL, 
                stepType_id INTEGER DEFAULT NULL, 
                stepWho_id INTEGER DEFAULT NULL, 
                stepWhere_id INTEGER DEFAULT NULL, 
                PRIMARY KEY(id), 
                CONSTRAINT FK_86F48567727ACA70 FOREIGN KEY (parent_id) 
                REFERENCES innova_step (id) 
                ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, 
                CONSTRAINT FK_86F48567D96C566B FOREIGN KEY (path_id) 
                REFERENCES innova_path (id) 
                ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, 
                CONSTRAINT FK_86F48567DEDC9FF6 FOREIGN KEY (stepType_id) 
                REFERENCES innova_stepType (id) NOT DEFERRABLE INITIALLY IMMEDIATE, 
                CONSTRAINT FK_86F4856765544574 FOREIGN KEY (stepWho_id) 
                REFERENCES innova_stepWho (id) NOT DEFERRABLE INITIALLY IMMEDIATE, 
                CONSTRAINT FK_86F485678FE76F3 FOREIGN KEY (stepWhere_id) 
                REFERENCES innova_stepWhere (id) NOT DEFERRABLE INITIALLY IMMEDIATE
            )
        ");
        $this->addSql("
            INSERT INTO innova_step (
                id, parent_id, path_id, name, stepOrder, 
                expanded, instructions, image, withTutor, 
                withComputer, duration, stepType_id, 
                stepWho_id, stepWhere_id
            ) 
            SELECT id, 
            parent_id, 
            path_id, 
            name, 
            stepOrder, 
            expanded, 
            instructions, 
            image, 
            withTutor, 
            withComputer, 
            duration, 
            stepType_id, 
            stepWho_id, 
            stepWhere_id 
            FROM __temp__innova_step
        ");
        $this->addSql("
            DROP TABLE __temp__innova_step
        ");
        $this->addSql("
            CREATE INDEX IDX_86F48567727ACA70 ON innova_step (parent_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_86F48567D96C566B ON innova_step (path_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_86F48567DEDC9FF6 ON innova_step (stepType_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_86F4856765544574 ON innova_step (stepWho_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_86F485678FE76F3 ON innova_step (stepWhere_id)
        ");
    }
}