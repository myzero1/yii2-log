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

Once the extension is installed, simply modify your application configuration(main.php) as follows:

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
                'remarksFieldsKey' => [
                    'remark', // default filed
                    'r1', // custom field, can add it by yourself
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
                        'obj' => [
                            'label' => '.field-user2-username .control-label',
                            'value' => '#user2-username',
                        ],
                        'remarks' => [// the items must be Closure
                            'remark' => function(){return 'default remark'.time();},
                            'r1' => function(){return 'r1'.time();},
                        ],
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

### use z1logAdd($model, $screenshot, $screenshotParams, $text, $obj, $remarks) anywhere ###

```php

\myzero1\log\components\export\Export::z1logAdd('all', 'user2/update', ['id'=>$model->id], 'create user', sprintf('username:%s', $model->username), ['remark'=>'this is a remark']);

```

Usage scenario
----

* Just add config to ` mian.php `,when we want to add log,there is updating with the action.· ` The screenshots will record the data before updating. `

* Use ` z1logAdd ` api,when we are create a new record.we get he id of the new record at action,so easy
.

```PHP 


    /**
     * Creates a new User2 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User2();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            \myzero1\log\components\export\Export::z1logAdd('all', 'user2/update', ['id'=>$model->id], 'create user', sprintf('username:%s', $model->username), '');

            Yii::$app->getSession()->setFlash('success', '添加成功');
            return \myzero1\adminlteiframe\helpers\Tool::redirectParent(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

```

* Use ` z1logAdd ` api,when we want to add log,but there is not updating with the action.
