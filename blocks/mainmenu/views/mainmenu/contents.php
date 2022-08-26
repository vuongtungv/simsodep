<?php
    global $tmpl;
    $Itemid = 2;
    $tmpl -> addStylesheet('menu','blocks/mainmenu/assets/css');
    $tmpl -> addScript('_script','blocks/mainmenu/assets/js');
?>

<?php $i=0;
    $link = '';
    foreach($list as $item){
    if($item ->link){
        $link = $item->is_link == 1? $item ->link:FSRoute::_($item ->link.'&Itemid='.$item -> id);
    }    
 ?>
 <div class="item-faq">
    <button class="accordion-faq">
        <p><a class="" href="<?php echo $link; ?>"><?php echo $item->name; ?></a></p>
    </button>
    <div class="panel-faq">
      <?php echo html_entity_decode($item->summary); ?>
    </div>
 </div>   
<?php $i++; } ?>