<?php
    global $tmpl;
    $Itemid = FSInput::get('Itemid',16,'int');
    $tmpl -> addStylesheet('default','blocks/faq/assets/css');
    $tmpl -> addScript('script','blocks/faq/assets/js');
    $total = count($list);
?>
<?php 
    $text_default = FSText::_('Nhập từ khóa tìm kiếm...');
    $keyword = $text_default;
    $module = FSInput::get('module');
    if($module == 'faq'){
    	$key = FSInput::get('keyword');
    	if($key){
    		$keyword = $key;
    	}
    }
?>
<div class='container'>
<?php 
    if($Itemid == 15){
        $link = FSRoute::_('index.php?module=faq&view=search');
    }else{
        $link = FSRoute::_('index.php?module=faq&view=search_employer');
    }
?>
<form action="#" name="search_form" class="form search_faq" id="menu_search_faq" >
	<input  id="keyword_faq" name="keyword" class="keyword"  type="text" value="<?php echo $keyword; ?>" onblur="if(this.value=='') this.value='<?php echo $text_default; ?>'" onfocus="if(this.value=='<?php echo $text_default; ?>') this.value=''" />
	<a class="button" href="javascript: void(0)" id='submitbt_faq'>
		<?php echo FSText::_('Tìm kiếm'); ?>
	</a>
	<input type='hidden'  name="module" id='link_search_faq' value="<?php echo FSRoute::_('index.php?module=faq&view=search'); ?>" />
    <input type="hidden" name="module" value="faq"/>
    <?php if($Itemid == 15){?>
        <input type="hidden" name="view" value="search"/>
    <?php }else{?>
        <input type="hidden" name="view" value="search_employer"/>
    <?php }?>
	<input type="hidden" name="view" value="search"/>
</form>
</div>