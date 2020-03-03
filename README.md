#Union School


##配置

### 在 config/app.php 注册 ServiceProvider 和 Facade 
'providers' => [
    // ...
    ZoonTao\School\ServiceProvider::class,
],
'aliases' => [
    // ...
    'ZXT' => ZoonTao\School\Facade::class,
],


### 创建配置文件： 

php artisan vendor:publish --provider="ZoonTao\School\ServiceProvider"
