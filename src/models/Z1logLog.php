<?php

namespace myzero1\log\models;

use Yii;

/**
 * This is the model class for table "z1log_log".
 *
 * @property int $id
 * @property int $user_id 操作人id
 * @property string $user_name 操作人的账号名称
 * @property string $ip 操作人的登录ip
 * @property int $created 日志创建时间
 * @property string $url 访问地址的相对url
 * @property string $text 文本日志
 * @property string $screenshot 截图日志
 * @property string $uri 操作模块uri
 * @property string $obj 访问对象信息,一般为唯一键
 * @property string $remark 备注信息
 */
class Z1logLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'z1log_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'user_name', 'url', 'text', 'screenshot'], 'required'],
            [['user_id', 'created'], 'integer'],
            [['text', 'screenshot'], 'string'],
            [['user_name', 'ip', 'url', 'uri', 'obj', 'remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '操作人Id',
            'user_name' => '操作人名称',
            'ip' => '操作IP',
            'created' => '操作时间',
            'url' => '截图url',
            'text' => '文本日志',
            'screenshot' => '截图日志',
            'uri' => '操作模块',
            'obj' => '操作对象',
            'remark' => '备注',
        ];
    }
}
