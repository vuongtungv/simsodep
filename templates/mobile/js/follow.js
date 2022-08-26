function follow_member(member_id) {
    $.ajax({
        url: root + "index.php?module=users&task=ajax_add_member_follow&raw=1",
        data: {
            member_id: member_id
        },
        dataType: "text",
        success: function(result) {
            if (result == 0) {
                return;
            } else if (result == '1') {
                $('.follow_member_' + member_id).removeClass('follow').addClass('unfollow').html('x Bỏ theo dõi');
            } else if (result == '-1') {
                $('.follow_member_' + member_id).removeClass('unfollow').addClass('follow').html('+ Theo dõi');
            } else if (result == '-3') {
                alert('Bạn chưa đăng nhập');
            }
        }
    });
}

function follow_manufactory(manufactory_id) {
    $.ajax({
        url: root + "index.php?module=users&task=ajax_add_manufactory_follow&raw=1",
        data: {
            manufactory_id: manufactory_id
        },
        dataType: "text",
        success: function(result) {
            if (result == 0) {
                return;
            } else if (result == '1') {
                $('.follow_manufactory_' + manufactory_id).removeClass('follow').addClass('unfollow').html('x Bỏ theo dõi');
            } else if (result == '-1') {
                $('.follow_manufactory_' + manufactory_id).removeClass('unfollow').addClass('follow').html('+ Theo dõi');
            } else if (result == '-3') {
                alert('Bạn chưa đăng nhập');
            }
        }
    });
}
/*
 * Dùng cho trang danh sách
 */
function like_product(product_id) {
    $.ajax({
        url: root + "index.php?module=products&view=product&task=ajax_add_like&raw=1",
        data: {
            product_id: product_id
        },
        dataType: "text",
        success: function(result) {
            if (result == 0) {
                return;
            } else if (result == '1') {
                $(this).html('Thích tin đăng này');
            } else if (result == '2') {
                $(this).html('Bỏ thích tin đăng này');
            } else if (result == '3') {
                alert('Bạn chưa đăng nhập');
            }
        }
    });
}
/*
 * Dùng cho trang chi tiết
 */
function like_product_detail(product_id) {
    $.ajax({
        url: root + "index.php?module=products&view=product&task=ajax_add_like&raw=1",
        data: {
            product_id: product_id
        },
        dataType: "text",
        success: function(result) {
            if (result == '-3') {
                alert('Bạn chưa đăng nhập');
            } else {
                // $('.like_product_detail_'+product_id).html(result);
                if ($('.like_product_detail_' + product_id).hasClass('like_ok')) {
                    $('.like_product_detail_' + product_id).removeClass('like_ok').addClass('like_no');
                    $('.like_product_detail_' + product_id).html('Thích sản phẩm');
                } else {
                    $('.like_product_detail_' + product_id).removeClass('like_no').addClass('like_ok');
                    $('.like_product_detail_' + product_id).html('Bỏ thích sản phẩm');
                }
            }

        }
    });
}
