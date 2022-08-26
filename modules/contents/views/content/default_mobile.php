<?php
global $tmpl;
$tmpl -> addStylesheet('detail_mobile','modules/contents/assets/css');
//$tmpl -> addScript('form');
//$tmpl -> addScript('main');
//$tmpl -> addScript('detail','modules/contents/assets/js');
//FSFactory::include_class('fsstring');

//$print = FSInput::get('print',0);
?>
<div class="contents_detail">
    <h1 class="title-module">
        <a class="">
            <!--                <i class="fa fa-cogs"></i>-->
            <?php echo $data -> title; ?>
        </a>
    </h1>
    <summary class="contents-summary hide">
        <?php echo $data -> summary; ?>
    </summary><!-- END: .contents-detail-content -->
    <?php if($data->content){ ?>
        <div class='contents-description row-item'>
            <?php echo $data->content; ?>
        </div><!-- END: .contents-detail-content -->
    <?php } ?>

    <input type="hidden" value="<?php echo $data->id; ?>" name='contents_id' id='contents_id'  />
</div><!-- END: .contents_detail -->
<script src="https://apis.google.com/js/platform.js" async defer>{lang: 'vi'}</script>

<?php
    if(FSInput::get('code') =='thanh-toan'){

?>
        <style>
            .contents-description center{
                overflow-x: scroll;
            }
            .contents-description center tr:nth-child(2){
                width: 150px;
            }  
        </style>


<?php }?>
