#Union School


##配置

### 在 config/app.php 注册 ServiceProvider 和 Facade 
'providers' => [
    // ...
    UnionSchool\ServiceProvider::class,
],
'aliases' => [
    // ...
    'ZXT' => UnionSchool\Facade::class,
],


### 创建配置文件： 

php artisan vendor:publish --provider="UnionSchool\ServiceProvider"
