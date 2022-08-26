<?php 
    global $tmpl,$config;
    $tmpl -> addStylesheet('notfound','modules/notfound/assets/css');
?>

<!--	--><?php //echo $config['info_404']; ?>
    <!--Beadcrumb-->
<!--    <nav aria-label="breadcrumb" class="container breadcrumb breadcrumb-link">-->
<!--        <a class="breadcrumb-item" href="http://localhost:8892/" itemprop="url" rel="nofollow" title="Trang chủ">Trang chủ</a>-->
<!--        <span class="breadcrumb-item active" href="" itemprop="url" title="404_Error">404 Error</span>-->
<!--    </nav>-->
  
    <div class="container error-home">
        <img src="/templates/default/images/img_svg/404/404.svg" alt="">
        <div class="box-alert">
            <div class="left">
                <p><span>Oops...</span> Trang này không tồn tại</p>
                <p>Xin lỗi quý khách vì sự bất tiện này!</p>
            </div>
            <div class="right">
                <p><a href="javascript:history.back()"><img src="/templates/default/images/img_svg/404/back.svg" alt=""> Quay lại trang trước</a></p>
                <button><a class="btn btn-primary" href="<?php echo URL_ROOT?>">Về trang chủ</a></button>
            </div>
        </div>
    </div>