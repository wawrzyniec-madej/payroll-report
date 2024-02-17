# Payroll application

## Requirements:
1. Communication with docker is handled by make.

## Starting app:
1. Execute `make setup` command

## Available endpoints:
1. `/payroll-report/generate` - Generates new payroll report and returns resource identifier
2. `/payroll-report/{id}` - Shows generated payroll report with filters and sort