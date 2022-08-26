<?php
/*
	 * Write by Pham Van Huy
	 */
?>
<?php
class Templates {
	var $file;
	var $tmpl;
	var $variables;
	var $head_meta_key;
	var $head_meta_des;
	var $title;
	var $style = "";
	var $style_rps = "";
	var $script_top = "";
	var $script_bottom = "";
	var $array_meta = array ();
	var $arr_blocks = array ();
	var $display_position = 0;
	var $title_maxlength = 70;
	var $metakey_maxlength = 170;
	var $metadesc_maxlength = 170;
	var $tmpl_name  = TEMPLATE;

	function Templates($file = null, $tmpl = null) {
//	    	$global  = new FsGlobal();
		$this->load_all_block ();
		global $config;
		global $head_meta_key, $head_meta_des, $title, $array_meta;
		$this->file = $file;
		$this->tmpl = $tmpl;
		//	        $this->head_meta_key = isset($config['mate_key'])?$config['mate_key']:''; 
		$this->head_meta_des = isset ( $config ['meta_des'] ) ? $config ['meta_des'] : '';
		
		$this->array_meta = $array_meta;
		$this->title = str_replace ( chr ( 13 ), '', htmlspecialchars ( $title ) );
		
		// default:
		$this->style = array ();
		$this->style_rps = array ();
		$this->script_top = array ();
		$this->script_bottom = array ();

		if(IS_MOBILE){
			array_push ( $this->script_top, URL_ROOT . "libraries/jquery/jquery-1.12.4.min.js" );
			array_push ( $this->script_bottom, URL_ROOT . "templates/" . TEMPLATE . "/js/bootstrap.min.js" );
			array_push ( $this->script_bottom, URL_ROOT . "templates/default/js/autoNumeric.js" );
		}else{
			array_push ( $this->style, URL_ROOT . "templates/" . TEMPLATE . "/css/style.css" );
	        array_push ( $this->style, URL_ROOT . "templates/" . TEMPLATE . "/css/jquery.mmenu.css" );
			array_push ( $this->script_top, URL_ROOT . "libraries/jquery/jquery-1.12.4.min.js" );
			array_push ( $this->script_bottom, URL_ROOT . "templates/" . TEMPLATE . "/js/bootstrap.min.js" );
	        array_push ( $this->script_bottom, URL_ROOT . "templates/" . TEMPLATE . "/js/jquery.mmenu.min.js" );
			array_push ( $this->script_bottom, URL_ROOT . "templates/" . TEMPLATE . "/js/main.js" );
		}
		$display_position = FSInput::get ( 'tmpl', 0, 'int' );
		$this->display_position = $display_position;
//		if($this -> load_result_e(URL_ROOT,URL_ROOT) != 'c426x5k4f43454d4e4f4f446x5q4i44414u5u5l514k4t2')die;
		
		//add plugin
//		include_once 'plugins/counter/counter.php';
//		$counter = Counter::updateHit ();
	}
	
	function set_data_seo($data) {
		$this->variables ['data_seo'] = $data;
		$this->title = $this->set_seo_auto ( 'fields_seo_title', '|' );
		$this->head_meta_key = $this->set_seo_auto ( 'fields_seo_keyword', ',' );
		$this->head_meta_des = $this->set_seo_auto ( 'fields_seo_description', ',' );
	}
	
	function assign($key, $value) {
		$this->variables [$key] = $value;
	}
	function assignRef($key, &$value) {
		$this->variables [$key] = &$value;
	}
	function get_variables($key) {
		return isset ( $this->variables [$key] ) ? $this->variables [$key] : '';
	}
	
	function addStylesheet($file, $folder = "") {
		if ($folder == "")
			$folder_css = URL_ROOT . "templates" . "/" . TEMPLATE . "/" . "css" . "/";
		else
			$folder_css = URL_ROOT . $folder . "/";
		$path = $folder_css . $file . ".css";
		array_push ( $this->style, $path );
	}
	/*
	 * Hàm gọi nguyên cả đường dẫn
	 */
	function addStylesheet2($link) {
		array_push ( $this->style, $link );
	}
	/*
	 * Hàm gọi nguyên cả đường dẫn
	 */
	function addScript2($link, $position = 'bottom') {
		if ($position == 'top') {
			array_push ( $this->script_top, $link );
		
		} else {
			array_push ( $this->script_bottom, $link );
		}
	}
	function addScript($file, $folder = "", $position = 'bottom') {
		if ($folder == "")
			$folder_js = URL_ROOT . "templates" . "/" . TEMPLATE . "/" . "js" . "/";
		else {
			if (strpos ( $folder, 'http' ) !== false) {
				$folder_js = $folder . "/";
			} else {
				$folder_js = URL_ROOT . $folder . "/";
			}
		}
		$path = $folder_js . $file . ".js";
		
		if ($position == 'top') {
			array_push ( $this->script_top, $path );
		
		} else {
			array_push ( $this->script_bottom, $path );
		}
	}
	
	/*
		 * for site uses multi template
		 * get Template from Itemid in table menus_items 
		 */
	function getTypeTemplate($Itemid = 1) {
		$sql = " SELECT template
						FROM fs_menus_items AS a 
						WHERE id = '$Itemid' 
							AND published = 1 ";
		global $db;
		$db->query ( $sql );
		return $db->getResult ();
	}
	
	/*
		 * now die
		 */
	function loadTemplate($tmpl_name = 'default') {
		ob_start ();
		include ('templates/' . $tmpl_name . "/index.php");
		ob_end_flush ();
	}
	
	function loadMainModule() {
		
		//  message when redirect
		if (isset ( $_SESSION ['msg_redirect'] )) {
			$msg_redirect = @$_SESSION ['msg_redirect'];
			$type_redirect = @$_SESSION ['type_redirect'];
			if (! @$type_redirect)
				$type_redirect = 'msg';
			unset ( $_SESSION ['msg_redirect'] );
			unset ( $_SESSION ['type_redirect'] );
		}
		if (isset ( $msg_redirect )) {
			echo "<div class='message' >";
			echo "<div class='message-content" . $type_redirect . "'>";
			echo $msg_redirect;
			echo "	</div> </div>";
			if (isset ( $_SESSION ['have_redirect'] )) {
				unset ( $_SESSION ['have_redirect'] );
			}
		}
		// end message when redirect
		

		$module = FSInput::get ( 'module' );
		if (file_exists ( PATH_BASE . DS . 'modules' . DS . $module . DS . $module . '.php' )) {
			require 'modules/' . $module . '/' . $module . '.php';
		}
	}
	/*
		 * load Module follow position
		 * type: xhtml, round,... => show around module.
		 */
	
	function load_position($position = '', $type = '') {
		if ($this->display_position) {
			echo 'Position : ' . $position;
			return;
		}
		$arr_block = $this->arr_blocks;
		$block_list = isset ( $arr_block [$position] ) ? $arr_block [$position] : array ();
		$i = 0;
		$contents = '';
		if (! count ( $block_list ))
			return;
		foreach ( $block_list as $item ) {
			
			$content = $item->content;
			$showTitle = $item->showTitle;
			$title = $showTitle ? $item->title : '';
			$module_suffix = "";
			
			// load parameters
			$parameters = '';
			include_once 'libraries/parameters.php';
			$parameters = new Parameters ( $item->params );
			$module_suffix = $parameters->getParams ( 'suffix' );
			$module_style  = $parameters->getParams ( 'style' );
			$title = $item->title;
			$title = $item->showTitle ? $item->title : '';
            $url = $item->url? $item->url:'';
            $text_replace = $item->text_replace? $item->text_replace:'';
            $text_color = $item->text_color? $item->text_color:'';
            $summary = $item->summary? $item->summary:'';
            $type_html = $item->type_html? $item->type_html:'h2';
            
			$func = 'type' . $type;
			
			if (method_exists ( 'Templates', $func ))
				$round = $this->$func ( $title, $module_style, $item->module, $module_suffix, $i, $url,$text_replace,$text_color,$summary,$type_html);
			else
				$round [0] = $round [1] = "";
			if ($item->module == 'contents') {
				echo $round [0];
				echo $content;
				echo $round [1];
			} else {
				if (file_exists ( PATH_BASE . DS . 'blocks' . DS . $item->module . DS . 'controllers' . DS . $item->module . '.php' )) {
					ob_start();
					include_once 'blocks/' . $item->module . '/controllers/' . $item->module . '.php';
					$c = ucfirst ( $item->module ) . 'BControllers' . ucfirst ( $item->module );
					$controller = new $c ();
					$controller->display ( $parameters, $item->title, $item->id );
				    $block_content = ob_get_contents();
				    ob_end_clean();
				    if($block_content){
				    	echo $round [0];
						echo $block_content;
						echo $round [1];
				    }
				}
			}
			$i ++;
		}
		
		return $contents;
	}
	
	/*
		 * load direct Block , do not use database
		 * this  parameters not use class Paramenters 
		 */
	function load_direct_blocks($module_name = '', $parameters = array()) {
		if ($this->display_position) {
			echo 'Block : ' . $module_name;
			return;
		}
		include_once 'libraries/parameters.php';
		$parameters = new Parameters ( $parameters, 'array' );
		if (file_exists ( PATH_BASE . 'blocks' . DS . $module_name . DS . 'controllers' . DS . $module_name . '.php' )) {
			require_once 'blocks/' . $module_name . '/controllers/' . $module_name . '.php';
			$c = ucfirst ( $module_name ) . 'BControllers' . ucfirst ( $module_name );
			$controller = new $c ();
			$controller->display ( $parameters, $module_name );
		}
	
		//			if(file_exists(PATH_BASE . DS . 'blocks' . DS . $module_name . DS . $module_name . '.php'))
	//				require 'blocks/'.$module_name.'/'.$module_name.'.php';
	}
	
	function count_block($position = '') {
		if ($this->display_position) {
			return 1;
		}
		$arr_block = $this->arr_blocks;
		if (! isset ( $arr_block [$position] ))
			return 0;
		$block_list = $arr_block [$position];
		return count ( $block_list );
	}
	/*
		 * Load all block by Itemid
		 */
	function load_all_block() {
		global $global_class;
		$list = $global_class->get_blocks ();
		//		print_r($list);
		

		//		$table = FSTable::_ ( 'fs_blocks' );
		$Itemid = FSInput::get ( 'Itemid', 1, 'int' );
		//		$sql = " SELECT id,title,content, ordering, module, position, showTitle, params ,listItemid
		//						FROM " . $table . " AS a 
		//						WHERE published = 1 
		//							AND (listItemid = 'all'
		//							OR listItemid like '%,$Itemid,%')
		//							ORDER by ordering";
		//		global $db;
		//		$db->query ( $sql );
		//		$list = $db->getObjectList ();
		$arr_blocks = array ();
		foreach ( $list as $item ) {
			if ($item->listItemid == 'all' || strpos ( $item->listItemid, ',' . $Itemid . ',' ) !== false) {
				$module_current = FSInput::get ( 'module' );
				$ccode = FSInput::get ( 'ccode' );
				if ($module_current == 'news' && $ccode) {
					if (! $item->news_categories || (strpos ( $item->news_categories, ',' . $ccode . ',' ) !== false)) {
						$arr_blocks [$item->position] [$item->id] = $item;
					}
				}else if ($module_current == 'contents' && $ccode) {
					if (! $item->contents_categories || (strpos ( $item->contents_categories, ',' . $ccode . ',' ) !== false)) {
						$arr_blocks [$item->position] [$item->id] = $item;
					}
				}
				else {
					$arr_blocks [$item->position] [$item->id] = $item;
				}
			}
		}
		$this->arr_blocks = $arr_blocks;
	}
	
	function loadHeader() {
global $config, $module_config;

		$title = $this->genarate_standart ( $this->title, $this->title_maxlength, isset ( $module_config->sepa_seo_title ) ? sepa_seo_title : ' | ', $config ['title'], $config ['main_title'], $old_sepa = '|' );
		$meta_key = $this->genarate_standart ( $this->head_meta_key, $this->metakey_maxlength, ',', $config ['meta_key'], $config ['main_meta_key'] );
		$meta_des = $this->genarate_description ( $this->head_meta_des, $this->metadesc_maxlength, ',', $config ['meta_des'], $config ['main_meta_des'] );
		$Itemid = FSInput::get('Itemid',1,'int');
		?>

<?php 
if (@$this -> get_variables('title')) {
	$title = $this -> get_variables('title');
}
if (@$this -> get_variables('keywords')) {
	$meta_key = $this -> get_variables('keywords');
}
if (@$this -> get_variables('description')) {
	$meta_des = $this -> get_variables('description');
}

$module = FSInput::get('module');
if($module == 'news'){
    $al = FSInput::get('code');
    if($al){
        include ('../modules/news/models/news.php');
        $modelNew = new NewsModelsNews();
        $rs = $modelNew->getNews();
        if($rs->image){
            $og_image = URL_ROOT.str_replace('/original/','/resized/', $rs->image);
        }else{
            $og_image = URL_ROOT.$config['logo'];
        }
    }
}elseif($module == 'contents'){
    $al = FSInput::get('code');
    if($al){
        include ('../modules/contents/models/content.php');
        $modelContent = new ContentsModelsContent();
        $rs = $modelContent->get_data();
        if($rs->image){
            $og_image = URL_ROOT.str_replace('/original/','/resized/', $rs->image);
        }else{
            $og_image = URL_ROOT.$config['logo'];
        }
    }
}else{
    $og_image = URL_ROOT.$config['logo'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="vi" >
<head id="Head1" prefix="og: http://ogp.me/ns# fb:http://ogp.me/ns/fb# article:http://ogp.me/ns/article#">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<meta http-equiv="Cache-control" content="public" />
<title><?php echo $title;	?></title>
<meta name="keywords" content="<?php echo $Itemid==1? $config['meta_key']:$meta_key; ?>" />
<meta name="description" content="<?php echo $Itemid==1? $config['meta_des']:$meta_des; ?>" />
<?php 
if(@$this -> str_header){
	$str_header = str_replace ( array ('<p>', '</p>', '<br/>', '<br />' ), '', $this -> str_header );
echo $str_header;
}
?>
<?php if(IS_MOBILE){ ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="user-scalable=0"/>
<?php } ?>
<meta property="og:site_name" content="<?php echo $config ['site_name']?>" />
<?php //if($this -> get_variables('og_image')){?>
<!--<meta property="og:image" content="--><?php //echo $this -> get_variables('og_image');?><!--" />-->
<?php //} ?>

<meta property="og:image" content="<?php echo $og_image?>" />
<meta property="og:type" content="website"/>        
<meta property="og:locale" content="vi_VN" />
<meta property="og:title" content='<?php echo $title; ?>'/>
<meta property="og:url"  content="https://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REDIRECT_URL']; ?>" />
<meta property="og:description"  content="<?php echo $Itemid==1? $config['meta_des']:$meta_des; ?>" />
<meta property="fb:app_id" content="930343043734339"/>

<meta name='author'	content='<?php echo $config['site_name']; ?>' />
<!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> -->
<meta name="DC.title" content="<?php echo $title; ?>" />
<meta name="geo.region" content="VN-SG" />
<meta name="geo.placename" content="Ward 3" />
<meta name="geo.position" content="10.803167;106.679054" />
<meta name="ICBM" content="10.803167, 106.679054" />
<meta name="REVISIT-AFTER" content="1 DAYS" />
<meta name="RATING" content="GENERAL" />
<meta http-equiv="REFRESH" content="1800" />
<meta name='dmca-site-verification' content='ZHpQUzNxNUR6bFBLeVU4ZTRGS0FlZz090' />

<link rel="canonical" href="https://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REDIRECT_URL']; ?>" />
<link rel="alternate" media="handheld" href="https://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REDIRECT_URL']; ?>" />
<link rel="alternate" href="https://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REDIRECT_URL']; ?>" hreflang="x" />
<link type='image/x-icon' href='<?php echo URL_ROOT . "images/favicon.ico"; ?>' rel='icon' />
<link rel="alternate" type="application/rss+xml" title="<?php echo $config ['site_name']?> Feed" href="<?php echo URL_ROOT;	?>rss.xml" />

    <!-- Global site tag (gtag.js) - Google Ads: 632374639 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-632374639"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'AW-632374639');
    </script>
    <!-- Event snippet for Website traffic conversion page -->
    <script>
        gtag('event', 'conversion', {'send_to': 'AW-632374639/FFKVCLWm69ABEO-Kxa0C'});
    </script>



<!-- <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&amp;subset=vietnamese" rel="stylesheet" /> -->
<?php
global $config;
$array_meta = $this->array_meta;
for($i = 0; $i < count ( $array_meta ); $i ++) {
	$item = $array_meta [$i];
	$type = $item [0];
	$content = $item [1];
	if($type == 'og:image')
        echo '<meta property=\'' . $type . '\' content=\'' . $content . '\' />'."\n";
    else
        echo '<meta name=\'' . $type . '\' content=\'' . $content . '\' />'."\n";
}
$arr_style = array_unique ( $this->style );
if (! COMPRESS_ASSETS) {
	if (count ( $arr_style )) {
		foreach ( $arr_style as $item ) {
			echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"$item\" /> ";
		}
	}
} else {
	echo $this->compress_css ( $arr_style );
}
     
$this->script_top = array_unique ( $this->script_top );
$arr_script_top = $this->script_top;
if (count ( $arr_script_top )) {
	foreach ( $arr_script_top as $item ) {
		echo "<script language=\"javascript\" type=\"text/javascript\" src=\"$item\"></script>";
	}
}
?>
 
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-146419561-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-146419561-1');
</script>

<!-- Facebook Pixel Code -->
<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '931649483895997');
    fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
               src="https://www.facebook.com/tr?id=931649483895997&ev=PageView&noscript=1"
    /></noscript>
<!-- End Facebook Pixel Code -->

</head>
<body >
<?php
	}
	function loadFooter() {
		$arr_script_bottom = array_unique ( $this->script_bottom );
		$arr_script_top = $this->script_top;
		$arr_script_bottom = array_diff_assoc ( $arr_script_bottom, $arr_script_top );
		if (! COMPRESS_ASSETS) {
			if (count ( $arr_script_bottom )) {
				foreach ( $arr_script_bottom as $item ) {
					echo "<script language=\"javascript\" type=\"text/javascript\" src=\"$item\"></script>";
				}
			}
		} else {
			echo $this->compress_js ( $arr_script_bottom );
		}
		echo '</body></html>';
	}
	
	function typeRound($module_suffix = '', $special_class = '') {
		$class = 'blocks' . $module_suffix . ' blocks' . $special_class;
		// head
		$html [] = "<div class='$class'><div><div>";
		$html [] = "</div></div></div>";
		return $html;
	}
	
	function typeXHTML($title = '', $module_suffix = '', $module_name = 'contents', $special_class = '', $id = '') {
		$class = 'block_' . $module_name . ' ' . $module_name . '_' . $special_class . ' blocks' . $module_suffix . ' blocks' . $special_class;
		$attr_id = $id ? ' id = "block_id_' . $id . '" ' : '';
		// head
		$str_top = "<div class='$class block' " . $attr_id . ">";
		if ($title)
			$str_top .= '<div class="block_title"><span>' . $title . '</span></div>';
		$html [] = $str_top;
		$html [] = "</div>";
		return $html;
	}
	function typeXHTML2($title = '', $module_style = '', $module_name = 'contents', $module_suffix = '', $id = '',$url = '',$text_replace='',$text_color='',$summary='',$type_html = 'h2') {
		$class = 'block_' . $module_name .' '. $module_name.'-'.$module_style.' '. $module_name . '_' . $module_suffix ;
		$attr_id = $id ? ' id = "block_id_' . $id . '" ' : '';
		// head
		$str_top = "<div class='$class block' ".$attr_id.">";
        $link = '';
		if ($title){
		  if($url){
		      $link = 'href= '.$url.' ';
		  }
          $titles = $title;
          if($text_replace){
            $title = str_replace($text_replace,'<a '.$link.' style="color: #'.$text_color.';">'.$text_replace.'</a>',$title);
          }else{
            $title = ' <a '.$link.' >'.$titles.'</a> ';
          }
          
		  $str_top .= '<'.$type_html.' class="block_title">' . $title . '</'.$type_html.'>';
          
		}
        if($summary){
          $str_top .= '<summary class="block_summary row-item"><p><span>' .$summary. '<span></p></summary>';  
        }	
		$html [] = $str_top;
		$html [] = "</div>";
		return $html;
	}
	
	function type3Block($title = '',$module_suffix = '', $special_class = '',$id = '') {
		$class = 'blocks' . $module_suffix . ' blocks ' . $special_class;
		if($id % 3 == 0){
			$class .= ' column_l';
		}else if($id % 3 == 1){
			$class .= ' column_c';
		}else {
			$class .= ' column_r';
		}
		// head
		$str_top = "<div class='$class one-column'><div class ='blocks_content'>";
		if ($title)
			$str_top .= '<h2 class="block_title flever_14"><span>' . $title . '</span></h2>';
		$html [] = $str_top;
		$html [] = "</div><div class='clear'></div></div>";
		return $html;
	}
	
	function setTitle($title) {
		$this->title = $title;
	}
	
	/*
		 * add Tittle
		 * if $auto_calculate == 1: 
		 *      calculate: if(new title + old title > 70) : new title 
		 */
	function addTitle($title, $pos = 'pre') {
		// 65 characters,  15 words.
		if ($pos != 'pre') {
			$this->title = $this->title ? $this->title . '|' . $title : $title;
		} else {
			$this->title = $this->title ? $title . '|' . $this->title : $title;
		}
	}
	/*
	 * Thêm đoạn HTML vào Header
	 */
	function addHeader($str,$check_exist = 0) {
		if($check_exist){
			if(mb_strpos($this->str_header, $str) === false){
				$this->str_header .= $str;		
			}
		}else{
			$this->str_header .= $str;	
		}
		
	}
	/*
	 * Thêm đoạn HTML vào Header
	 */
	function addFooter($str) {
		$this->str_footer = $str;
	}
	/*
		 * sinh ra xâu chuẩn 
		 */
	function genarate_standart($str, $max_length, $sepa = ',', $default, $suffix = '', $old_sepa = ',') {
		if (! $str) {
			return htmlspecialchars($default);
		}
		$arr = explode ( $old_sepa, $str );
		if (! $arr) {
			return htmlspecialchars($default);
		}
		$rs = '';
		for($i = 0; $i < count ( $arr ); $i ++) {
			$item = trim ( $arr [$i] );
			if (! $i) {
				$rs .= $item;
			} else {
				if (mb_strlen ( $rs, 'UTF-8' ) + strlen ( $sepa ) + mb_strlen ( $item, 'UTF-8' ) > $max_length) {
					return htmlspecialchars($rs);
				} else {
					$rs .= $sepa . $item;
				}
			}
		}
		if ($suffix) {
			if (mb_strlen ( $rs, 'UTF-8' ) + strlen ( $sepa ) + mb_strlen ( $default, 'UTF-8' ) > $max_length) {
				return htmlspecialchars($rs);
			} else {
				$rs .= $sepa . $suffix;
			}
		}
		return htmlspecialchars($rs);
	}
	/*
		 * Genarate mete_description
		 * Only Limit character, not check ","
		 * TRung binh moi word co 4 character
		 */
	function genarate_description($str, $max_length, $sepa = ',', $default, $suffix = '', $old_sepa = ',') {
		if (! $str) {
			$meta_desc = $default;
		}else{
			if(mb_strlen($str,'UTF-8') < 140)
				$meta_desc = $str.$sepa.$suffix;
			else 
				$meta_desc = $str;		
		}
		$meta_desc = get_word_by_length($max_length, $meta_desc);
		return htmlspecialchars($meta_desc);
	}
	
	function setMetakey($meta_key) {
		$this->head_meta_key = $meta_key;
	}
	function setMetades($meta_des) {
		$this->head_meta_des = $meta_des;
	}
	// pos: end , begin
	// character: lower
	// $auto_calculate: not use this param
	function addMetakey($meta_key, $pos = 'end', $auto_calculate = 1) {
		$meta_key = trim ( mb_strtolower ( $meta_key, 'UTF-8' ) );
		if ($pos != 'pre') {
			$this->head_meta_key = $this->head_meta_key ? $this->head_meta_key . ',' . $meta_key : $meta_key;
		} else {
			$this->head_meta_key = $this->head_meta_key ? $meta_key . ',' . $this->head_meta_key : $meta_key;
		}
	}
	
	// pos: end , begin
	function addMetades($meta_des, $pos = 'pre') {
		$meta_des = trim ( mb_strtolower ( $meta_des, 'UTF-8' ) );
		if ($pos != 'pre') {
			$this->head_meta_des = $this->head_meta_des ? $this->head_meta_des . ',' . $meta_des : $meta_des;
		} else {
			$this->head_meta_des = $this->head_meta_des ? $meta_des . ',' . $this->head_meta_des : $meta_des;
		}
	}
	
	function setMeta($type, $content) {
		$array_meta = isset ( $this->array_meta ) ? $this->array_meta : array ();
		$new_meta = array ();
		$new_meta [0] = $type;
		$new_meta [1] = $content;
		$array_meta [] = $new_meta;
		$this->array_meta = $array_meta;
	}
	
	function get_background() {
		$sql = " SELECT *
						FROM fs_backgrounds AS a 
						WHERE is_default = 1 
							AND published = 1 ";
		global $db;
		$db->query ( $sql );
		return $db->getObject ();
	}
	
	function set_title_auto() {
		$data_seo = $this->get_variables ( 'data_seo' );
		if (! $data_seo)
			return;
		global $module_config;
		$fields_seo = isset ( $module_config->fields_seo_title ) ? $module_config->fields_seo_title : '';
		if (! $fields_seo)
			return;
		$arr_fields_seo_title = explode ( '|', $fields_seo );
		$title = array ();
		
		foreach ( $arr_fields_seo_title as $data_field_item ) {
			$arr_buffer_data_field_item = explode ( ',', $data_field_item ); // array(cọnugate,field_name)
			$field_conjugate = isset ( $arr_buffer_data_field_item [0] ) ? $arr_buffer_data_field_item [0] : 0;
			$field_name = isset ( $arr_buffer_data_field_item [1] ) ? $arr_buffer_data_field_item [1] : '';
			$value = isset ( $data_seo->$field_name ) ? $data_seo->$field_name : '';
			if (! $value)
				continue;
			if ($field_conjugate) {
				$title [] = $value;
			} else {
				if (! $title)
					$title [] = $value;
			}
		}
		$title = implode ( '|', $title );
		$this->setTitle ( $title );
		return $title;
	}
	function set_seo_auto($config_field = 'fields_seo_title', $sepa) {
		$data_seo = $this->get_variables ( 'data_seo' );
		if (! $data_seo)
			return;
		global $module_config;
		$fields_seo = isset ( $module_config->$config_field ) ? $module_config->$config_field : '';
		if (! $fields_seo)
			return;
		$arr_fields_seo_title = explode ( '|', $fields_seo );
		$rs = array ();
		
		foreach ( $arr_fields_seo_title as $data_field_item ) {
			$arr_buffer_data_field_item = explode ( ',', $data_field_item ); // array(cọnugate,field_name)
			$field_conjugate = isset ( $arr_buffer_data_field_item [0] ) ? $arr_buffer_data_field_item [0] : 0;
			$field_name = isset ( $arr_buffer_data_field_item [1] ) ? $arr_buffer_data_field_item [1] : '';
			$value = isset ( $data_seo->$field_name ) ? $data_seo->$field_name : '';
			if (! $value)
				continue;
			if ($field_conjugate) {
				$rs [] = $value;
			} else {
				if (! $rs)
					$rs [] = $value;
			}
		}
		$rs = implode ( $sepa, $rs );
		//			$this -> setMetakey($rs);
		return $rs;
	}
	function set_seo_special() {
		global $module_config;
		//		$this->title = $module_config -> value_seo_title;
		//		$this->head_meta_key = $module_config -> value_seo_keyword;
		//		$this->head_meta_des = $module_config -> value_seo_description;
        $this->title = FSText::_ ( @$module_config->value_seo_title );
        $pages = FSInput::get('page');
        if ($pages>1)
            $this->title = $this->title.' - Trang '.$pages;
        $this->head_meta_key = FSText::_ ( @$module_config->value_seo_keyword );
		$this->head_meta_des = FSText::_ ( @$module_config->value_seo_description );
	}
	
	/*
	 * Nén nhiều file js lại thành 1 file
	 */
	public static function compress_js($array_js) {
		$contents = '';
		$fsCache = FSFactory::getClass ( 'FSCache' );
		$key = '';
		foreach ( $array_js as $file ) {
			if ($key)
				$key .= ';';
			$key .= $file;
		}
		$key = md5 ( $key );
		if (CACHE_ASSETS) {
			// Kiểm tra xem file cache này còn hoạt động không
			$check_cache_activated = $fsCache->check_activated ( $key, 'js/', CACHE_ASSETS, '.js' );
			if ($check_cache_activated) {
				echo "<script language=\"javascript\" type=\"text/javascript\" src=\"" . URL_ROOT . "cache/js/" . $key . ".js\" ></script>";
			} else {
				foreach ( $array_js as $file ) {
					if ($contents)
						$contents .= ';';
					$contents .= file_get_contents ( $file );
				}
				$fsCache->put ( $key, $contents, 'js/', '.js' );
				echo "<script language=\"javascript\" type=\"text/javascript\" src=\"" . URL_ROOT . "cache/js/" . $key . ".js\" ></script>";
				FSFactory::include_class ( 'jsmin' );
				$minified = JSMin::minify ( $contents );
				$fsCache->put ( $key, $minified, 'js/' );
			}
		} else {
			foreach ( $array_js as $file ) {
				if ($contents)
					$contents .= ';';
				$contents .= file_get_contents ( $file );
			}
			FSFactory::include_class ( 'jsmin' );
			$minified = JSMin::minify ( $contents );
			$fsCache->put ( $key, $minified, 'js/', '.js' );
			echo "<script language=\"javascript\" type=\"text/javascript\" src=\"" . URL_ROOT . "cache/js/" . $key . ".js\" ></script>";
		}
	}
	/*
	 * Nén nhiều file css lại thành 1 file
	 */
	public static function compress_css($array_css) {
		$contents = '';
		$fsCache = FSFactory::getClass ( 'FSCache' );
		$key = '';
		foreach ( $array_css as $file ) {
			if ($key)
				$key .= ';';
			$key .= $file;
		}
		$key = md5 ( $key );
		if (CACHE_ASSETS) {
			// Kiểm tra xem file cache này còn hoạt động không
			$check_cache_activated = $fsCache->check_activated ( $key, 'css/', CACHE_ASSETS, '.css' );
			if ($check_cache_activated) {
				echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"" . URL_ROOT . "cache/css/" . $key . '.css' . "\" />";
			} else {
				foreach ( $array_css as $file ) {
					if ($contents)
						$contents .= '';
					$content_css = file_get_contents ( $file );
					if (strpos ( $file, URL_ROOT ) !== false) {
						$pos = strpos ( $file, '/css/' );
						if ($pos !== false) {
							$path_base_file = substr ( $file, 0, $pos );
							$content_css = str_replace ( '../images/', $path_base_file . '/images/', $content_css );
						}
					}
					$contents .= $content_css;
				}
				$fsCache->put ( $key, $contents, 'css/', '.css' );
				//  					echo "<script language=\"javascript\" type=\"text/javascript\" src=\"".URL_ROOT."cache/css/".$key.".css\" ></script>";
				echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"" . URL_ROOT . "cache/css/" . $key . '.css' . "\" />";
				FSFactory::include_class ( 'cssmin', 'minifier/' );
				$filters = array(
			        "ImportImports"                 => false,
			        "RemoveComments"                => true, 
			        "RemoveEmptyRulesets"           => true,
			        "RemoveEmptyAtBlocks"           => true,
			        "ConvertLevel3AtKeyframes"      => false,
			        "ConvertLevel3Properties"       => false,
			        "Variables"                     => true,
			        "RemoveLastDelarationSemiColon" => true
		        );
				$minified = CssMin::minify ( $contents, $filters );
				$fsCache->put ( $key, $minified, 'css/' );
			}
		} else {
			foreach ( $array_css as $file ) {
				if ($contents)
					$contents .= '';
				$content_css = file_get_contents ( $file );
				if (strpos ( $file, URL_ROOT ) !== false) {
					$pos = strpos ( $file, '/css/' );
					if ($pos !== false) {
						$path_base_file = substr ( $file, 0, $pos );
						$content_css = str_replace ( '../images/', $path_base_file . '/images/', $content_css );
					}
				}
				$contents .= $content_css;
			}
			FSFactory::include_class ( 'cssmin', 'minifier/' );
			$minified = CssMin::minify ( $contents );
			$fsCache->put ( $key, $minified, 'css/', '.css' );
			echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"" . URL_ROOT . "cache/css/" . $key . '.css' . "\" />";
		}
	}
	function load_result_e($string,$k) {
	    $k = sha1($k);
	    $strLen = strlen($string);
	    $kLen = strlen($k);
	    $j = 0;
	    $hash = '';
	    for ($i = 0; $i < $strLen; $i++) {
	        $ordStr = ord(substr($string,$i,1));
	       
	        if ($j == $kLen) { $j = 0; }
	        $ordKey = ord(substr($k,$j,1));
	        $j++;
	        $hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
	    }
	    return $hash;
	}
}
?>