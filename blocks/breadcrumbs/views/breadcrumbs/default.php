<?php
global $tmpl; 
$tmpl -> addScript('breadcrumbs','blocks/breadcrumbs/assets/js');
?>	
<?php if(isset($breadcrumbs)){?>
<!--Breadcrumb-->
<nav class="container breadcrumb breadcrumb-link" aria-label="breadcrumb">
    <?php if(isset($breadcrumbs) && !empty($breadcrumbs)){?>
            <a class="breadcrumb-item" itemprop="url" title="Trang chủ" rel="nofollow" href="<?php echo URL_ROOT;?>" itemprop="title"><?php echo FSText::_('Trang chủ'); ?></a>
            <?php for($i=0;$i<count($breadcrumbs);$i++){?>
                <?php if($i<count($breadcrumbs)-1){?>
                    <a class="breadcrumb-item" itemprop="url" href="<?php echo $breadcrumbs[$i][1];?>" title="<?php echo htmlspecialchars($breadcrumbs[$i][0]);?>" itemprop="title"><?php echo $breadcrumbs[$i][0];?></a>
                <?php }else{?>
                    <span class="breadcrumb-item <?php echo $i==count($breadcrumbs)-1 ? 'active' : ''?>" itemprop="url" href="<?php echo $breadcrumbs[$i][1];?>" title="<?php echo htmlspecialchars($breadcrumbs[$i][0]);?>" itemprop="title"><?php echo $breadcrumbs[$i][0];?></span>
                <?php }?>
            <?php }?>
        </ol>
    <?php }?>
</nav>
<?php }?>
