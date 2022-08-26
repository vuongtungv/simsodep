<?php  	
    global $tmpl,$config;
   $tmpl -> addStylesheet('detail_mobile','modules/news/assets/css');
?>

<!--Detail news-->
<div class="detail-news">
    <div class="body-news">
        <h1 class="title-news">Sim phong thủy</h1>
        <div class="content contentpt">
            <?php echo html_entity_decode($config['phongthuy']) ?>
        </div>
    </div>
</div>

