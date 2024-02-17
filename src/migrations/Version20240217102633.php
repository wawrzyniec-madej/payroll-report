<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240217102633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added employee table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<< SQL
        create table employee
        (
            id                   varchar(100) not null
                primary key,
            name                 varchar(100) not null,
            surname              varchar(100) not null,
            date_of_employment   datetime     not null,
            department_id        varchar(100) not null,
            base_salary_amount   int          not null,
            base_salary_currency varchar(100) not null
        );
        SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('drop table employee');
    }
}
