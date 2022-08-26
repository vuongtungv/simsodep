/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    
    $('#search_user').click(function(){
        if (checkFormsubmit())
            document.search_user.submit();
    })
    
    //cập nhật người đại diện Head
    $('#submitbt_up_delegate').click(function(){
        if (checkFormsubmit_up_delegate())
            document.upinfo_form_user.submit();
    });

      $('.btn_excel').click(function () {
    
        // document.show_list_user.submit();
        window.location.href = '/index.php?module=users&view=users&task=export_list_user&raw=1';

    })
    
    
});
function checkFormsubmit()
{

    $('label.label_error').prev().remove();
    $('label.label_error').remove();
    email_new = $('#email_new').val();
    if (!notEmpty2("keyword", "Nhập Từ Khóa", "Bạn chưa nhập từ khóa"))
    {
        return false;
    }
    
    return true;
}
function checkFormsubmit_up_delegate()
{
    $('label.label_error').prev().remove();
    $('label.label_error').remove();
    email_new = $('#email_new').val();
     if (!notEmpty2("delegate_name", "Nhập tên người đại diện", "Bạn chưa nhập tên người đại diện"))
    {
        return false;
    }
 
     if (!notEmpty2("delegate_phone", "Nhập số điện thoại  người đại diện", "Bạn chưa nhập số điện thoại"))
    {
        return false;
    }
    if (!isPhone("delegate_phone", "Bạn nhập số điện thoại không hợp lệ"))
        return false;
    
         if (!notEmpty2("delegate_email", "Nhập email  người đại diện", "Bạn chưa nhập email"))
    {
        return false;
    }
     if (!emailValidator("delegate_email", "Email nhập không hợp lệ")) {
        return false;
    }
               //không chứa ký tự đặc biệt
    re = /[~`!#$%\^&*+=[\]\\';,/{}|\\":<>\?]/;
    if (re.test($("#delegate_name").val())) {
        $("#check_validate").text('Trường này chỉ cho phép nhập các ký tự từ 0-9 và A-Z.');
        $('#delegate_name').focus();
        return false;
    } else {
        $("#check_validate").text('');
          return true;
    }
    return true;
}
