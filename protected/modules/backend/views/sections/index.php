<?php Yii::app()->clientScript->registerScriptFile('/js/jsplugin/jquery.mjs.nestedSortable.js', CClientScript::POS_HEAD); ?>
<?php
$this->breadcrumbs=array(
        'Cписок разделов'
);
?>
<?php echo CHtml::Link('Добавить раздел', array('/backend/sections/create'), array("class" => "btn btn-primary")); ?>

<div class="clearfix structure-header">
    <span class="section_header">Раздел</span>
    <span class="pull-right">
        <span class="section_type">Тип страницы</span>
        <span class="admin-icon">Действия</span>
    </span>
</div>

<?php if($sections): ?>
    <?php $this->renderPartial('_recursion', array('sections'=>$sections, 'level'=> 1)); ?>
<?php endif ?>

<?php echo CHtml::Link('Добавить раздел', array('/backend/sections/create'), array("class" => "btn btn-primary")); ?>
<script>
$(document).ready(function(){
        $('ol.sortable').nestedSortable({
            forcePlaceholderSize: true,
            handle: '.glyphicon-move',
            helper: 'clone',
            items: 'li',
            opacity: .6,
            placeholder: 'placeholder',
            revert: 250,
            tabSize: 25,
            tolerance: 'pointer',
            toleranceElement: '> div',
            isTree: true,
            expandOnHover: 700,
            startCollapsed: true,
            update: function(){
                $("#msg-box").html("<div class='alert alert-success fade in'><img class='loading' src='/images/progress.gif' />Сохранение</div>").fadeIn();
                var hiered = $('ol.sortable').nestedSortable('toHierarchy', {startDepthCount: 0});
                $.ajax({
                type: "POST",
                url: '<?=Yii::app()->createUrl("/backend/sections/savestructure")?>',
                dataType: "json",
                data: { sections: serialize(hiered),'<?=Yii::app()->request->csrfTokenName?>' : '<?=Yii::app()->request->csrfToken?>' },
                success:function(json) {
                    if(json.status == "success")
                        $("#msg-box").html("<div class='alert alert-success fade in'>"+json.msg+"</div>").fadeIn();
                        window.location.reload();
                }
              });
            }
        });
    });
</script>
<style>
.structure-header{
    margin-top: 20px;
    background: #ccc;
    padding: 10px;
}
.admin-icon, .section_show, .section_type{
    display: inline-block;
}
.admin-icon, .section_show{
    width: 100px;
}   
.section_type{
    width: 150px;
}               

.section_header{
            display: inline-block;
    }
    ol {
        margin: 0;
        padding: 0;
        padding-left: 30px;
    }

    ol.sortable, ol.sortable ol {
        margin: 0 0 0 25px;
        padding: 0;
        list-style-type: none;
    }

    ol.sortable {
        margin: 10px 0;
    }
    ol.sortable .glyphicon-move{
        margin-right: 5px;
    }
    ol.sortable > li:first-child > div .remove {
        display: none;
    }
    .sortable .glyphicon-move{
        cursor: move;
        }
    .sortable li {
        margin: 5px 0 0 0;
        padding: 0;
    }

    .sortable li div  {
        border: 1px solid #d4d4d4;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        border-color: #D4D4D4 #D4D4D4 #BCBCBC;
        padding: 6px;
        margin: 0;
        background: #f6f6f6;
        background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #ededed 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(47%,#f6f6f6), color-stop(100%,#ededed));
        background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
        background: -o-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
        background: -ms-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
        background: linear-gradient(to bottom,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed',GradientType=0 );
    }

    .sortable li.mjs-nestedSortable-branch div {
        background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #f0ece9 100%);
        background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#f0ece9 100%);

    }

    .sortable li.mjs-nestedSortable-leaf div {
        background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #bcccbc 100%);
        background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#bcccbc 100%);

    }

    li.mjs-nestedSortable-collapsed.mjs-nestedSortable-hovering div {
        border-color: #999;
        background: #fafafa;
    }

    .disclose {
        cursor: pointer;
        width: 10px;
        display: none;
    }

    .sortable li.mjs-nestedSortable-collapsed > ol {
        display: none;
    }

    .sortable li.mjs-nestedSortable-branch > div > .disclose {
        display: inline-block;
    }

    .sortable li.mjs-nestedSortable-collapsed > div > .disclose > span:before {
        content: '+ ';
    }

    .sortable li.mjs-nestedSortable-expanded > div > .disclose > span:before {
        content: '- ';
    }
</style>