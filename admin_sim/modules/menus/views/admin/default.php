<?php 
include_once '../libraries/tree/tree.php';
$list = Tree::indentRows($list);
$root_total = 0;
$root_last = 0;
$url = $_SERVER['REQUEST_URI'];
foreach ($list as $item){
	if(!@$item->parent_id){
		$root_total ++ ;
		$root_last = $item->id;
	}
}
?>
<ul id="side-menu" class="page-sidebar-menu  <?php if(isset($_SESSION['sidebar'])) echo ' page-sidebar-menu-closed '?>" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
    <?php
    $num_child = array();
    $parant_close = 0;
    foreach ($list as $item){
        $new = '';
        if ($item->table) {
            $new = $model->get_count('status = "'.$item->status.'"',$item->table);
        }
        $class = '';
        $collapse = '';
        $icon = '';
        if($item->link){
            $link = trim($item->link);
            if(strpos($url,$link) !== false)
                $class .= ' actives ';
        }else{
            $link = "javascript:void(0)";
            $collapse =  '<span class="fa arrow"></span>';
        }
        if($item->icon){
            $icon = '<i class="'.$item->icon.'"></i> ';
        }
        $has_child = '';
        if($item->children > 0)
            $has_child = ' has-child';
        if(!$item->parent_id){
        ?>
            <li class="nav-item  ">
                <a href="<?php echo $link; ?>" class="header nav-link nav-toggle <?php echo $class;?>">
                    <?php echo $icon; ?>
                    <?php echo FSText::_(trim($item->name)); ?> <?php echo @$new?'('.@$new.')':'' ?> 
                    <span class="arrow"></span>
                </a>
            
        <?php }else{ ?>
            <li class="nav-item  ">
                <a href="<?php echo $link; ?>" class="nav-link nav-toggle <?php echo $class;?>">
                    <?php echo $icon; ?>
                    <?php echo FSText::_(trim($item->name)); ?> <?php echo @$new?'('.@$new.')':'' ?> 
                    <?php echo $collapse; ?>
                </a>
                        
        <?php } ?>
        <?php 
        $num_child[$item->id] = $item->children ;
        if($item->children  > 0)
            echo "<ul class='sub-menu'  >";
        if(@$num_child[$item->parent_id] == 1){
            if($item->children > 0){
                $parant_close ++;
            }else{
                $parant_close ++;
                for($i = 0 ; $i < $parant_close; $i++){
                    echo "</ul>";
                }
                $parant_close = 0;
                $num_child[$item->parent_id]--;
            }
            if(@$num_child[$item->parent_id] >= 1) 
                $num_child[$item->parent_id]--;
        }   
        if(isset($num_child[$item->parent_id] ) && ($num_child[$item->parent_id] == 1) )
            echo "</ul>";
        if(isset($num_child[$item->parent_id]) && ($num_child[$item->parent_id] >= 1) )
            $num_child[$item->parent_id]--;
        echo '</li>';
    }
    ?>
</ul>


<script>
$( document ).ready(function() {
    $('#side-menu a.actives').parent('li').addClass('active open');
    $('#side-menu a.actives').parent('li').parent('ul').parent('li').addClass('active open');
    $('#side-menu li.active span.arrow').addClass('open');
});
</script>
