<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240217122526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create bonus table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<< SQL
        create table bonus
        (
            id                    varchar(100) not null
                primary key,
            type                  varchar(100) not null,
            yearly_bonus_amount   int          null,
            yearly_bonus_currency varchar(100) null,
            employment_threshold  int          null,
            percentage            int          null
        );
        SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('drop table bonus;');
    }
}
