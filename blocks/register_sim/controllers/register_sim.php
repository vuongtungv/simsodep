<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/register_sim/models/register_sim.php';
	
class Register_simBControllersRegister_sim {
	function __construct() {
	}
	function display($parameters, $title, $id = null) {

		$style = $parameters->getParams ( 'style' );
		$suffix = $parameters->getParams ( 'suffix' );
		$category_id = $parameters->getParams ( 'category_id' );
		$text_pos = $parameters->getParams ( 'text_pos' );

		$out_id = $parameters->getParams ( 'id' );
			
		$style = $style ? $style : 'default';
	
		// call models
		$model = new Register_simBModelsRegister_sim();
//		$list = $model->getList($category_id);
        $show_netname = $model->show_netname();

        $regis_default = $model->regis_default($show_netname[0]->network_id);

//        testVar($show_netname);


//		if(!$list)
//			return;
		// call views
		include 'blocks/register_sim/views/register_sim/'.$style.'.php';
		}
	}
	
?>