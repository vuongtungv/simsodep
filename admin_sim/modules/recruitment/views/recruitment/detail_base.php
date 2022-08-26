<table cellspacing="1" class="admintable">
<?php 
	TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> title);
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
    TemplateHelper::dt_edit_text(FSText :: _('Nguồn tin'),'source',@$data -> source);
	TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 1,0);
	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',URL_ROOT.str_replace('/original/','/resized/',@$data->image));
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	//TemplateHelper::dt_checkbox(FSText::_('Show in homepage'),'show_in_homepage',@$data -> show_in_homepage,0);
//	TemplateHelper::dt_checkbox(FSText::_('Tin nhanh'),'news_fast',@$data -> news_fast,1);
//	TemplateHelper::dt_checkbox(FSText::_('Tin tiêu điểm'),'news_focus',@$data -> news_focus,1);
//	TemplateHelper::dt_checkbox(FSText::_('Tin slideshow'),'news_slide',@$data -> news_slide,1);

	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	//TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9);
	TemplateHelper::dt_edit_text(FSText :: _('Content'),'content',@$data -> content,'',650,450,1);
//	TemplateHelper::dt_edit_text(FSText :: _('Tags'),'tags',@$data -> tags,'',100,4);
?>
</table>