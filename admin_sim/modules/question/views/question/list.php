<?php  
global $toolbar;
$toolbar->setTitle(FSText :: _('Câu hỏi') );
// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
//$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png');
$toolbar->addButton('add',FSText :: _('Add'),'','add.png');
// $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png');
$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png');
$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
$filter_config  = array();
$fitler_config['search'] = 1;
$fitler_config['filter_count'] = 1;
$filter_categories = array();
$filter_categories['title'] = FSText::_('Nhóm câu hỏi');
$filter_categories['list'] = @$groups;
$filter_categories['field'] = 'name';
$fitler_config['filter'][] = $filter_categories;
$list_config = array();
$list_config[] = array('title'=>'Câu hỏi','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '20%','link'=>'','arr_params'=>array('size'=> 30), 'align'=>'left');
$list_config[] = array('title'=>'Nhóm câu hỏi','field'=>'group_id','ordering'=> 1, 'type'=>'edit_selectbox','col_width' => '25%','arr_params'=>array('arry_select'=>$groups,'field_value'=>'id','field_label'=>'name','size'=>10));
$list_config[] = array('title'=>'Ngày tạo','field'=>'date_created','ordering'=> 1, 'type'=>'timestamp', 'align'=>'right');
$list_config[] = array('title'=>'Fix cố định','field'=>'fixtest','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'fixtest'));
$list_config[] = array('title'=>'Quan trọng','field'=>'published','ordering'=> 1, 'type'=>'published');
$list_config[] = array('title'=>'Sửa','type'=>'edit');
//$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text', 'align'=>'right');
TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);