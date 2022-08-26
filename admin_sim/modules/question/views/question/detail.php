<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png',1);
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png',1);
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png', 1);
$toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');
echo ' 	<div class="alert alert-danger" style="display: none" >
            <span id="msg_error"></span>
        </div>';
$this -> dt_form_begin(1,4,$title.' '.FSText::_('câu hỏi'),'fa-edit',1,'col-md-12',1);
// TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 10,0);
TemplateHelper::dt_edit_selectbox(FSText::_('Groups'),'group_id',@$data -> group_id,0,$groups,$field_value = 'id', $field_label='name',$size = 10, 0, 1);?>
<div class="form-group form-group-product hidden">
    <label class="col-sm-3 col-xs-12 control-label">
        <?php echo FSText::_('Categories')?>
    </label>
    <div class="col-sm-9 col-xs-12">
        <select id="cat_id" name="cat_id" class="form-control chosen-select chosen-select-deselect">
            <option value="0">Chọn danh mục</option>
            <?php foreach ($proCats as $item) { ?>
                <option <?php if(isset($data) && $data->cat_id == $item->id) echo 'selected="selected"'?> value="<?php echo $item->id ?>" ><?php echo $item->name ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group form-group-product hidden">
    <label class="col-sm-3 col-xs-12 control-label">
        <?php echo FSText::_('Sản phẩm')?>
    </label>
    <div class="col-sm-9 col-xs-12">
        <select id="product_id" name="product_id" data-id="<?php if(isset($data)) echo $data->product_id; else echo 0;?>" class="form-control chosen-select chosen-select-deselect">
            <option value="0">Chọn sản phẩm</option>
        </select>
    </div>
</div>
<?php
TemplateHelper::dt_edit_text(FSText :: _('Câu hỏi'),'name', strip_tags(@$data -> name));
// TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/small/',URL_ROOT.@$data->image));
?>
<div class="form-group">
    <label class="col-sm-3 col-xs-12 control-label">
        Trả lời
    </label>
    <div class="col-sm-9 col-xs-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Đáp án</th>
                    <th  class="text-center" style="width: 75px;">Đúng</th>
                </tr>
            </thead>
            <tbody>
            <?php for($i=0; $i<6; $i++){ ?>
                <tr>
                    <td>
                        <textarea name="answers_title[<?php echo $i?>]" rows="1" class="form-control answers_title"><?php if(isset($answers[$i])) echo $answers[$i]->answer;  ?></textarea>
                    </td>
                    <td class="text-center">
                        <input class="answers_true" <?php if(isset($answers[$i]) && $answers[$i]->true) echo 'checked';?> type="checkbox" name="answers_true[<?php echo $i?>]" value="1">
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php
TemplateHelper::dt_checkbox(FSText::_('Cố định'),'fixtest',@$data -> fixtest,0,'','','','col-sm-3','col-sm-9');
TemplateHelper::datetimepicke( FSText :: _('Published time' ), 'created_time', @$data->created_time?@$data->created_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20,'','col-md-3','col-md-4');
TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1,'','','','col-sm-3','col-sm-9');
$this->dt_form_end_col();
?>
<?php $this -> dt_form_end(@$data, 1, 0, 2,'Cấu hình seo','',1,'col-sm-4'); ?>
<script type="text/javascript">
    $('.form-horizontal').keypress(function (e) {
        if (e.which == 13) {
            formValidator();
            return false;
        }
    });

    function formValidator(){
        if ($('#group_id').val() == 0) {
            /* document.getElementById('msg_error').innerHTML = "Bạn chưa chọn danh mục";
             $('#msg_error').parent().show();*/
            alert('Bạn chưa chọn nhóm');
            $('#group_id').focus();
            return false;
        }

        if($('#group_id').val() == 1){
            if ($('#cat_id').val() == 0) {
                /* document.getElementById('msg_error').innerHTML = "Bạn chưa chọn danh mục";
                 $('#msg_error').parent().show();*/
                alert('Bạn chưa chọn danh mục');
                $('#cat_id').focus();
                return false;
            }

            if ($('#product_id').val() == 0) {
                /* document.getElementById('msg_error').innerHTML = "Bạn chưa chọn sản phẩm";
                 $('#msg_error').parent().show();*/
                alert('Bạn chưa chọn sản phẩm');
                $('#product_id').focus();
                return false;
            }
        }

        if ($('input#name').val().trim() == '') {
            /* document.getElementById('msg_error').innerHTML = "Bạn chưa nhập câu hỏi";
            $('#msg_error').parent().show();*/
            alert('Bạn chưa nhập câu hỏi');
            $('input#name').focus();
            return false;
        }

        var $ckAnswer = false;
        var $i = 0;
        $('textarea.answers_title').each(function(){
            if($(this).val().trim() != '') {
                $ckAnswer = true;
                $i++;
            }
        });
        if($ckAnswer == false){
            /* document.getElementById('msg_error').innerHTML = "Bạn chưa nhập đáp án";
            $('#msg_error').parent().show(); */
            alert('Bạn chưa nhập đáp án');
            $('input#name').focus();
            return false;
        }
        if($i < 2){
            /* document.getElementById('msg_error').innerHTML = "Bạn chưa nhập đáp án";
             $('#msg_error').parent().show(); */
            alert('Bạn phải nhập ít nhất 2 đáp án');
            $('input#name').focus();
            return false;
        }

        var $ckAnswer = false;
        $('input.answers_true').each(function(){
            if($(this).is(':checked'))
                $ckAnswer = true;
        });
        if($ckAnswer == false){
            /* document.getElementById('msg_error').innerHTML = "Bạn chưa nhập đáp án";
             $('#msg_error').parent().show(); */
            alert('Bạn phải lựa chọn ít nhất 1 đáp án đúng');
            $('input#name').focus();
            return false;
        }

        return true;
    }

    function getProductsByCat($cat_id){
        $product_id = $('#product_id').attr('data-id');
        $.ajax({
            type: "POST",
            url: "index.php?module=question&view=question&raw=1&task=get_products_by_cat",
            data: {"cat_id":$cat_id, "product_id":$product_id},
            dataType: 'html',
            success: function(data) {
                $('#product_id').html(data);
                $('#product_id').trigger("chosen:updated");
            }
        });
    }

    $(document).ready(function () {

        if($('#group_id').val() == 1){
            $('.form-group-product').removeClass('hidden');
        }

        $('#group_id').change(function () {
            if($(this).val() == 1){
                $('.form-group-product').removeClass('hidden');
            } else {
                $('.form-group-product').addClass('hidden');
            }
        });

        $('#cat_id').change(function () {
            getProductsByCat($(this).val());
        });

        getProductsByCat($('#cat_id').val());
    });
</script>