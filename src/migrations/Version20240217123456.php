<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240217123456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add base data';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            INSERT INTO bonus (id, type, yearly_bonus_amount, yearly_bonus_currency, employment_threshold, percentage)
            VALUES ('01HPVH2J3X6YSVFZM478D7840T', 'seniority', 10000, 'usd', 10, null);
        ");

        $this->addSql("
            INSERT INTO bonus (id, type, yearly_bonus_amount, yearly_bonus_currency, employment_threshold, percentage)
            VALUES ('01HPVH31QG9DQ14J0HJHWCXP2E', 'percentage', null, null, null, 10);
        ");

        $this->addSql("
            INSERT INTO department (id, name, bonus_id)
            VALUES ('01HPVH858BBZG1CZ93C0R6876F', 'HR', '01HPVH2J3X6YSVFZM478D7840T');
        ");

        $this->addSql("
            INSERT INTO department (id, name, bonus_id)
            VALUES ('01HPVH92RWMSQKENF5WJPQ8G24', 'Customer Service', '01HPVH31QG9DQ14J0HJHWCXP2E');
        ");

        $this->addSql("
            INSERT INTO employee (id, name, surname, date_of_employment, department_id, base_salary_amount, base_salary_currency)
            VALUES ('01HPVHCSEK0FSGBEJ7HW43VRN7', 'Adam', 'Kowalski', '2009-02-17 13:42:28', '01HPVH858BBZG1CZ93C0R6876F', 100000, 'usd');
        ");

        $this->addSql("
            INSERT INTO employee (id, name, surname, date_of_employment, department_id, base_salary_amount, base_salary_currency)
            VALUES ('01HPVHCX0211AN7V97RQR3179D', 'Ania', 'Nowak', '2021-02-17 13:42:36', '01HPVH92RWMSQKENF5WJPQ8G24', 110000, 'usd');
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("delete from bonus where id in('01HPVH2J3X6YSVFZM478D7840T', '01HPVH31QG9DQ14J0HJHWCXP2E');");
        $this->addSql("delete from department where id in('01HPVH858BBZG1CZ93C0R6876F', '01HPVH92RWMSQKENF5WJPQ8G24');");
        $this->addSql("delete from employee where id in('01HPVHCSEK0FSGBEJ7HW43VRN7', '01HPVHCX0211AN7V97RQR3179D');");
    }
}
