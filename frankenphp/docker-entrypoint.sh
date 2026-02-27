#!/bin/sh
set -e

if [ "$1" = 'frankenphp' ] || [ "$1" = 'php' ] || [ "$1" = 'bin/console' ]; then
	# Install the project the first time PHP is started
	# After the installation, the following block can be deleted
	if [ ! -f composer.json ]; then
		rm -Rf tmp/
		composer create-project "symfony/skeleton $SYMFONY_VERSION" tmp --stability="$STABILITY" --prefer-dist --no-progress --no-interaction --no-install

		cd tmp
		cp -Rp . ..
		cd -
		rm -Rf tmp/

		composer require "php:>=$PHP_VERSION"
		composer config --json extra.symfony.docker 'true'

	fi

	if [ -z "$(ls -A 'vendor/' 2>/dev/null)" ]; then
		composer install --prefer-dist --no-progress --no-interaction
	fi

	# Build frontend assets if node_modules or entrypoints.json are missing
	if [ -f package.json ] && { [ ! -d node_modules ] || [ ! -f public/build/entrypoints.json ]; }; then
		echo 'Installing npm dependencies and building assets...'
		npm install --no-audit
		npm run dev
	fi

	# Display information about the current project
	# Or about an error in project initialization
	php bin/console -V

	echo 'PHP app ready!'
fi

exec docker-php-entrypoint "$@"
