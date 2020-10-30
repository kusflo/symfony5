SHELL := /bin/bash

tests:
	symfony console doctrine:fixtures:load -n
	symfony php bin/phpunit
.PHONY: tests


# Dump data to SQL file
dumpBd:
	symfony run pg_dump --data-only > dump.sql
.PHONY: dumpBd

# Restore data to BD
restoreBd:
	symfony run psql < dump.sql
.PHONY: restoreBd