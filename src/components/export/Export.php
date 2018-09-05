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
     * unset the z1logSaved session.
     * 
     * @param string $model text,screenshot,all
     * @param string $screenshot 'z1user/user2/update' The template router
     * @param array $screenshotParams ['id'=>21]
     * @param string $text
     *
     *  \Yii::$app->params['dependClass']['z1logExport']::z1logAdd('all','z1user/user2/index', [], function(){return 'aa';});
     *
     * @return viod 
     * 
     * @author myzero1
     * @since 2.0.13
     */
    public static function z1logAdd($model, $screenshot, array $screenshotParams, $text, $obj='', $remarks=''){

        if (!isset($_SESSION['z1logSaved'])) {
            $_SESSION['z1logSaved'] = 1;
        }

        $screenshotContent = '';
        $url = '';

        if (in_array($model, ['all','screenshot']) ) {
            $params = \Yii::$app->request->get();
            \Yii::$app->params['z1log']['params']['z1logToRending'] = true;
            $params = array_merge($params, $screenshotParams);
            $sHtml = \Yii::$app->runAction('/' . $screenshot, $params);
            $sHtmlCom = $sHtml;
            $sHtmlCom = ltrim(rtrim(preg_replace(array("/> *([^ ]*) *</","//","'/\*[^*]*\*/'","/\r\n/","/\n/","/\t/",'/>[ ]+</'),array(">\\1<",'','','','','','><'),$sHtml)));
            $sHtmlCom = str_replace('href="', 'hrefDisabled="', $sHtmlCom);
            $sHtmlCom = str_replace('action="', 'actionDisabled="', $sHtmlCom);
            $sHtmlCom = str_replace('type="submit"', 'typeDisabled="submit"', $sHtmlCom);

            $screenshotContent = $sHtmlCom;

            array_unshift($params, '/' . $screenshot);
            $url = \yii\helpers\Url::to($params);
        }

        $sql = sprintf("INSERT INTO `z1log_log` (
                    `id`,
                    `user_id`,
                    `user_name`,
                    `ip`,
                    `created`,
                    `url`,
                    `text`,
                    `screenshot`,
                    `uri`,
                    `obj`,
                    `remarks`
                )
                VALUES
                    (NULL, %d, '%s', '%s', %d, '%s', '%s', '%s', '%s', '%s', '%s')",
                    \Yii::$app->params['z1log']['params']['userInfo']['id'](),
                    \Yii::$app->params['z1log']['params']['userInfo']['name'](),
                    \Yii::$app->request->userIP,
                    time(),
                    $url,
                    $text,
                    base64_encode($screenshotContent),
                    \Yii::$app->request->pathInfo,
                    $obj,
                    $remarks);

        \Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * unset the z1logSaved session.
     * 
     * @param string $obj    // 用户名：myzero1
     *
     *  \Yii::$app->params['dependClass']['z1logExport']::z1logAdd('all','z1user/user2/index', [], function(){return 'aa';});
     *
     * @return viod 
     * 
     * @author myzero1
     * @since 2.0.13
     */
    public static function addObj($obj){
        $_SESSION['z1log_addObj'] = $obj;
    }

    /**
     * unset the z1logSaved session.
     * 
     * @param string $remarks    // 用户名："myzero1"->"myzero2"
     *
     *  \Yii::$app->params['dependClass']['z1logExport']::z1logAdd('all','z1user/user2/index', [], function(){return 'aa';});
     *
     * @return viod 
     * 
     * @author myzero1
     * @since 2.0.13
     */
    public static function addRemarks($remarks){
        $_SESSION['z1log_addRemarks'] = $remarks;
    }
}
