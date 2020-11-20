dev:
	php bin/console doctrine:database:drop -n --if-exists --force
	php bin/console doctrine:database:create
	php bin/console doctrine:migrations:migrate -n
	php bin/console doctrine:fixtures:load -n
