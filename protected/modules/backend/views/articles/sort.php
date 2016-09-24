<h1  class="title">Сортировка материалов в разделе</h1>        

<div class="sort">		
    <?php if ($models):?>
    <form method="POST">            
          <ul class="sort_this">            
            <?php foreach($models as $model):?>                
            <li><span class="glyphicon glyphicon-move"></span> 
                <input type="hidden" name="Sort[]" value="<?php echo $model->id?>"><?php echo $model->title?>
            </li>            
            <?php endforeach ?>            
        </ul>            
        <?php if (Admin::current()):?>                
            <?php echo CHtml::Link("← Назад", $BackUrl, array("class" => "btn btn-danger")); ?>
            <input type="submit" class="btn btn-primary" name="submit_save_sort" value="Сохранить порядок сортировки">
        <?php endif ?>           
    </form>        
    <?php endif ?>    
</div>

<script>
    $(document).ready(function () {
        $(".sort_this").sortable();
    })
</script>