<?php
    global $config,$tmpl; 
    $tmpl -> addStylesheet('menu','blocks/mainmenu/assets/css');
    $url_current = $_SERVER['REQUEST_URI'];
    $url_current = substr(URL_ROOT, 0, strlen(URL_ROOT)-1).$url_current;
?>
<select class="sl-link form-control" onchange="if (this.value) window.open(this.value)">
	<!--	CONTENT -->
	<option><?php echo FSText::_('-- Honda Việt Nam --'); ?></option>
 	<?php 
	 	$Itemid  = FSInput::get('Itemid',1,'int'); 
	 	$total = count($list); 
	 	$i = 0;
	 	$count_children = 0;
	 	$summner_children = 0;
	 	foreach ( $list as $item ) { 
	 		    $class =  $item ->link ==  $url_current ? 'selected="selected"':'';
	 			$count_children ++;
	 			$link = $item ->link? FSRoute::_($item ->link):$item ->link;
	 			echo "<option value=".$link." $class >".$item -> name."</option>";

	 		$i ++;
	 	}
	 ?>  
</select>
	