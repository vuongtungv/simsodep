<?php  	
    global $tmpl,$config;
//    $tmpl -> addStylesheet('detail','modules/news/assets/css');
    $tmpl -> addStylesheet('tintuc','modules/news/assets/css');
?>

<!--Detail news-->
<div class="container detail-news">
    <div class="body-news">
        <h1 class="title-news">Sim phong thủy</h1>
        <div class="content contentpt">
            <?php echo html_entity_decode($config['phongthuy']) ?>
        </div>
    </div>
</div>

