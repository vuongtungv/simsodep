<?php
$module = FSInput::get('module');
$view = FSInput::get('view', 'groups');
$c = FSInput::get('c', $view);
$path = PATH_ADMINISTRATOR . DS . 'modules' . DS . 'menus' . DS . 'controllers' .
    DS . 'notifications' . ".php";
if (!file_exists($path))
    echo FSText::_("Not found controller");
else
    require_once 'controllers/notifications.php';
$controller = new MenusControllersNotifications();
$controller->display();
?>