<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PlaceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\myzero1\adminlteiframe\gii\GiiAsset::register($this);

// var_dump(\Yii::$app->controller->module->dependClass['RbacpRole']::find());exit;

$this->title = '日志管理';
?>
<div class="place-index" id="search_form">

    <div class="adminlteiframe-action-box user2-search">

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]); ?>

        <?= $form->field($searchModel, 'text')?>

        <?= $form->field($searchModel, 'url')?>

        <?= $form->field($searchModel, 'uri')?>

        <?= $form->field($searchModel, 'obj')?>

        <?= $form->field($searchModel, 'remark')?>

        <?= $form->field($searchModel, 'user_id')?>

        <?= $form->field($searchModel, 'user_name')?>

        <div class="form-group aciotns">
            <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'headerOptions' => ['width'=>'30'],
                'class' => yii\grid\CheckboxColumn::className(),
                'name' => 'z1selected',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $model->id];
                },
            ],
            'id',
            'text',
            'url',
            'uri',
            'obj',
            'remark',
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
            [
                // 'contentOptions' => [
                //     'width'=>'100'
                // ],
                'headerOptions' => [
                    'width'=>'100px'
                ],
                'header' => Yii::t('rbacp', '对比数据'),
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',

                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $options = array_merge([
                            'class'=>'btn btn-info btn-xs use-layer',
                            'layer-config' => sprintf('{area:["700px","400px"],type:2,title:"%s",content:"%s",shadeClose:false}', '查看截图数据', url::to(['/'.$this->context->module->id.'/z1log-log/snapshoot', 'id' => $model->id])) ,
                        ]);

                        if (!empty($model->screenshot)) {
                            return Html::a('截图数据', '#', $options);
                        }
                    },
                    'update' => function ($url, $model, $key) {
                        $options = array_merge([
                            'class'=>'btn btn-primary btn-xs use-layer',
                            'layer-config' => '{area:["700px","400px"],type:2,title:"查看当前数据",content:"'.$model->url.'",shadeClose:false,success: function(layero, index){layero.children(".layui-layer-content").append(" <div style=\"width: 100%;height: 100%;top: 0;position: absolute;color: #f39c12;text-align: center;font-size: 18px;font-weight: bold;\">此为当前数据快照不可修改!</div>");layero.children(".layui-layer-content").append("<script type=\"text/javascript\">document.oncontextmenu=new Function(\"event.returnValue=false;\");document.onselectstart=new Function(\"event.returnValue=false;\");</script>")}}',
                        ]);

                        return Html::a('当前数据', '#', $options);

                    },
                ],
            ],
        ],
        'options' => [
            'rbacp_policy_sku' => 'rbacp|rbacp-privilege|index|rbacpPolicy|list|rbacp权限列表',
            'class' => 'adminlteiframe-gridview',
        ],
        'tableOptions' => [
            'class' => 'gridview-table table table-bordered table-hover dataTable'
        ],
        'summary' => '
            <div class="admlteiframe-gv-summary">
                共 <span class="total">{totalCount}</span> 条
            </div>
        ',
        'layout'=> '
            {items}
            <div class="admlteiframe-gv-footer">
                {pager}{summary}
            </div>
        ',
        'pager' => [
            'class' => \myzero1\adminlteiframe\widgets\LinkPager::className(),
            'firstPageLabel'=>"<<",
            'prevPageLabel'=>'<',
            'nextPageLabel'=>'>',
            'lastPageLabel'=>'>>',
            'maxButtonCount'=>'5',
            // 'activePageCssClass' => 'btn btn-primary btn-xs',
            'hideOnSinglePage'=>false,
            'options' => [
                'class' => 'admlteiframe-gv-pagination'
            ],
        ],
    ]); ?>

</div>

<?php 
$js=<<<eof
    function getTableHeight(){
        var heightToal = window.parent.$('html').outerHeight(true);
        var filterHeight = $(".adminlteiframe-action-box").height();
        height = heightToal - $(".adminlteiframe-action-box").height();// subtract filters
        height = height - 260;// subtract others
        return height;
    }

    function fixTable(){
        if (!($(".gridview-table .empty").length > 0 || $(".gridview-table tbody tr").length == 0)) {
                if(typeof mybootstrapTable!="undefined"){
                    mybootstrapTable.bootstrapTable('destroy');
                }

                mybootstrapTable = $(".gridview-table").bootstrapTable('destroy').bootstrapTable({
                    height: getTableHeight(),
                    fixedColumns: true
                });
        }
    }

    fixTable();

    $(window).resize(function(){
        fixTable();
    });

eof;

$this->registerJs($js);

?>