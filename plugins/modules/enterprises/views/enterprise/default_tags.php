<!--	TAGS		-->
<?php 
if($category -> display_tags){
	if($data -> tags){
		$arr_tags = explode(',',$data -> tags);
		$total_tags = count($arr_tags);
		if($total_tags){
			echo '<div class="news_tags">';
			echo '<h3 class="tags_title flever_12">'.FSText::_('Tags').': </h3>';
			echo '<div class="content_tags">';
			for($i = 0; $i < $total_tags; $i ++){
				$item = trim($arr_tags[$i]);
				if($item){
					if($i > 0)
						echo '<font>, </font>';
					$link = FSRoute::_("index.php?module=news&view=search&keyword=".str_replace(' ','+',$item)."&Itemid=9");
					echo '<h2 class="tag flever_12"><a href="'.$link.'" title="'.$item .'">'.$item.'</a></h2>';
				}
			}
			echo "<div class='clear'></div>";
			echo '</div>';
			echo '</div>';
			echo "<div class='clear'></div>";
		}
	}
}
?>
<!--	end TAGS		-->	