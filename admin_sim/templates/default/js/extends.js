$(document).ready(function () {
    // if($("#body-sidebar").hasClass("page-sidebar-closed")){
    //     $('.show-hidden-sidebar').html('<?php $_SESSION[\'sidebar\'] = 1?>');
    // }else {
    //     $('.show-hidden-sidebar').html('<?php $_SESSION[\'sidebar\'] = 0?>');
    // }


    $(".menu-toggler.sidebar-toggler").click(function() {
        $.ajax({
            type: 'POST',
            url: 'index.php?module=home&view=home&task=sidebar_tag&raw=1',
            success: function (data) {

            }
        });
    });
});
