yii2-log
========================

The log module,include text log, screenshot log, and both.

Show time
------------

![](https://github.com/myzero1/show-time/blob/master/yii2-log/screenshot/1.png)
![](https://github.com/myzero1/show-time/blob/master/yii2-log/screenshot/2.png)

Installation
------------

The preferred way to install this module is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require myzero1/yii2-log：1.*
```

or add

```
"myzero1/yii2-log": "~1"
```

to the require section of your `composer.json` file.



Setting
-----

Once the extension is installed, simply modify your application configuration as follows:

```php
return [
    ......
    'bootstrap' => [
        ......
        'z1log',
        ......
    ],
    'modules' => [
        ......
        'z1log' => [
            'class' => '\myzero1\log\Module',    
            'params' => [
                'urlManager' => [
                    'rules' => [
                        // 'rate/area/index' => 'rate/jf-core-area/index',
                    ],
                ],
                'userInfo' => [
                    'id' => function(){
                        if(\Yii::$app->user->isGuest){
                            $id = 0;
                        } else {
                            $id = \Yii::$app->user->identity->id;
                        }

                        return $id;
                    },
                    'name' => function(){
                        if(\Yii::$app->user->isGuest){
                            $name = 'system';
                        } else {
                            $name = \Yii::$app->user->identity->username;
                        }
                        
                        return $name;
                    }
                ],
                'template' => [
                    'user2/update' => [
                        'model' => 'all', // text,screenshot,all
                        'text' => function(){
                            return '修改用户'; 
                        },
                        'screenshot' => 'user2/update', // The template of screenshot
                    ],
                ],
            ],
        ],
        ......
    ],
    ......
];
```

Apply migrations:

```cmd
    php yii migrate --migrationPath=@vendor/myzero1/yii2-log/src/migrations
```

Usage
-----


You can access Demo through the following URL:

```
http://localhost/path/to/index.php?r=z1log/z1log-log/index
```

or if you have enabled pretty URLs, you may use the following URL:

```
http://localhost/path/to/index.php/z1log/z1log-log/index
```


` Notice:` You just setting in main.php.
