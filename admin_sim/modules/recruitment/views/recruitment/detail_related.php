<div class="contents_related">
	<table width="100%" bordercolor="#AAA" border="1">
		<tr valign="top">
			<td width="0%" id='contents_related_l' style="display:none" >
				<div class='contents_related_search'>
					<span>Tìm kiếm: </span>
					<input type="text" name='contents_related_keyword' value='' id='contents_related_keyword' />
					<select name="contents_related_category_id"  id="contents_related_category_id">
						<option value="">Danh mục</option>
						<?php 
						foreach ($categories as $item) {
						?>
							<option value="<?php echo $item->id; ?>" ><?php echo $item->treename;  ?> </option>	
						<?php }?>
					</select>
					<input type="button" name='contents_related_search' value='Tìm kiếm' id='contents_related_search' />
				</div>
				<div id='contents_related_search_list'>
				</div>
			</td>
			<td width="100%" id='contents_related_r'>
				<!--	LIST RELATE			-->
				<div class='title'>Tin liên quan</div>
					<ul id='contents_sortable_related'>	
						<?php
						$i = 0; 
						if(isset($contents_related))
						foreach ($contents_related as $item) { 
						?>
							<li id='contents_record_related_<?php echo $item ->id?>'><?php echo $item -> title; ?> 
								<a class='contents_remove_relate_bt'  onclick="javascript: remove_contents_related(<?php echo $item->id?>)" href="javascript: void(0)" title='Xóa'>
									<img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png">
								</a> 
								<br />
								<img onerror="this.src='/images/1443089194_picture-01.png'" src="<?php echo URL_ROOT.str_replace('/original/','/small/',$item->image);?>">
								<input type="hidden" name='contents_record_related[]' value="<?php echo $item -> id;?>" />
							</li>
						<?php }?>
					</ul>
				<!--	end LIST RELATE			-->
				<div id='contents_record_related_continue'></div>
			</td>
		</tr>
	</table>
	<div class='contents_close_related' style="display:none">
		<a href="javascript:contents_close_related()"><strong class='red'>Đóng</strong></a>
	</div>
	<div class='contents_add_related'>
		<a href="javascript:contents_add_related()"><strong class='red'>Thêm tin liên quan</strong></a>
	</div>
</div>
<script type="text/javascript" >
search_contents_related();
$( "#contents_sortable_related" ).sortable();
function contents_add_related(){
	$('#contents_related_l').show();
	$('#contents_related_l').attr('width','50%');
	$('#contents_related_r').attr('width','50%');		
	$('.contents_close_related').show();
	$('.contents_add_related').hide();
}
function contents_close_related(){
	$('#contents_related_l').hide();
	$('#contents_related_l').attr('width','0%');
	$('#contents_related_r').attr('width','100%');		
	$('.contents_add_related').show();
	$('.contents_close_related').hide();
}
function search_contents_related(){
	$('#contents_related_search').click(function(){
		var keyword = $('#contents_related_keyword').val();
		var category_id = $('#contents_related_category_id').val();
		var content_id = <?php echo @$data -> id?$data -> id:0?>;
		var str_exist = '';
		$( "#contents_sortable_related li input" ).each(function( index ) {
			if(str_exist != '')
				str_exist += ',';
			str_exist += 	$( this ).val();
		});
		$.get("index2.php?module=contents&view=contents&task=ajax_get_contents_related&raw=1",{content_id:content_id,category_id:category_id,keyword:keyword,str_exist:str_exist}, function(html){
			$('#contents_related_search_list').html(html);
		});
	});
}
function set_contents_related(id){
	var max_related = 10;
	var length_children = $( "#contents_sortable_related li" ).length;
	if(length_children >= max_related ){
		alert('Tối đa chỉ có '+max_related+' tin liên quan'	);
		return;
	}
	var title = $('.contents_related_item_'+id).html();                                     
	var html = '<li id="record_related_'+id+'">'+title+'<input type="hidden" name="contents_record_related[]" value="'+id+'" />';
	html += '<a class="contents_remove_relate_bt"  onclick="javascript: remove_contents_related('+id+')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
	html += '</li>';
	$('#contents_sortable_related').append(html);
	$('.contents_related_item_'+id).hide();	
}
function remove_contents_related(id){
	$('#contents_record_related_'+id).remove();
	$('.contents_related_item_'+id).show().addClass('red');	
}
</script>
<style>
.contents_related_search, #contents_related_r .title{
	 background: none repeat scroll 0 0 #F0F1F5;
    font-weight: bold;
    margin-bottom: 4px;
    padding: 2px 0 4px;
    text-align: center;
}
#contents_related_search_list{
	height: 400px;
    overflow: scroll;
}
.contents_related_item{
	background: url("/admin/images/page_next.gif") no-repeat scroll right center transparent;
    border-bottom: 1px solid #EEEEEE;
    cursor: pointer;
    margin: 2px 10px;
    padding: 5px;
}
#contents_sortable_related li{
	cursor: move;
    list-style: decimal outside none;
    margin-bottom: 8px;
}
.contents_remove_relate_bt{
	padding-left: 10px;
}
.contents_related table{
	margin-bottom: 5px;
}
</style>