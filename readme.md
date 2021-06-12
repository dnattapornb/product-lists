## Database

#### Create database "unique"
```mysql
mysql -uroot -proot

CREATE SCHEMA `shop` DEFAULT CHARACTER SET utf8mb4;
```

#### Create migration table
```bash
php artisan make:migration create_line_users_table --create=line_users
php artisan make:model Models/LineUser

php artisan make:migration create_rom_characters_table --create=rom_characters
php artisan make:migration add_foreign_key_to_rom_characters_table --table=rom_characters
php artisan make:migration remove_main_column_from_rom_characters_table --table=rom_characters
php artisan make:model Models/RomCharacter

php artisan make:migration create_rom_jobs_table --create=rom_jobs
php artisan make:migration add_foreign_key_rom_job_id_to_rom_characters_table --table=rom_characters
php artisan make:migration convert_foreign_key_rom_job_id_to_guild_wars_rom_job_id_on_rom_characters_table --table=rom_characters
php artisan make:migration add_foreign_key_activities_rom_job_id_to_rom_characters_table --table=rom_characters
php artisan make:model Models/RomJob
```

#### Run migration and Seed
```bash
php artisan migrate
php artisan db:seed
```

#### Configuration Caching
> If you execute the `config:cache` command during your deployment process, you should be sure that you are only calling the `.env` function from within your configuration files.
```bash
php artisan config:cache
```

## Laravel Excel
[https://docs.laravel-excel.com/3.1/getting-started/](https://docs.laravel-excel.com/3.1/getting-started/)
[https://github.com/Maatwebsite/Laravel-Excel](https://github.com/Maatwebsite/Laravel-Excel)
```bash
composer require maatwebsite/excel
```
> ServiceProvider in `config/app.php`:
```php
'providers' => [

    //...

    /*
     * Package Service Providers...
     */
    Maatwebsite\Excel\ExcelServiceProvider::class,

]
```
> Facade in `config/app.php`:
```php
'aliases' => [

    //...

    'Excel' => Maatwebsite\Excel\Facades\Excel::class,

]
```
> This will create a new config file named `config/excel.php`
```php
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config
```

## Docs
[https://docs.github.com/en/github/writing-on-github/basic-writing-and-formatting-syntax](https://docs.github.com/en/github/writing-on-github/basic-writing-and-formatting-syntax)

## License

The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
