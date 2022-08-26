<div class="products_related">
    <div class="row">
            <div class="col-xs-12">
                <div class='products_related_search row'>
                    <div class="row-item col-xs-6" style="margin-bottom: 20px;">
    					<select class="form-control chosen-select"  name="products_related_category_id"  id="products_related_category_id">
    						<option value="">Danh mục</option>
    						<?php 
    						foreach ($categories_products as $item) {
    						?>
    							<option value="<?php echo $item->id; ?>" ><?php echo $item->treename;  ?> </option>	
    						<?php }?>
    					</select>
                    </div>
                    <div class="row-item col-xs-6">
                        <div class="input-group custom-search-form">
                            <input type="text" placeholder="Tìm kiếm" name='products_related_keyword' class="form-control" value='' id='products_related_keyword' />
                            <span class="input-group-btn">
                                <a id='products_related_search' class="btn btn-default">
                                    <i class="fa fa-search"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>    
            <div class="col-xs-12 col-md-6">
                <div class='title-related'>Danh sách sản phẩm</div>            
                <div id='products_related_l' >                
    				<div id='products_related_search_list'></div>
    			</div>
            </div>
            
    		<div class="col-xs-12 col-md-6">
    			<div id='products_related_r'>
    				<!--	LIST RELATE			-->
    				<div class='title-related'>Sản phẩm liên quan</div>
					<ul id='products_sortable_related'>	
						<?php
						$i = 0; 
						if(isset($products_related))
						foreach ($products_related as $item) { 
						?>
							<li id='products_record_related_<?php echo $item ->id?>'><?php echo $item -> name; ?> 
								<a class='products_remove_relate_bt'  onclick="javascript: remove_products_related(<?php echo $item->id?>)" href="javascript: void(0)" title='Xóa'>
									<img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png">
								</a> 
								<br />
								<img  width="80" src="<?php echo URL_ROOT.str_replace('/original/','/resized/',$item->image);?>">
								<input type="hidden" name='products_record_related[]' value="<?php echo $item -> id;?>" />
							</li>
						<?php }?>
					</ul>
    				<!--	end LIST RELATE			-->
    				<div id='products_record_related_continue'></div>
    			</div>
    		</div>
            
            <!--<div class='products_close_related col-xs-12' style="display:none">
        		<a href="javascript:products_close_related()"><strong class='red'>Đóng</strong></a>
        	</div>
        	<div class='products_add_related col-xs-12'>
        		<a href="javascript:products_add_related()"><strong class='red'>Thêm sản phẩm liên quan</strong></a>
        	</div> -->
    </div>
</div>
<script type="text/javascript" >
//search_products_related();
$( "#products_sortable_related" ).sortable();
function products_add_related(){
	$('#products_related_l').show();
	$('#products_related_l').attr('width','50%');
	$('#products_related_r').attr('width','50%');		
	$('.products_close_related').show();
	$('.products_add_related').hide();
}
function products_close_related(){
	$('#products_related_l').hide();
	$('#products_related_l').attr('width','0%');
	$('#products_related_r').attr('width','100%');		
	$('.products_add_related').show();
	$('.products_close_related').hide();
}
//function search_products_related(){
	$('#products_related_search').on('click',function(){
		var keyword = $('#products_related_keyword').val();
		var category_id = $('#products_related_category_id').val();	
		var product_id = <?php echo @$data -> id?$data -> id:0?>;
		var str_exist = '';
		$( "#products_sortable_related li input" ).each(function( index ) {
			if(str_exist != '')
				str_exist += ',';
			str_exist += 	$( this ).val();
		});
		$.get("index2.php?module=products&view=products&task=ajax_get_products_related&raw=1",{product_id:product_id,category_id:category_id,keyword:keyword,str_exist:str_exist}, function(html){
			$('#products_related_search_list').html(html);
		});
	});
//}
function set_products_related(id){
	var max_related = 10;
	var length_children = $( "#products_sortable_related li" ).length;
	if(length_children >= max_related ){
		alert('Tối đa chỉ có '+max_related+' sản phẩm liên quan'	);
		return;
	}
	var title = $('.products_related_item_'+id).html();                                     
	var html = '<li id="products_record_related_'+id+'">'+title+'<input type="hidden" name="products_record_related[]" value="'+id+'" />';
	html += '<a class="products_remove_relate_bt"  onclick="javascript: remove_products_related('+id+')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
	html += '</li>';
	$('#products_sortable_related').append(html);
	$('.products_related_item_'+id).hide();	
}
function remove_products_related(id){
	$('#products_record_related_'+id).remove();
	$('.products_related_item_'+id).show().addClass('red');	
}
</script>
<style>
.title-related{
	 background: none repeat scroll 0 0 #F0F1F5;
    font-weight: bold;
    margin-bottom: 4px;
    padding: 2px 0 4px;
    text-align: center;
    width: 100%;
}
#products_related_search_list{
	height: 400px;
    overflow: scroll;
}
.products_related_item{
	background: url("/admin/images/page_next.gif") no-repeat scroll right center transparent;
    border-bottom: 1px solid #EEEEEE;
    cursor: pointer;
    margin: 2px 10px;
    padding: 5px;
}
#products_sortable_related li{
	cursor: move;
    list-style: decimal outside none;
    margin-bottom: 8px;
}
.products_remove_relate_bt{
	padding-left: 10px;
}
.products_related table{
	margin-bottom: 5px;
}
</style>