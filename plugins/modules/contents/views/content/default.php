<?php  	
    global $tmpl;
    $tmpl -> addStylesheet('detail','modules/contents/assets/css');
?>
<div class="contents row-content pal col-item mbsi">
	<h1 class="pbl mbm">
		<?php	echo $data -> title; ?>
	</h1>
    <div class="summary row-item">
        <?php	echo $data -> summary; ?>
    </div>
	<div class='description row-item mbm'>
		<?php   echo $data -> content; ?>
	</div>
    <div class="news-detail-share row-item mbm">
        <span class="fl-left news-sours">Nguồn: <?php   echo $data -> source; ?></span>
    </div>
</div><!-- END: .contents -->

