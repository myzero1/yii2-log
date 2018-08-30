<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PlaceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// var_dump(\Yii::$app->controller->module->dependClass['RbacpRole']::find());exit;

$this->title = '日志管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="place-index" id="search_form">

    <div class="query">

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'fieldConfig' => [
                'template' => '
                    <div class="search_item">
                        <label>{label}：</label>
                        <div>{input}</div>
                    </div>
                ',
                'options' => [
                    'tag' => false,
                ],
                'inputOptions' => [
                    'class' => 'form-control-me',
                ]
            ],
        ]); ?>

        <?= $form->field($searchModel, 'text')?>

        <?= $form->field($searchModel, 'url')?>

        <?= $form->field($searchModel, 'user_id')?>

        <?= $form->field($searchModel, 'user_name')?>

        <div class="search_item">
            <div>
                <?= Html::submitButton('查询', ['class' => 'btn-sm btn btn-primary', 'style' => 'margin-top:2px;']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <div class="clear"></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'class' => 'list',
        ],
        'summary' => '
            <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
                <span>共<font id="P_RecordCount" style="color:Red;">{totalCount}</font>条记录</span>
                <span>第<font id="P_Index" style="color:Red;">{page}</font>/<font id="P_PageCount" style="color:Red;">{pageCount}</font>页</span>
                <span>每页<font id="P_PageSize" style="color:Red;">{count}</font>条记录</span>
            </div>
        ',
        'layout'=> '
            {items}
            <div class="footer-clearfix"></div>
            <div class="footer">
                <div class="row box-footer clearfix" id="PageTurn">
                    <div class="col-sm-5">
                        {summary}
                    </div>
                    <div class="col-sm-7">
                        {pager}
                    </div>
                </div>
            </div>
        ',
        'pager' => [
            'class' => \myzero1app\themes\adminlte\widgets\LinkPager::className(),
            'firstPageLabel'=>"首页",
            'prevPageLabel'=>'上一页',
            'nextPageLabel'=>'下一页',
            'lastPageLabel'=>'末页',
            'maxButtonCount'=>'0',
            'hideOnSinglePage'=>false,
        ],
        'tableOptions' => ['class' => 'dataTables_wrapper no-footer'],
        'columns' => [
            'id',
            'text',
            'screenshot' => [
                'label'=>'截图日志',
                'content' => function($row){
                    return Html::tag ('span', '查看截图',[
                        'class'=>'list_r list_crud_act',
                        'crud-url'=>url::to(['/z1log/z1log-log/snapshoot', 'id' => $row->id]),
                        'crud-method'=>'get',
                        'crud-data'=>'',
                        'win-title'=>'查看截图',
                        'win-width'=>'800px',
                    ]);
                }
            ],
            'url' => [
                'label'=>'操作Url',
                'attribute' => 'url',
                'value' => function($row){
                    return $row->url;
                }
            ],
            'user_id',
            'user_name',
            'ip',
            'created' => [
                'label'=>'创建时间',
                'attribute' => 'created',
                'value' => function($row){
                    return is_null($row->created) ? '' : date('Y-m-d H:i:s', $row->created);
                }
            ],
        ],
    ]); ?> 

</div>