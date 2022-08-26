<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<!-- FOR TAB -->	
	<?php
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   
	
	$this -> dt_form_begin(1,4,$title.' '.FSText::_('Danh sách bảo trì'));
	?>
        <ul class="nav nav-tabs">
            <li class="active"><a href="#fragment-1" data-toggle="tab" aria-expanded="true"><?php echo FSText::_('Trường cơ bản cơ bản'); ?></a>
            </li>
            <li class=""><a href="#fragment-2" data-toggle="tab" aria-expanded="false"><?php echo FSText::_('Ảnh'); ?></a>
            </li>
        </ul>
        <div class="tab-content panel-body">
            <div class="tab-pane active" id="fragment-1">
                
                <?php include_once 'detail_base.php';?>            
            </div>
            <div class="tab-pane fade" id="fragment-2">
                <?php  //include_once 'detail_images.php';?>
                <?php TemplateHelper::dt_edit_image2(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),'','','',1); ?>            
            </div>
        </div>
<?php 
$this -> dt_form_end(@$data,1);
?>
<!-- HEAD -->

