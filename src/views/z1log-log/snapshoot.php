<?php
	\myzero1\adminlteiframe\gii\GiiAsset::register($this);
	$pluginsBundle = \myzero1\adminlteiframe\assets\php\components\plugins\SwitchAsset::register($this);
    $pluginsBundle->css[] = 'libs/daterangepicker/daterangepicker.css';
    $pluginsBundle->css[] = 'libs/select2/select2.min.css';
    $pluginsBundle->css[] = 'libs/ztree3/css/zTreeStyle/zTreeStyle.css';
    $pluginsBundle->css[] = 'libs/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css';

	// deal,yii2 jQuery(...).yiiActiveForm is not a function
	use yii\widgets\ActiveForm;
	$form = ActiveForm::begin();
	$form = ActiveForm::end();
?>

<div id='snapshoot'>
	<div id='snapshoot-mask'></div>
<?php
    echo $content;
?>

</div>

<style type="text/css">
	#snapshoot{
	    position: relative;
	}
	#snapshoot-mask{
		top: 0;
	    left: 0;
	    bottom: 0;
	    right: 0;
	    position: absolute;
	    z-index: 999999999;
	}
</style>

<script type="text/javascript">
	document.oncontextmenu=new Function("event.returnValue=false;");
	document.onselectstart=new Function("event.returnValue=false;");
</script>