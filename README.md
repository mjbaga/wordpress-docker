# wordpress-docker
Docker container for WordPress

To use, clone repository and run:
```docker-compose up -d --build```

Run composer by to pull in WordPress:
```docker-compose run --rm composer install```

To install composer theme vendor files and autoload: (Change ${} in themes directory)
```docker-compose run --rm compose install --working-dir /var/www/html/wp-content/themes/${wordpress-site}```

To install composer plugin vendor files and autoload: (Change ${} in themes directory)
```docker-compose run --rm compose install --working-dir /var/www/html/wp-content/plugins/${wordpress-site}```
