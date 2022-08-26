<?php $text_default = FSText::_('Tìm kiếm...')?>
<?php 
    $keyword = $text_default;
    $module = FSInput::get('module');
    if($module == 'news'){
    	$key = FSInput::get('keyword');
    	if($key){
    		$keyword = $key;
    	}
    }
?>

<?php $link = FSRoute::_('index.php?module=news&view=search');?>
<form action="<?php echo $link; ?>" name="search_form" class="form search_news" id="menu_search_news" >
	<input  id="keyword_news" name="keyword" class="keyword"  type="text" value="<?php echo $keyword; ?>" onblur="if(this.value=='') this.value='<?php echo $text_default; ?>'" onfocus="if(this.value=='<?php echo $text_default; ?>') this.value=''" />
	<a class="button" href="javascript: void(0)" id='submitbt_news'>
		<?php echo FSText::_('Tìm kiếm'); ?>
	</a>
	<input type='hidden'  name="module" id='link_search_news' value="<?php echo FSRoute::_('index.php?module=news&view=search'); ?>" />
    <input type="hidden" name="module" value="news"/>
	<input type="hidden" name="view" value="search"/>
</form>