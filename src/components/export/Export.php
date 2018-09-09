<?php

namespace myzero1\log\components\export;

/**
 * Export
 *
 */
class Export
{
    /**
     * @inheritdoc
     */


    /**
     * unset the z1logSaved session.remarksfields = ['remark','r1','r2',...]
     * 
     * @param string $model text,screenshot,all
     * @param string $screenshot 'z1user/user2/update' The template router
     * @param array $screenshotParams ['id'=>21]
     * @param string $text
     * @param string $obj
     * @param array $remarks ['remark'=>'remark value', 'r1' => 'v1', 'filed' => 'value'],
     *
     *  \Yii::$app->params['dependClass']['z1logExport']::z1logAdd('all','z1user/user2/index', [], function(){return 'aa';});
     *
     * @return viod 
     * 
     * @author myzero1
     * @since 2.0.13
     */
    public static function z1logAdd($model, $screenshot, array $screenshotParams, $text, $obj='', array $remarks=['remark'=>'',]){

        if (!isset($_SESSION['z1logSaved'])) {
            $_SESSION['z1logSaved'] = 1;
        }

        $screenshotContent = '';
        $url = '';

        if (in_array($model, ['all','screenshot']) ) {
            $params = \Yii::$app->request->get();
            \Yii::$app->params['z1log']['params']['z1logToRending'] = true;
            $params = array_merge($params, $screenshotParams);
            $sHtml = \Yii::$app->runAction($screenshot, $params);
            $sHtmlCom = $sHtml;
            $sHtmlCom = ltrim(rtrim(preg_replace(array("/> *([^ ]*) *</","//","'/\*[^*]*\*/'","/\r\n/","/\n/","/\t/",'/>[ ]+</'),array(">\\1<",'','','','','','><'),$sHtml)));
            $sHtmlCom = str_replace('href="', 'hrefDisabled="', $sHtmlCom);
            $sHtmlCom = str_replace('action="', 'actionDisabled="', $sHtmlCom);
            $sHtmlCom = str_replace('type="submit"', 'typeDisabled="submit"', $sHtmlCom);

            $screenshotContent = $sHtmlCom;

            array_unshift($params, '/' . $screenshot);
            $url = \yii\helpers\Url::to($params);
        }

        $filedsDefault = [
            'id',
            'user_id',
            'user_name',
            'ip',
            'created',
            'url',
            'text',
            'screenshot',
            'uri',
            'obj',
        ];
        $remarksKeys = array_keys($remarks);
        $diffKeys = array_intersect (\Yii::$app->params['z1log']['params']['remarksFieldsKey'], $remarksKeys);
        if (count($diffKeys)!= count($remarksKeys) || count($diffKeys)!= count(\Yii::$app->params['z1log']['params']['remarksFieldsKey'])) {
            exit('the remarks fileds is wrong.');
        }
        $fileds = array_merge($filedsDefault, $remarksKeys);

        $valueDefaults = [
            'user_id' => \Yii::$app->params['z1log']['params']['userInfo']['id'](),
            'user_name' => \Yii::$app->params['z1log']['params']['userInfo']['name'](),
            'ip' => \Yii::$app->request->userIP,
            'created' => time(),
            'url' => $url,
            'text' => $text,
            'screenshot' => base64_encode($screenshotContent),
            'uri' => \Yii::$app->request->pathInfo,
            'obj' => $obj,
        ];
        $values = array_merge($valueDefaults, $remarks);

        $sql = sprintf("INSERT INTO `z1log_log` ( `%s` ) VALUES (NULL, '%s')",
                    implode('`,`', $fileds),
                    implode("','", $values));

        \Yii::$app->db->createCommand($sql)->execute();
    }
}
