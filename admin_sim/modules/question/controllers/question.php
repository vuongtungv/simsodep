<?php
class QuestionControllersQuestion extends Controllers{
    function __construct(){
        parent::__construct();
        $this->view = 'question';
    }

    function display(){
        parent::display();
        $sort_field = $this->sort_field;
        $sort_direct = $this->sort_direct;

        $model = $this->model;
        $groups = $this->model->get_groups();
        $list = $model->get_data();

        $proCats = $this->model->get_product_cats();
        $list_key = array();
        $pagination = $model->getPagination('');
        include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
    }

    function add(){
        $groups = $this->model->get_groups();
        // $categories = $this->model->get_categories_tree();
        $maxOrdering = $this->model->getMaxOrdering();
        $uploadConfig = base64_encode('add|' . session_id());
        $proCats = $this->model->get_product_cats();
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    function edit(){
        $ids = FSInput::get('id', array(), 'array');
        $id = $ids[0];
        $groups = $this->model->get_groups();
        // $categories = $this->model->get_categories_tree();
        $data = $this->model->get_record_by_id($id);
        $answers = $this->model->get_answers($data->id);
        $proCats = $this->model->get_product_cats();
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    function add_param(){
        $results_id = FSInput::get('results_id');
        $model = $this->model;
        $created_link = $model->get_linked_id();
        if (!$created_link)
            return;

        $field_display = $created_link->add_field_display;
        $field_value = $created_link->add_field_value;
        $add_param = $created_link->add_parameter;

        $arr_field_value = explode(',', $field_value);
        $arr_add_param = explode(',', $add_param);


        $list = $model->get_data_from_table($created_link->add_table, $field_display, $field_value, $created_link->add_field_distinct);
        $pagination = $model->get_pagination_create_link($created_link->add_table, $field_display, $field_value, $created_link->add_field_distinct);

        include 'modules/' . $this->module . '/views/news/add_param.php';
    }

    function is_hot(){
        $this->is_check('is_hot', 1, 'is_hot');
    }

    function unis_hot(){
        $this->unis_check('is_hot', 0, 'un_hot');
    }

    function is_new(){
        $this->is_check('is_new', 1, 'is_new');
    }

    function unis_new(){
        $this->unis_check('is_new', 0, 'un_new');
    }

    function show_in_homepage(){
        $this->is_check('show_in_homepage', 1, 'show home');
    }

    function unshow_in_homepage(){
        $this->unis_check('show_in_homepage', 0, 'un home');
    }

    function is_slideshow(){
        $this->is_check('is_slide', 1, 'show slideshow');
    }

    function unis_slideshow(){
        $this->unis_check('is_slide', 0, 'un slideshow');
    }

    function is_new_video(){
        $this->is_check('is_new_video', 1, 'show news dưới slide');
    }

    function unis_new_video(){
        $this->unis_check('is_new_video', 0, 'un news dưới slide');
    }

    function view_comment($new_id){
        $link = 'index.php?module=news&view=comments&keysearch=&text_count=1&text0=' . $new_id . '&filter_count=1&filter0=0';
        return '<a href="' . $link . '" target="_blink">Comment</a>';
    }

    function view_title($data){
        $link = FSRoute::_('index.php?module=news&view=news&id=' . $data->id . '&code=' . $data->alias . '&ccode=' . $data->category_alias);
        return '<a target="_blink" href="' . $link . '" title="Xem ngoài font-end">' . $data->title . '</a>';
    }

    function get_products_by_cat(){
        $html = '<option value="0">Chọn sản phẩm</option>';
        $cat_id = FSInput::get('cat_id', 0);
        $product_id = FSInput::get('product_id', 0);
        $list = $this->model->get_records('course_id='.intval($cat_id), 'fs_course');
        foreach ($list as $item)
            $html .= '<option '.($product_id==$item->id?'selected="selected"':'').' value="'.$item->id.'">'.$item->coursename.'</option>';
        echo $html;
    }
    function fixtest()
    {
        $this->is_check('fixtest',1,'fixtest');
    }
    function unfixtest()
    {
        $this->unis_check('fixtest',0,'fixtest');
    }
}