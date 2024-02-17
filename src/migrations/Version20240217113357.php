<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240217113357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create payroll report row table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<< SQL
        create table payroll_report_row
        (
            id                         varchar(100) not null
                primary key,
            payroll_report_id          varchar(100) not null,
            department                 varchar(100) not null,
            name                 varchar(100) not null,
            surname                 varchar(100) not null,
            remuneration_base_amount   int          not null,
            remuneration_base_currency varchar(100) not null,
            addition_to_base_amount    int          not null,
            addition_to_base_currency  varchar(100) not null,
            bonus_type                 varchar(100) not null,
            salary_with_bonus_amount   int          not null,
            salary_with_bonus_currency varchar(100) not null,
            constraint payroll_report_row_payroll_report_id_fk
                foreign key (payroll_report_id) references payroll_report (id)
        );
        SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('drop table payroll_report_row;');
    }
}
