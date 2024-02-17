<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240217112416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create payroll report table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<< SQL
            create table payroll_report
            (
                id              varchar(100) not null
                    primary key,
                generation_date datetime     not null
            );
        SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('drop table payroll_report');
    }
}
