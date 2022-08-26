<?php

/*
 * Huy write
 */

// controller
class UsersControllersEmail {

    var $module;
    var $view;

    function __construct() {

        $this->module = 'members';
        $this->view = 'email';
    }

    function sendMailForget($user_check, $activated_code) {
     
        // send Mail()
        // $mailer = FSFactory::getClass('Email','mail/');
        $global = new FsGlobal();
        $admin_name = $global->getConfig('admin_name');
        $admin_email = $global->getConfig('admin_email');
        $mail_register_subject = FSText::_("Khôi phục mật khẩu");
        $mail_forget_body = $global->getConfig('mail_forget_seekers');
        global $config;



        $url_forget = FSRoute::_('index.php?module=users&task=update_forgot_pass&data='.$user_check->id);

        // body
        $body = $mail_forget_body;
        $body = str_replace('{email}', $user_check->name, $body);
        $body = str_replace('{activated_code}', $activated_code, $body);
        $body = str_replace('{url_forget}', $url_forget, $body);
        // $body = 'Mật khẩu mới là: '.$resetPass;
       // $body = str_replace('{url_forget}', '<a href="' . $url_forget . '">' . FSText::_('Click vào đây') . '</a>', $body);
       //  $body .= 'Mã bảo mật của bạn là: '.$activated_code;
       // $body .='. Click vào đây để chuyển qua bước theo!';
       // $body .='<a href="' . $url_forget . '">' . FSText::_('Click vào đây') . '</a>';
       
        // $mailer -> setBody($body);
        // if(!$mailer ->Send())
        // 	return false;

        $this->send_email1($mail_register_subject, $body, $user_check->name, $user_check->email, '', 0);
        return true;
    }
      function send_email1($title, $content, $nTo, $mTo,$diachicc='',$is_mail = 0){
            //global $email_info;

            $global_class = FSFactory::getClass('FsGlobal');

            $admin_name = $global_class->getConfig('admin_name');
            $admin_email = $global_class->getConfig('admin_email');

            $nFrom = $admin_name;

             $server = 'smtp.gmail.com';
            $mFrom = 'Daotaoxemayhonda@gmail.com';
            $mPass = 'Honda123!@#';
                   
            FSFactory::include_class('class.smtp','mailserver');
            $mail = FSFactory::getClass('PHPMailer','mailserver');

            $body = $content;

            $mail->IsSMTP();
            //Tắt mở kiểm tra lỗi trả về, chấp nhận các giá trị 0 1 2
            // 0 = off không thông báo bất kì gì, tốt nhất nên dùng khi đã hoàn thành.
            // 1 = Thông báo lỗi ở client
            // 2 = Thông báo lỗi cả client và lỗi ở server
            $mail->SMTPDebug= 0; // enables SMTP debug information (for testing)
            $mail->Debugoutput = "html"; // Lỗi trả về hiển thị với cấu trúc HTML
            $mail->CharSet= "utf-8";

            $mail->SMTPAuth= true; // enable SMTP authentication
            $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
            $mail->Host= $server; //$email_info['Host'];
            $mail->Port= '465'; //$email_info['Port'];

            $mail->Username= $mFrom;// GMAIL username
            $mail->Password= $mPass;// GMAIL password

            $mail->SetFrom($mFrom, $nFrom);
            //chuyen chuoi thanh mang
            $ccmail = explode(',', $diachicc);
            $ccmail = array_filter($ccmail);

            if(!empty($ccmail)){
                foreach ($ccmail as $k => $v) {
                    $mail->addBCC($v);
                }
            }

            if($is_mail)
                $mail->addCC($admin_email,$admin_name);

            $mail->Subject = $title;
            $mail->MsgHTML($body);
            //$mail->MsgHTML(file_get_contents('email-template.html'), dirname(__FILE__));

            $address = $mTo;

            $mail->AddAddress($address, $nTo);
            $mail->AddReplyTo($admin_email, $admin_name);

            if(!$mail->Send()){
                return false;
                //echo $random;
//                echo "có lỗi khi gửi email: " . $mail->ErrorInfo;
//                die;
            }
            return true;
        }
    function send_email1_($title, $content, $nTo, $mTo,$diachicc='ngoquangtb@gmail.com',$is_mail = 0){
            //global $email_info;
      
            $global_class = FSFactory::getClass('FsGlobal');
//            $admin_name = $global_class->getConfig('admin_name');
//            $admin_email = $global_class->getConfig('admin_email');
           

             $smtpHost = 'smtp.gmail.com';
    $smtpPort = '465';
    $smtpEmail = 'mail.finalstyle@gmail.com';
    $smtpPass = 'fs123456';
    
     $nFrom = $admin_name;
            //$mFrom = 'info@ketnoigiaoduc.vn'; //$email_info['mFrom'];//dia chi email cua ban
            //$mPass = 'lzsaw{JZnHDE'; // $email_info['mPass'];//mat khau email cua ban

            FSFactory::include_class('class.smtp','mailserver');
            $mail = FSFactory::getClass('PHPMailer','mailserver');

            $body = $content;

            $mail->IsSMTP();
            //Tắt mở kiểm tra lỗi trả về, chấp nhận các giá trị 0 1 2
            // 0 = off không thông báo bất kì gì, tốt nhất nên dùng khi đã hoàn thành.
            // 1 = Thông báo lỗi ở client
            // 2 = Thông báo lỗi cả client và lỗi ở server
            $mail->SMTPDebug= 0; // enables SMTP debug information (for testing)
            $mail->Debugoutput = "html"; // Lỗi trả về hiển thị với cấu trúc HTML
            $mail->CharSet= "utf-8";

            $mail->SMTPAuth= true; // enable SMTP authentication
            $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
            $mail->Host= $server; //$email_info['Host'];
            $mail->Port= '465'; //$email_info['Port'];

            $mail->Username= $mFrom;// GMAIL username
            $mail->Password= $mPass;// GMAIL password

            $mail->SetFrom($mFrom, $nFrom);
            //chuyen chuoi thanh mang
            $ccmail = explode(',', $diachicc);
            $ccmail = array_filter($ccmail);

            if(!empty($ccmail)){
                foreach ($ccmail as $k => $v) {
                    $mail->addBCC($v);
                }
            }

            if($is_mail)
                $mail->addCC($admin_email,$admin_name);

            $mail->Subject = $title;
            $mail->MsgHTML($body);
            //$mail->MsgHTML(file_get_contents('email-template.html'), dirname(__FILE__));

            $address = $mTo;

            $mail->AddAddress($address, $nTo);
            $mail->AddReplyTo($admin_email, $admin_name);

            if(!$mail->Send()){
                return false;
                //echo $random;
//                echo "có lỗi khi gửi email: " . $mail->ErrorInfo;
//                die;
            }
            return true;
        }

}

?>
