<div class="index blocks_index">    
    <h2>Общий список блоков позиции </h2>    
    <?php
    $form = $this->beginWidget('BsActiveForm', array(
        'id' => 'blocks_index',
        'method' => 'POST',
        'action' => Yii::app()->createUrl('/backend/blocks/savePosition', array('position' => $positionHelper->position)),
        'htmlOptions' => array(
            'role' => "form",
        ),
    ));
    ?>    
    <table class="table table-hover table-condensed">            
        <thead>                
            <tr>
                <th></th>
                <th>Имя блока</th>
                <th>Не насл.</th>
                <th>Шаблон</th>
                <th>Тип блока</th>
            </tr>            
        </thead>            
        <tbody>   
            <?php foreach ($positionHelper->blockInPosition as $one): ?>
                <tr>                        
                    <td align="center">                            
                        <input class="select_block" checked='checked' type="checkbox" name="Blocks[id_array][]" value="<?php echo $one->id ?>" onClick="removeUseParentBlocks($(this))">
                    </td>                        
                    <td style="vertical-align:middle;">                            
                        <a href="<?php echo Yii::app()->createUrl('/backend/blocks/update', array('id' => $one->id, 'position' => $positionHelper->position)) ?>" title="Редактировать блок '<?php echo $one->name ?>'"><span class="glyphicon glyphicon-edit"></span></a>                            
                        <a href="<?php echo Yii::app()->createUrl('/backend/blocks/delete', array('id' => $one->id, 'position' => $positionHelper->position)) ?>" title="Удалить блок '<?php echo $one->name ?>'" onClick="return window.confirm('Удалить блок &laquo;<?php echo $one->name ?>&raquo; ?')"><span class="glyphicon glyphicon-remove"></span></a>                            
                        <?php echo $one->name ?>        
                        <?php if($positionHelper->inherit):?><br/>(унаследовано)<?php endif;?>
                    </td>
                    <td style="vertical-align:middle;">                            
                        <input class="notinherit" <?php if ($one->notinherit): ?>checked='checked'<?php endif ?> type="checkbox" name="Blocks[notinherit][<?php echo $one->id ?>]" >                        
                    </td>
                    <td style="vertical-align:middle;">                            
                        <?php echo $one->template->name ?>   
                    </td>
                    <td align="center">
                        <?php echo $one->typeName ?>
                    </td>                    
                </tr>                    
            <?php endforeach ?>         
            <?php foreach ($positionHelper->blockNotInPosition as $one): ?>
                <tr>                        
                    <td align="center">                            
                        <input class="select_block" type="checkbox" name="Blocks[id_array][]" value="<?php echo $one->id ?>" onClick="removeUseParentBlocks($(this))">
                    </td>                        
                    <td style="vertical-align:middle;">                            
                        <a href="<?php echo Yii::app()->createUrl('/backend/blocks/update', array('id' => $one->id, 'position' => $positionHelper->position)) ?>" title="Редактировать блок '<?php echo $one->name ?>'"><span class="glyphicon glyphicon-edit"></span></a>                            
                        <a href="<?php echo Yii::app()->createUrl('/backend/blocks/delete', array('id' => $one->id, 'position' => $positionHelper->position)) ?>" title="Удалить блок '<?php echo $one->name ?>'" onClick="return window.confirm('Удалить блок &laquo;<?php echo $one->name ?>&raquo; ?')"><span class="glyphicon glyphicon-remove"></span></a>                            
                        <?php echo $one->name ?>                       
                    </td>
                    <td style="vertical-align:middle;">                            
                        <input class="notinherit" type="checkbox" name="Blocks[notinherit][<?php echo $one->id ?>]" >                        
                    </td>
                    <td style="vertical-align:middle;">                            
                        <?php echo $one->template->name ?>   
                    </td>
                    <td align="center">
                        <?php echo $one->typeName ?>
                    </td>                    
                </tr>                    
            <?php endforeach ?>         
        </tbody>
    </table>
    <div class="control-group">                
        <div class="controls">                    
            <label class="checkbox">                        
                <input class="none_blocks" type="checkbox" <?php if ($positionHelper->noneBlock): ?> checked='checked' <?php endif ?> name="Blocks[none_blocks]" onClick="setNoneBlocks($(this))"/> Не использовать блоки для этой позиции                    
            </label>                
        </div>            
    </div>            
    <div class="buttonswrap">                
        <div class="buttons">                    
            <input type="hidden" id='position_id' name='position_id' value="<?php echo $positionHelper->position ?>">                    
            <input type="button" class="btn btn-primary" value="Сохранить" onClick="saveBlocks()">                    
            <a href="<?php echo Yii::app()->createUrl('/backend/blocks/create', array('position' => $positionHelper->position)) ?>" class="btn btn-primary">Добавить новый блок</a>                    
            <input type="button" class="btn" value="Отмена" onClick="self.close();">                
        </div>            
    </div>   
    <?php $this->endWidget(); ?>
</div>


<script>
    function setNoneBlocks(obj) {
        if ($(obj).is(":checked")) {
            $(".select_block").removeAttr("checked");
            $(".notinherit").removeAttr("checked");
        }
    }

    function removeUseParentBlocks(obj) {
        if ($(obj).is(":checked")) {
            $(".none_blocks").removeAttr("checked");
        }
    }

    function saveBlocks() {
        $("#blocks_index").ajaxSubmit({
            success: function (data) {
                window.opener.location.reload();
                self.close();
            }
        });

    }

    $(document).ready(function () {
        $("#blocks_index .table tbody").sortable();
    })
</script>