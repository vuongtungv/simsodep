<?php
global $config,$tmpl;
//    $tmpl -> addStylesheet('menu','blocks/mainmenu/assets/css');
?>
<?php
$Itemid = 30;
$root_total = 0;
$root_last = 0;
$max_word = 5;
for($i = 1 ; $i <= count($list); $i++)
{
    if(@$list[$i]->level == 1)
    {
        $root_total ++ ;
        $root_last = $i;

    }
}
//testVar($list);
?>

<ul class="">
    <?php
    $html = "";
    $i = 1;
    $num_child = array();
    $parant_close = 0;
    foreach ($list as $item) {?>
        <?php ?>
        <?php
        $link = $item->link? FSRoute::_($item->link):'';
        $class = '';
        $level = $item -> level?$item -> level : 0;
        $class .= ' level'.$level;
        $class_item = '';
        if($arr_activated[$item->id]) $class_item = ' activated ';
        // level = 1
        if($item->level==0)
        {
            if($i == 1)
                $class .= ' first-item';
            if($i == ($root_last-1) )
                $class .= ' last-item';
            if(($i != 1) && ($i != ($root_last-1)))
                $class .= ' menu-item';
        }

        // level > 1
        else
        {
            $parent = $item->parent_id;
            // total children
            $total_children_of_parent = isset($list[$parent])?$list[$parent]->children:0;
            if(isset($num_child[$parent]))
            {
                if($total_children_of_parent == $num_child[$parent])
                {
                    $class .= " first-sitem ";
                }
                else
                {
                    $class .= " mid-sitem ";
                }
            }
        }

        $html .= "<li class=' $class $class_item' >\n";
        if($item -> link)
            $html .= "	<a target='".$item->target."' href='$link'>";
        else
            $html .= "	<a target='".$item->target."' href='$link'>";

        $name   = $item -> name;
        $html .= "		$name ";
        if($item -> link)
            $html .= "	</a>\n";
        else
            $html .= "	</a>";

        // browse child
        $num_child[$item->id] = $item->children ;
        if($item->children  > 0)
            $html .= "		<ul>";

        if(@$num_child[$item->parent_id] == 1)
        {
            // if item has children => close in children last, don't close this item
            if($item->children > 0)
            {
                $parant_close ++;
            }
            else
            {
                $parant_close ++;
                for($i = 0 ; $i < $parant_close; $i++)
                {
                    $html .= "	</li>";
                    $html .= "</ul>";
                }
                $parant_close = 0;
                $num_child[$item->parent_id]--;
            }
        }
        if(( (@$num_child[$item->parent_id] == 0) && (@$item->parent_id >0 ) ) || !$item->children )
        {
            $html .= "</li>";
        }
        if(@$num_child[$item->parent_id] >= 1)
            $num_child[$item->parent_id]--;

        $i ++;
    }
    echo $html;
    ?>
    <div class="clear"></div>

</ul>

