<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240217101052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added department table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<< SQL
        create table department
        (
            id       varchar(100) not null,
            name     varchar(100) not null,
            bonus_id varchar(100) not null,
            constraint department_pk
            primary key (id)
        );
        SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('drop table department');
    }
}
