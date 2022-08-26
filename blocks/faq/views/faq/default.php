<?php
    global $tmpl;
    $Itemid = FSInput::get('Itemid',16,'int');
    $tmpl -> addStylesheet('default','blocks/faq/assets/css');
    $total = count($list);
?>
<?php if($total){ ?>
<div id="faq-hits">
    <h2 class="block_title"> <a title="Câu hỏi Xem nhiều nhất"><?php echo FSText::_('Câu hỏi Xem nhiều nhất'); ?></a></h2>
    <?php $i=0;
        foreach($list as $item){
        if($Itemid == 15){
            $link = FSRoute::_('index.php?module=faq&view=faq&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id);
        }else{
            $link = FSRoute::_('index.php?module=faq&view=faq_employer&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id);
        }
    ?>
    <div class="item-faq">
        <h3 class="relate_content">  
            <a class="accordion-faq" title="<?php echo $item->title; ?>" href="<?php echo $link;?>" ><?php echo $item->title; ?></a>
        </h3>
    </div>   
    <?php $i++; } ?>
</div>
<?php } ?>