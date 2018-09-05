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
                        'obj' => [ // for obj
                            'label' => '.field-user2-username .control-label',
                            'value' => '#user2-username', // css3 selector
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


### use addObj($obj) and addRemarks($obj) before save() ###

```php

    /**
     * Updates an existing User2 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            \myzero1\log\components\export\Export::addObj('用户名：myzero1');
            \myzero1\log\components\export\Export::addRemarks('用户名："myzero1"->"myzero3"');
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', '修改成功');
                return \myzero1\adminlteiframe\helpers\Tool::redirectParent(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

```

### use z1logAdd($model, $screenshot, $screenshotParams, $text, $obj, $remarks) anywhere ###

```php

\myzero1\log\components\export\Export::z1logAdd('all', 'user2/update', ['id'=>21], function(){return 'update user'}, 'username：myzero1', 'status:(1)->(2)')

```

