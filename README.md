# Canoe Tech Assessment for Remotely

# Components

- Framework: [Laravel 10.x](https://laravel.com/docs/10.x)

# Setup
## Requirements
1. Docker
1. Docker-compose - Follow instructions here: https://docs.docker.com/compose/install/

## Steps
1. Clone the repository
2. Copy `.env-example` to `.env`.
3. Build execute `docker-compose build`
4. Start the environment `docker-compose up -d`
5. Install PHP composer packages:
```bash
docker exec -it laravel php /usr/local/bin/composer install -d /var/www/html
```
6. Run database migrations:
```bash
docker exec -it laravel php artisan migrate
```
7. _(Optional)_ Run database seeders (to insert dummy data on the DB):
```bash
docker exec -it laravel php artisan db:seed
```

### Notes
1. To destroy the whole environment, except for database data, `docker-compose down`
1. To wipe database just remove the contents of `docker/mysql_data` directory
1. If you need to apply any change of the configuration in `docker/config` directory just `docker-compose stop && docker-compose up -d`

# Networking
All containers (laravel, mysql, mailpit) share a virtual network on which they communicate.

Docker provides DNS resolution based on container name for its networking layer.

If you need to reach one container from another container (eg: "laravel" needs to communicate with "mysql") you can do that by using their names instead of IP in any configuration file.

# Database data
Database data will be preserved and stored inside `docker/mysql_data` directory, this way rotating containers shouldn't have any impact.

# How to use the MySQL container
* MySQL user: root
* MySQL pass: test
* MySQL host: mysql (See Networking section)
* MySQL port: 3306

Note: from developer's local you can reach mysql via localhost to port `3306`

# Apache configuration
Any apache configuration change can be edited inside `docker/config/laravel.conf` file

# Database diagram
[![Database Diagram](docs/Database%20Diagram.png)](https://dbdiagram.io/d/64904c9f02bd1c4a5eb64f1b)

# Features:

API endpoints available over the prefix: /api/

- ### List Funds:
    - **Method:** GET
    - **Endpoint:** /funds
    - **Parameters:**
        - name _(optional)_: _string_ => Filter by Fund name
        - year _(optional)_: _int_ => Filter by Fund start year
        - fund_manager_id _(optional)_: _int_ => Filter by Found Manager ID

- ### Update a Fund:
    - **Method:** PUT
    - **Endpoint:** /fund/**[fund_id]**
    - **Parameters:**
        - fund_id _(required)_: _int_ => ID of a Found
    - **Body:** (JSON)
      - name _(optional)_: _string_ => Name
      - aliases _(optional)_: _[]string_ => Array of aliases
      - start_year _(optional)_: _int_ => Start year
      - fund_manager_id _(optional)_: _int_ => Found Manager ID
      - companies _(optional)_: _[]int_ => Array of Companies IDs
          ```
          {
             "name": ...,
             "aliases": [...],
             "start_year": ...,
             "fund_manager_id": ...,
             "companies": [...],
          }
          ```
# TO-DO:

- **Tests**: Complete tests
