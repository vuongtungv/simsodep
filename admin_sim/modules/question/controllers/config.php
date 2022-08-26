<?php
class QuestionControllersConfig  extends Controllers{
	function __construct(){
		parent::__construct();
	}

	function display(){
		$data = $this->model->getData();
		$groups = $this->model->get_groups();
		include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
	}

	function save(){
		$cid = $this->model->save();
		if ($cid) {
			setRedirect('index.php?module=question&view=config', FSText:: _('Saved'));
		} else {
			setRedirect("index.php?module=question&view=config", FSText:: _('Not save'), 'error');
		}
	}
}