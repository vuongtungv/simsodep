//<![CDATA[
$(window).on('load', function() { // makes sure the whole site is loaded
  $('.loader').fadeOut(); // will first fade out the loading animation
  $('.preloader').delay(30).fadeOut('slow'); // will fade out the white DIV that covers the website.
  $('body').delay(30).css({
    'overflow': 'visible'
  });
})
//]]>

var is_rewrite = 1;
var root = '/';
(function() {
  if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
    var msViewportStyle = document.createElement("style");
    msViewportStyle.appendChild(
      document.createTextNode(
        "@-ms-viewport{width:auto!important}"
      )
    );
    document.getElementsByTagName("head")[0].
    appendChild(msViewportStyle);
  }
})();

function changeCaptcha() {
  var date = new Date();
  var captcha_time = date.getTime();
  $("#imgCaptcha").attr({
    src: '/libraries/jquery/ajax_captcha/create_image.php?' + captcha_time
  });
}

function openNav() {
  document.getElementById("mySidenav").style.width = "280px";
  //document.getElementById("page").style.marginRight = "280px";
  //ocument.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  //document.getElementById("page").style.marginRight= "0";
  //document.body.style.backgroundColor = "white";
}

function myTimer() {
  //$('.alert').remove();
  location.reload();
}

function close(name_lable, type) {
  $('.alert').remove();
  if (!name_lable)
    return false;
  $('<div class="alert ' + type + '"><span class="closebtn">×</span><strong>' + name_lable + '</strong></div>').insertAfter('#alert-error').animate({
    top: 130
  });

  var close = document.getElementsByClassName("closebtn");
  var i;

  for (i = 0; i < close.length; i++) {
    close[i].onclick = function() {
      var div = this.parentElement;
      div.style.opacity = "0";
      setTimeout(function() {
        div.style.display = "none";
      }, 600);
    }
  }

  $('.alert').delay(4000).fadeOut('slow');
}

function close_moda(name_lable, content ) {
  $('.alert_moda').remove();
  if (!name_lable)
    return false;
  var html = '';
  html += '<div class="modal fade alert_moda" id="' + name_lable + '" role="dialog">';
  html += '	<div class="modal-dialog">';
  html += '		<div class="modal-content">';
  html += '			<div class="modal-body">';
  html += '				<h4 class="modal-title">Thông báo</h4>';
  html += '				<button type="button" class="close23" data-dismiss="modal"><i class="fa fa-times"></i></button>';
  html += '       <div class="row-item content-info">' + content + '</div>';
  html += '				<div class="row-item bt-content" >';
  html += '						<a class="bt-modal bt-cancel" data-toggle="modal" data-target="#' + name_lable + '" href="#">Cancel</a>';
  html += '						<a class="bt-modal bt-ok" data-toggle="modal" data-target="#' + name_lable + '" href="#" >OK</a>';
  html += '				</div>';
  html += '			</div>';
  html += '		</div>';
  html += '	</div>';
  html += '</div>';

  $(html).insertAfter('.scrollToTop');
  $('#' + name_lable).modal('show');
  //$('#'+name_lable).delay(10000).fadeOut('slow');
  //setInterval(remove_moda, 30000);
}

function alert_moda(name_lable, content ) {
  $('.alert_moda').remove();
  if (!name_lable)
    return false;
  var html = '';
  html += '<div class="modal fade alert_moda" id="' + name_lable + '" role="dialog">';
  html += '	<div class="modal-dialog">';
  html += '		<div class="modal-content" style="background:#ffffff !important" >';
  html += '			<div class="modal-body" style="text-align: center;">';
  html += '				<div class="loader"></div>';
  html += '       <div class="row-item content-info">' + content + '</div>';
  html += '			</div>';
  html += '		</div>';
  html += '	</div>';
  html += '</div>';

  $(html).insertAfter('.scrollToTop');
  $('#' + name_lable).modal('show');
}

function info_moda(name_lable, content , error) {
  $('.alert_moda').remove();
  if (!name_lable)
    return false;
  var html = '';
  html += '<div class="modal fade alert_moda" id="' + name_lable + '" role="dialog">';
  html += '	<div class="modal-dialog">';
  html += '		<div class="modal-content" style="background:#ffffff !important" >';
  html += '			<div class="modal-body" style="text-align: center;">';
  if (error == 1) {
    html += '				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2"><circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/><polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/></svg>';
  } else {
    html += '       <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2"><circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/><line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/><line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/></svg>';
  }
  html += '       <div class="row-item content-info">' + content + '</div>';
  html += '				<div class="row-item bt-content" >';
  html += '						<a class="bt-modal bt-ok" data-toggle="modal" data-target="#' + name_lable + '" href="#" >OK</a>';
  html += '				</div>';
  html += '			</div>';
  html += '		</div>';
  html += '	</div>';
  html += '</div>';

  $(html).insertAfter('.scrollToTop');
  $('#' + name_lable).modal('show');
}

function remove_moda() {
  $('.alert_moda').remove();
}

$(document).ready(function() {
    $('nav#menu').mmenu({
        extensions  : [ 'theme-dark', 'pageshadow' ],
        counters    : true,
        navbar      : {
            title       : ''
        },
        navbars     : [
            {
                position    : 'top',
                content     : [
                    'prev',
                    'title',
                    'close'
                ]
            }
        ]
    });
    // end menu

  $('#mm-blocker').on('click', function() {
    var menu = $('#menu');
    menu.addClass('hide').hide();
  });
  // menu- responsive
  $('#search-mobile').on('click', function() {
    var menu = $(this);
    if (menu.hasClass('open')) {
      menu.removeClass('open');
      $('#search_form').removeClass('open').slideUp(200);
    } else {
      menu.addClass('open');
      $('#search_form').addClass('open').slideDown(200);
    }
  });

  $(window).scroll(function() {
    if (window.innerWidth < 767) {
      $(".group-modal").css("display", "none").fadeIn("10000");
    }
    if ($(this).scrollTop() > 300) {
      $('.scrollToTop').fadeIn().addClass('active');
      //$('.group-modal').fadeIn().addClass('active');
    } else {
      $('.scrollToTop').fadeOut().removeClass('active');
      //$('.group-modal').fadeOut().removeClass('active');
    }
  });

  //Click event to scroll to top
  $('.scrollToTop').click(function() {
    $('html, body').animate({
      scrollTop: 0
    }, 800);
    return false;
  });

  $('#nav_tab a').click(function() {
    var id = $(this).data('id');
    $('#groupModal .tab-pane').hide();
    $('#tab-pane-' + id).show();
  });


});

function OpenPrint() {
  u = location.href;
  window.open(u + "?print=1");
  return false;
}

$(function(){
    $('#sl-link').on('change', function() {  
      var url = this.value;              // or whatever
        window.open(url, '_blank');  
    });
});

Number.prototype.formatMoney = function(c, d, t) {
  var n = this,
    c = isNaN(c = Math.abs(c)) ? 2 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
    j = (j = i.length) > 3 ? j % 3 : 0;
  return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};
