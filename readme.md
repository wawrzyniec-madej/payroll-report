# 🪙 Payroll application 🪙

## Before you start:
- Communication with docker is handled by Makefile
- Docker configuration was tested on windows with wsl 
- If you need to generate app compatible id use `make identifier`


## Starting app:
1. Execute `make setup`

## Functionalities:
### Generating new payroll report
Endpoint: `POST /payroll-report/generate`

Endpoint returns generated report `id` to be used in next functionality.
### Viewing payroll report
Endpoint: `GET /payroll-report/{id}/rows`

Can be sorted using query param in format `?sort[sortName]=sortDirection`.

Available sort names are:
- name
- surname
- department
- remunerationBase
- additionToBase
- bonusType
- salaryWithBonus

Available sort directions are:
- asc
- desc

Can be filtered using query param in format `?filterName=filterValue`.

Available filter names are:
- department
- name
- surname

## Design assumptions:
1. Departments, employees and bonuses can be added by making direct inserts into database
2. Request can only use one sort at a time
3. Request can use many filters at a time