
<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
    $toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png',1); 
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png',1); 
	$toolbar->addButton('save',FSText::_('Save'),'','save.png',1); 
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');  
    
    echo ' 	<div class="alert alert-danger" style="display:none" >
                    <span id="msg_error"></span>
            </div>'; 
	
    $this -> dt_form_begin();
    	TemplateHelper::dt_edit_text(FSText :: _('Tên nhà mạng'),'name',@$data -> name);
    	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
        TemplateHelper::dt_edit_text(FSText :: _('Danh sách đầu số mới'),'head_new',@$data ->head_new,'',60,1,0,FSText::_("Các đầu số viết liền và cách nhau bằng dấu phẩy"));
        TemplateHelper::dt_edit_text(FSText :: _('Danh sách đầu số cũ'),'head_old',@$data ->head_old,'',60,1,0,FSText::_("Các đầu số viết liền và cách nhau bằng dấu phẩy"));
        TemplateHelper::dt_edit_text(FSText :: _('Tất cả đầu số'),'header',@$data ->header,'',60,1,0,FSText::_("Các đầu số viết liền và cách nhau bằng dấu phẩy"));
    	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
    $this -> dt_form_end(@$data,1,0); 
    	
?>
<script type="text/javascript">
    function formValidator()
    {
        return true;
    }
 
</script>

