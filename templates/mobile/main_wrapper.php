<?php if($tmpl->count_block('top')) {?>
    <div class="row-content pos-top">
            <?php  echo $tmpl -> load_position('top','XHTML2'); ?>
    </div> <!-- END: .pos-top -->
    <div class="clearfix"></div>
<?php } ?>

<div class="main-content row-item container">
    <div class="row">
        <?php if($tmpl->count_block('right')){ ?>
                <div class="main-column-content col-xs-12 col-md-9 col-lg-9">
                    <?php if($tmpl->count_block('pos_contents_top')) {?>
                        <div class="row-content pos_contents_top">
                            <?php  echo $tmpl -> load_position('pos_contents_top','XHTML2'); ?>
                        </div> <!-- END: .pos_contents_top -->
                    <?php } ?>

                    <?php  echo $main_content; ?>

                    <?php if($tmpl->count_block('pos_contents_bottom')) {?>
                        <div class="row-content pos_contents_bottom">
                            <?php  echo $tmpl -> load_position('pos_contents_bottom','XHTML2'); ?>
                        </div> <!-- END: .pos_contents_bottom -->
                    <?php } ?>
                </div>
                <div class="main-column-right col-xs-12 col-md-3 col-lg-3">
                    <?php  echo $tmpl -> load_position('right','XHTML2'); ?>
                </div>
        <?php } else{ ?>
            <div class="main-column col-xs-12">
                <?php if($tmpl->count_block('pos_contents_top')) {?>
                    <div class="row-content pos_contents_top">
                        <?php  echo $tmpl -> load_position('pos_contents_top','XHTML2'); ?>
                    </div> <!-- END: .pos_contents_top -->
                <?php } ?>

                <?php  echo $main_content; ?>

                <?php if($tmpl->count_block('pos_contents_bottom')) {?>
                    <div class="row-content pos_contents_bottom">
                        <?php  echo $tmpl -> load_position('pos_contents_bottom','XHTML2'); ?>
                    </div> <!-- END: .pos_contents_bottom -->

                <?php } ?>
            </div><!-- END: .main-column -->
        <?php } ?>
  </div>
</div><!-- END: main-content -->

<?php if($tmpl->count_block('bottom')) { ?>
    <div class="clearfix"></div>
    <div class="pos-bottom row-content">
        <div class="container">
            <?php  echo $tmpl -> load_position('bottom','XHTML2'); ?>
        </div>
    </div><!--END: .pos-bottom -->
<?php } ?>
