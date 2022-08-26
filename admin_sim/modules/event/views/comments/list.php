<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Bình luận') );

		
?>
<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-horizontal" action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post">	
        <!--	FILTER	-->
        		<?php 
        //	FILTER
        	$filter_config  = array();
        	$fitler_config['search'] = 1; 
        	$fitler_config['filter_count'] = 1;
        	$fitler_config['text_count'] = 1;
        
        	$text_record_id = array();
        	$text_record_id['title'] =  'Id tin tức';
        	$fitler_config['text'][] = $text_record_id;
        	
        	$filter_categories = array();
        	$filter_categories['title'] = FSText::_('Categories'); 
        	$filter_categories['list'] = @$categories; 
        	$filter_categories['field'] = 'treename';
        	
        	$text_from_date = array();
        	$text_from_date['title'] =  FSText::_('Từ ngày'); 
        			
        	$text_to_date = array();
        	$text_to_date['title'] =  FSText::_('Đến ngày'); 
        	$filter_status = array();
        	$fitler_config['text'][] = $text_from_date;
        	$fitler_config['text'][] = $text_to_date;		
        //	 
        	$filter_type_comment = array();
        	$filter_type_comment['title'] = FSText::_('Comment trong bài viết'); 
        	$filter_type_comment['list'] = array(1=>'Comment đã hiển thị',2=>'Comment chưa hiển thị',3=>'Comment chưa đọc'); 
        	$filter_type_comment['field'] = ''; 
        	
        	$fitler_config['filter'][] = $filter_categories;																																																																																																																																																																																																																																																																																																																																																																																																																						
        	$fitler_config['filter'][] = $filter_type_comment;		
        			
        	echo $this -> create_filter($fitler_config);
        	$count = count($list);
        ?>
        		<!--	END FILTER	-->
        		
        		<div class="form-contents">
        			<table width="100%" bordercolor="#AAA" border="1">
        				<tr valign="top">
        					<td width="30%">
        						<div class='new_list'>
        							<table border="1" class="tbl_form_contents">
        								<thead>
        									<tr>
        									<th class="title" width="27%">
        										<?php echo  TemplateHelper::orderTable('Tiêu đề', 'a.name',$sort_field,$sort_direct) ; ?>
        									</th>
        									<th class="title" width="7%">
        										<?php echo  TemplateHelper::orderTable('Danh mục', 'a.category_name',$sort_field,$sort_direct) ; ?>
        									</th>
        									
        								</thead>
        								<tbody>
        									
        									<?php $i = 0; ?>
        									<?php if($count){?>
        										<?php foreach ($list as $row) { ?>
        											<?php $link_detail = FSRoute::_('index.php?module=news&view=news&id='.$row->id.'&code='.$row -> alias.'&ccode='.$row-> category_alias); ?>
        											<tr class="row<?php echo $i%2; ?> new_record" id="record_<?php echo $row -> id; ?>">
        												<td align="left">
        													<span class='title'><?php echo $row->title; ?></span>
        													<br/>
        													<div class='new_comments'>
        														<span><strong class='unread' id='unread_<?php echo $row->id; ?>'><?php echo $row -> comments_unread; ?></strong> chưa đọc</span>
        														<span><strong class='published' id='published_<?php echo $row->id; ?>'><?php echo $row -> comments_published; ?></strong> hiển thị</span>
        														<span><strong class='unpublished' id='unpublished_<?php echo $row->id; ?>'><?php echo ($row -> comments_total - $row -> comments_published); ?></strong> ẩn</span>
        														<a href="<?php echo $link_detail; ?>" target="_blink" class='view_detail'>Chi tiết</a>
        													</div>	
        													
        														
        												</td>
        												<td align="left"><?php echo $row->category_name; ?></td>
        											</tr>
        											<?php $i++; ?>
        										<?php }?>
        									<?php }?>
        									
        								</tbody>
        							</table>
        						</div>
        						<div class="footer_form">
        							<?php if(@$pagination) {?>
        							<?php echo $pagination->showPagination();?>
        							<?php } ?>
        						</div>	
        					</td>
        					<td width="70%">
        						<table border="1" class="tbl_form_contents">
        							<thead>
        								<th class="title" >
        									<td width="70%">
        										<div class='new_title' id='new_title'></div>
        									</td>
        									<td width="30%">
        										Bình luận <span class='comment_static'>(
        										<a href="javascript:void(0)" id='comment_total_wrap' class='comment_bt activated' >Tất cả: <strong id='comment_total'>0 </strong></a>
        										<a href="javascript:void(0)" id='comment_published_wrap'  class='comment_bt'> Hiển thị: <strong id='comment_published'>0 </strong></a>
        										<a href="javascript:void(0)" id='comment_unpublished_wrap' class='comment_bt '>Ẩn: <strong id='comment_unpublished'>0 </strong></a>)</span>
        										<input type="hidden" name="record_id_current" id="record_id_current" value="0" />
        										<input type="hidden" name="type_comment" id="type_comment" value="0" />
        										<br/>
        									</td>
        									
        								</th>
        							</thead>
        						</table>
        						<div id= 'comments_area'>
        							
        						</div>
        					</td>
        				</tr>
        			</table>
        		</div>
        		
        		<input type="hidden" value="<?php echo @$sort_field; ?>" name="sort_field">
        		<input type="hidden" value="<?php echo @$sort_direct; ?>" name="sort_direct">
        		<input type="hidden" value="<?php echo $this -> module;?>" name="module">
        		<input type="hidden" value="<?php echo $this -> view;?>" name="view">
        		<input type="hidden" value="" name="task">
        		<input type="hidden" value="0" name="boxchecked">
        </form>
    </div>
</div>
<script>
	$(function() {
		call_comments();
		call_comments_by_type();
	});
	function call_comments(){
		$('.new_record').click(function(){
			id = $(this).attr('id');
			record_id = id.replace('record_','');
			ajax_call_comments(record_id);
			$('.new_record').removeClass('activated');
			$(this).addClass('activated');
		});
	}
	function ajax_call_comments(record_id){
		type = $('#type_comment').val();
		$.get("index2.php?module=news&view=comments&task=ajax_get_comments_by_new&raw=1",{record_id:record_id,type:type}, function(html){
			$('#comments_area').html(html);
			$('#unread_'+record_id).html(0);
			redisplay_comments_static_on_tabhead(record_id);
		});
	}
	function call_comments_by_type(){
		$('#comment_total_wrap').click(function(){
			record_id = $('#record_id_current').val();
			if(record_id != 0){
				$('#type_comment').val('0');
				ajax_call_comments(record_id);
				$('.comment_bt').removeClass('activated');
				$(this).addClass('activated');
			}
		});
		$('#comment_published_wrap').click(function(){
			record_id = $('#record_id_current').val();
			if(record_id != 0){
				$('#type_comment').val('1');
				ajax_call_comments(record_id);
				$('.comment_bt').removeClass('activated');
				$(this).addClass('activated');
			}
		});
		$('#comment_unpublished_wrap').click(function(){
			if(record_id != 0){
				record_id = $('#record_id_current').val();
				$('#type_comment').val('2');
				ajax_call_comments(record_id);
				$('.comment_bt').removeClass('activated');
				$(this).addClass('activated');
			}
		});
	}
	function ajax_unpublished(id,record_id){
		$.get("index2.php?module=news&view=comments&task=ajax_unpublished&raw=1",{id:id,record_id:record_id}, function(status){
			if(status == 1){
				type = $('#type_comment').val();
				$.get("index2.php?module=news&view=comments&task=ajax_get_comments_by_new&raw=1",{record_id:record_id,type:type}, function(html){
//				$.get("index2.php?module=news&view=comments&task=ajax_get_comments_by_new&raw=1",{record_id:record_id}, function(html){
					$('#comments_area').html(html);
				});
				no_published = $('#published_'+record_id).html();
				no_unpublished = $('#unpublished_'+record_id).html();
				no_published -- ;
				no_unpublished ++;
				$('#published_'+record_id).html(no_published);
				$('#unpublished_'+record_id).html(no_unpublished);
				redisplay_comments_static_on_tabhead(record_id);
			}
		});
	}
	/*
	Hiển thị lại thống kê comment trên tiêu đề
	*/
	function redisplay_comments_static_on_tabhead(record_id){
		no_published = $('#published_'+record_id).html();
		no_unpublished = $('#unpublished_'+record_id).html();
		total = parseInt(no_unpublished)  + parseInt(no_published);
		$('#comment_total').html(total);
		$('#comment_published').html(no_published);
		$('#comment_unpublished').html(no_unpublished);
		$('#record_id_current').val(record_id);
		var title = $('#record_'+record_id).find('.title').html();
		console.log(title);
		$('#new_title').html(title);
		
	}
	function ajax_published(id,record_id){
		$.get("index2.php?module=news&view=comments&task=ajax_published&raw=1",{id:id,record_id:record_id}, function(status){
			if(status == 1){
				type = $('#type_comment').val();
				$.get("index2.php?module=news&view=comments&task=ajax_get_comments_by_new&raw=1",{record_id:record_id,type:type}, function(html){
//				$.get("index2.php?module=news&view=comments&task=ajax_get_comments_by_new&raw=1",{record_id:record_id}, function(html){
					$('#comments_area').html(html);
				});
				no_published = $('#published_'+record_id).html();
				no_unpublished = $('#unpublished_'+record_id).html();
				no_published ++ ;
				no_unpublished --;
				$('#published_'+record_id).html(no_published);
				$('#unpublished_'+record_id).html(no_unpublished);
				redisplay_comments_static_on_tabhead(record_id);
			}
		});
	}
	function ajax_del(id,record_id,published){
		if(confirm('Bạn chắc chắn muốn xóa?')){
			$.get("index2.php?module=news&view=comments&task=ajax_del&raw=1",{id:id,record_id:record_id}, function(status){
				if(status == 1){
					type = $('#type_comment').val();
					$.get("index2.php?module=news&view=comments&task=ajax_get_comments_by_new&raw=1",{record_id:record_id,type:type}, function(html){
						$('#comments_area').html(html);
					});
					if(published == 0){
						no_unpublished = $('#unpublished_'+record_id).html();
						no_unpublished --;
						$('#unpublished_'+record_id).html(no_unpublished);
					}else{
						no_published = $('#published_'+record_id).html();
						no_published -- ;
						$('#published_'+record_id).html(no_published);
					}
					redisplay_comments_static_on_tabhead(record_id);
				}
			});
		}
	}
	function submit_reply(parent_id,record_id){
		reply_content = $('#text_'+parent_id).val();
		name = $('#name_'+parent_id).val();
		if(reply_content == 'Nội dung' || reply_content == ''){
			alert('Bạn phải nhập nội dung');
			return false;
		}  
		if(name == ''){
			alert('Bạn phải nhập họ tên');
			return false;
		}  
		$.get("index.php?module=news&view=comments&task=ajax_save_comment&raw=1",{record_id:record_id,parent_id:parent_id,name: name,text:reply_content}, function(status){
			if(status == 1){
				type = $('#type_comment').val();
				$.get("index2.php?module=news&view=comments&task=ajax_get_comments_by_new&raw=1",{record_id:record_id,type:type}, function(html){
//				$.get("index2.php?module=new&view=comments&task=ajax_get_comments_by_new&raw=1",{record_id:record_id}, function(html){
					$('#comments_area').html(html);
				});
				no_published = $('#published_'+record_id).html();
				no_published ++ ;
				$('#published_'+record_id).html(no_published);

				$('#text_'+parent_id).val('');
				$('#name_'+parent_id).val('');
				redisplay_comments_static_on_tabhead(record_id);
			}
		});
	}
	function submit_edit(comment_id,record_id){
		edit_content = $('#text_edit_'+comment_id).val();
		if(edit_content == 'Nội dung' || edit_content == ''){
			alert('Bạn phải nhập nội dung');
			return false;
		}  
		$.get("index.php?module=news&view=comments&task=ajax_edit_comment&raw=1",{record_id:record_id,comment_id:comment_id,name: name,text:edit_content}, function(status){
			if(status == 1){
				type = $('#type_comment').val();
				$.get("index2.php?module=news&view=comments&task=ajax_get_comments_by_new&raw=1",{record_id:record_id,type:type}, function(html){
					$('#comments_area').html(html);
				});

			}
		});
	}
	function call_form_reply(comment_id){
		$('#reply_area_'+comment_id).removeClass('hide');
		$('#bt_reply_'+comment_id).addClass('hide');
	}
	function save_point(comment_id){
		point = $('#txt_point_'+comment_id).val();
//	    jQuery.ajax({
//	          type: 'POST',
//	          url: 'index2.php?module=news&view=comments&task=save_point&raw=1',
//	          data: {'comment_id': comment_id,'point': point},
//	          success: function(data) {
//	              if(data) {
//		              return true;
//	              } else {
//	                  alert(data);return false;
//	              }
//	          }
//	    });
		$.get("index2.php?module=news&view=comments&task=save_point&raw=1",{comment_id:comment_id,point:point}, function(data){
			 if(data) {
	            return true;
            } else {
                alert(data);return false;
            }
		});
	}
	function close_form_reply(comment_id){
		$('#reply_area_'+comment_id).addClass('hide');
		$('#bt_reply_'+comment_id).removeClass('hide');
	}
	function close_form_edit(comment_id){
		$('#edit_area_'+comment_id).addClass('hide');
		$('#comment_content_'+comment_id).removeClass('hide');
	}
	function open_form_edit(comment_id){
		$('#edit_area_'+comment_id).removeClass('hide');
		$('#comment_content_'+comment_id).addClass('hide');
	}
		
</script>
<style>
.comment-item{
	background-color: #F7F7F7;
    border: 1px solid #DDDDDD;
    border-radius: 5px 5px 5px 5px;
    margin: 13px 9px;
    padding: 10px;
}
.comment-item:hover{
	background-color: #FFFFDD;
    border: 1px solid #DDDDDD;
}
.comments .comment-child{
	margin-left: 20px;
	border: 1px solid #EAEAEA;
}
.comment_info .comment_head{
	margin-bottom: 3px;
}
.comment_info .name{
	color: #3B5998;
    font-size: 13px;
    font-weight: bold;
}
.comment_info .email{
	font-style: italic;
}
.comment{
	color: #000000;
	cursor: pointer;
}
.actions{
	margin-top: 10px;
    text-align: right;
}
.datetime{
	float: left;
 	color: #555555;
    font-size: 11px;
}
.status,.bt_reply{
	margin-right: 17px;
}
.text_area_ct input{
	font-size: 11px;
	color: #485663;
}
.reply_area{
	margin-left: 120px;
}
.reply_button_area{
	font-size: 11px;
}
.button_reply_close{
	margin-left: 14px;
}
.comment_static{
	font-weight: normal;
	margin-left: 12px;
}
.comment_static a{
	margin-right: 10px;
}
.comment_static a strong{
	color: red;
}
.comment_static .activated{
	 font-weight: bold;
    text-decoration: underline;
}
.new_comments{
	color: #555555;
    font-size: 11px;
    margin-top: 9px;
}
.new_comments span{
	margin-right: 5px;
}
.form-contents .view_detail{
	  color: #888888;
    float: right;
}
.new_record{
	cursor: pointer;
}
.new_list{
	height: 520px;
    overflow: scroll;
}
.comments{
	 height: 472px;
    overflow: scroll;
}
.new_list .activated a,.new_list .activated span,.new_list .activated{
	color: red;
	font-weight: bold;
}
#new_title {
    color: #FF0000;
    font-weight: bold;
}
.errmsg{
	color: red;
}
</style>
