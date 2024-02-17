<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240217123107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add key constraints';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            alter table department
            add constraint department_bonus_id_fk
            foreign key (bonus_id) references bonus (id);
        ');

        $this->addSql('
            alter table employee
            add constraint employee_department_id_fk
            foreign key (department_id) references department (id);
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            alter table department
            drop foreign key department_bonus_id_fk;
        ');

        $this->addSql('
            alter table employee
            drop foreign key employee_department_id_fk;
        ');
    }
}
