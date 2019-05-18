Yii 2 Admin Panel Starter-kit
============================

### Установка

Перемещаем olxparser в папку modules.

В конфигурационный файл добавляем

~~~

    'modules' => [
        'olxparser' => [
            'class' => 'app\modules\olxparser\Module',
        ],
    ],
~~~
и запускаем миграцию
~~~
php yii migrate --migrationPath=@app/modules/olxparser/migrations
~~~

Заходим по адресу /olxparser

Удачной работы!