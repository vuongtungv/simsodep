<?php
function sim($sim = '',$price = ''){
	if (!$sim) {
		return;
	}

	// điều kiện sim năm sinh
	$year5x = array('1950');
	$year6x = array('1960');
	$year7x = array('1970');
	$year8x = array('1980');
	$year9x = array('1990');
	$year10x = array('2000');
	$year11x = array('2010');
	for ($x = 1951; $x < 1960; $x++) {
		array_push($year5x, $x);
	}
	for ($x = 1961; $x < 1970; $x++) {
		array_push($year6x, $x);
	}
	for ($x = 1971; $x < 1980; $x++) {
		array_push($year7x, $x);
	}
	for ($x = 1981; $x < 1990; $x++) {
		array_push($year8x, $x);
	}
	for ($x = 1991; $x < 2000; $x++) {
		array_push($year9x, $x);
	}
	for ($x = 2001; $x < 2010; $x++) {
		array_push($year10x, $x);
	}
	for ($x = 2011; $x < 2020; $x++) {
		array_push($year11x, $x);
	}

	// check lục quý
	$sort_sim = substr ( $sim, - 6 );
	$arr_lucquy = array(000000,111111,222222,333333,444444,555555,666666,777777,888888,999999);
	if (in_array($sort_sim, $arr_lucquy)){
		$type = 'Sim lục quý';
		if (substr($sim,0,4) == 0903 || substr($sim,0,4) == 0913 || substr($sim,0,4) == 0983) {
			$type .= ',Sim đầu số cổ';
		}
		return $type;
	}	
	// check ngũ quý
	$sort_sim = substr ( $sim, - 5 );
	$arr_nguquy = array(00000,11111,22222,33333,44444,55555,66666,77777,88888,99999);
	if (in_array($sort_sim, $arr_nguquy)){
		$type = 'Sim ngũ quý';
		if (substr($sim,0,4) == 0903 || substr($sim,0,4) == 0913 || substr($sim,0,4) == 0983) {
			$type .= ',Sim đầu số cổ';
		}
		return $type;
	}
	// check tứ quý
	$sort_sim = substr ( $sim, - 4 );
	switch ($sort_sim) {
		case 0000:
			$type = 'Sim tứ quý,Sim tứ quý 0000';
			break;
		case 1111:
			$type = 'Sim tứ quý,Sim tứ quý 1111';
			break;
		case 2222:
			$type = 'Sim tứ quý,Sim tứ quý 2222';
			break;
		case 3333:
			$type = 'Sim tứ quý,Sim tứ quý 3333';
			break;
		case 4444:
			$type = 'Sim tứ quý,Sim tứ quý 4444';
			break;
		case 5555:
			$type = 'Sim tứ quý,Sim tứ quý 5555';
			break;
		case 6666:
			$type = 'Sim tứ quý,Sim tứ quý 6666';
			break;
		case 7777:
			$type = 'Sim tứ quý,Sim tứ quý 7777';
			break;
		case 8888:
			$type = 'Sim tứ quý,Sim tứ quý 8888';
			break;
		case 9999:
			$type = 'Sim tứ quý,Sim tứ quý 9999';
			break;
	}
	if (@$type) {
		if (substr($sim,0,4) == 0903 || substr($sim,0,4) == 0913 || substr($sim,0,4) == 0983) {
			$type .= ',Sim đầu số cổ';
		}
		return $type;
	}

	// check taxi 2
	if (substr($sim,8,2) == substr($sim,6,2) && substr($sim,6,2) == substr($sim,4,2)) {
		$type = 'Sim taxi 2';
		if (substr($sim,0,4) == 0903 || substr($sim,0,4) == 0913 || substr($sim,0,4) == 0983) {
			$type .= ',Sim đầu số cổ';
		}
		// check năm sinh
		if (in_array(substr($sim,6,4), $year5x)){
			$type .= ',Sim năm sinh,Sim năm sinh 195x';
		}	
		if (in_array(substr($sim,6,4), $year6x)){
			$type .= ',Sim năm sinh,Sim năm sinh 196x';
		}	
		if (in_array(substr($sim,6,4), $year7x)){
			$type .= ',Sim năm sinh,Sim năm sinh 197x';
		}	
		if (in_array(substr($sim,6,4), $year8x)){
			$type .= ',Sim năm sinh,Sim năm sinh 198x';
		}	
		if (in_array(substr($sim,6,4), $year9x)){
			$type .= ',Sim năm sinh,Sim năm sinh 199x';
		}	
		if (in_array(substr($sim,6,4), $year10x)){
			$type .= ',Sim năm sinh,Sim năm sinh 200x';
		}	
		if (in_array(substr($sim,6,4), $year11x)){
			$type .= ',Sim năm sinh,Sim năm sinh 201x';
		}
		// check ngày tháng năm sinh
		if ((substr($sim,8,2) < 20 || substr($sim,8,2) > 49) && substr($sim,6,2) < 13 && substr($sim,6,2) > 0 && substr($sim,4,2) < 32 && substr($sim,4,2) > 0) {
			$type .= ',Năm sinh DD/MM/YY';
		}
		return $type;
	}

	// check taxi 3
	if (substr($sim,7,3) == substr($sim,4,3) && substr($sim,9,1) == substr($sim,7,1)) {
		$type = 'Sim taxi 3,Sim taxi ABA.ABA';
		if (substr($sim,0,4) == 0903 || substr($sim,0,4) == 0913 || substr($sim,0,4) == 0983) {
			$type .= ',Sim đầu số cổ';
		}
		// check năm sinh
		if (in_array(substr($sim,6,4), $year5x)){
			$type .= ',Sim năm sinh,Sim năm sinh 195x';
		}	
		if (in_array(substr($sim,6,4), $year6x)){
			$type .= ',Sim năm sinh,Sim năm sinh 196x';
		}	
		if (in_array(substr($sim,6,4), $year7x)){
			$type .= ',Sim năm sinh,Sim năm sinh 197x';
		}	
		if (in_array(substr($sim,6,4), $year8x)){
			$type .= ',Sim năm sinh,Sim năm sinh 198x';
		}	
		if (in_array(substr($sim,6,4), $year9x)){
			$type .= ',Sim năm sinh,Sim năm sinh 199x';
		}	
		if (in_array(substr($sim,6,4), $year10x)){
			$type .= ',Sim năm sinh,Sim năm sinh 200x';
		}	
		if (in_array(substr($sim,6,4), $year11x)){
			$type .= ',Sim năm sinh,Sim năm sinh 201x';
		}
		// check ngày tháng năm sinh
		if ((substr($sim,8,2) < 20 || substr($sim,8,2) > 49) && substr($sim,6,2) < 13 && substr($sim,6,2) > 0 && substr($sim,4,2) < 32 && substr($sim,4,2) > 0) {
			$type .= ',Năm sinh DD/MM/YY';
		}
		return $type;
	}
	if (substr($sim,7,3) == substr($sim,4,3) && substr($sim,7,1) == substr($sim,8,1)) {
		$type = 'Sim taxi 3,Sim taxi AAB.AAB';
		if (substr($sim,0,4) == 0903 || substr($sim,0,4) == 0913 || substr($sim,0,4) == 0983) {
			$type .= ',Sim đầu số cổ';
		}
		// check năm sinh
		if (in_array(substr($sim,6,4), $year5x)){
			$type .= ',Sim năm sinh,Sim năm sinh 195x';
		}	
		if (in_array(substr($sim,6,4), $year6x)){
			$type .= ',Sim năm sinh,Sim năm sinh 196x';
		}	
		if (in_array(substr($sim,6,4), $year7x)){
			$type .= ',Sim năm sinh,Sim năm sinh 197x';
		}	
		if (in_array(substr($sim,6,4), $year8x)){
			$type .= ',Sim năm sinh,Sim năm sinh 198x';
		}	
		if (in_array(substr($sim,6,4), $year9x)){
			$type .= ',Sim năm sinh,Sim năm sinh 199x';
		}	
		if (in_array(substr($sim,6,4), $year10x)){
			$type .= ',Sim năm sinh,Sim năm sinh 200x';
		}	
		if (in_array(substr($sim,6,4), $year11x)){
			$type .= ',Sim năm sinh,Sim năm sinh 201x';
		}
		// check ngày tháng năm sinh
		if ((substr($sim,8,2) < 20 || substr($sim,8,2) > 49) && substr($sim,6,2) < 13 && substr($sim,6,2) > 0 && substr($sim,4,2) < 32 && substr($sim,4,2) > 0) {
			$type .= ',Năm sinh DD/MM/YY';
		}
		return $type;
	}
	if (substr($sim,7,3) == substr($sim,4,3) && substr($sim,8,1) == substr($sim,9,1)) {
		$type = 'Sim taxi 3,Sim taxi BAA.BAA';
		if (substr($sim,0,4) == 0903 || substr($sim,0,4) == 0913 || substr($sim,0,4) == 0983) {
			$type .= ',Sim đầu số cổ';
		}
		// check năm sinh
		if (in_array(substr($sim,6,4), $year5x)){
			$type .= ',Sim năm sinh,Sim năm sinh 195x';
		}	
		if (in_array(substr($sim,6,4), $year6x)){
			$type .= ',Sim năm sinh,Sim năm sinh 196x';
		}	
		if (in_array(substr($sim,6,4), $year7x)){
			$type .= ',Sim năm sinh,Sim năm sinh 197x';
		}	
		if (in_array(substr($sim,6,4), $year8x)){
			$type .= ',Sim năm sinh,Sim năm sinh 198x';
		}	
		if (in_array(substr($sim,6,4), $year9x)){
			$type .= ',Sim năm sinh,Sim năm sinh 199x';
		}	
		if (in_array(substr($sim,6,4), $year10x)){
			$type .= ',Sim năm sinh,Sim năm sinh 200x';
		}	
		if (in_array(substr($sim,6,4), $year11x)){
			$type .= ',Sim năm sinh,Sim năm sinh 201x';
		}
		// check ngày tháng năm sinh
		if ((substr($sim,8,2) < 20 || substr($sim,8,2) > 49) && substr($sim,6,2) < 13 && substr($sim,6,2) > 0 && substr($sim,4,2) < 32 && substr($sim,4,2) > 0) {
			$type .= ',Năm sinh DD/MM/YY';
		}
		return $type;
	}
	if (substr($sim,7,3) == substr($sim,4,3)) {
		$type = 'Sim taxi 3,Sim taxi ABC.ABC';
		if (substr($sim,0,4) == 0903 || substr($sim,0,4) == 0913 || substr($sim,0,4) == 0983) {
			$type .= ',Sim đầu số cổ';
		}
		// check năm sinh
		if (in_array(substr($sim,6,4), $year5x)){
			$type .= ',Sim năm sinh,Sim năm sinh 195x';
		}	
		if (in_array(substr($sim,6,4), $year6x)){
			$type .= ',Sim năm sinh,Sim năm sinh 196x';
		}	
		if (in_array(substr($sim,6,4), $year7x)){
			$type .= ',Sim năm sinh,Sim năm sinh 197x';
		}	
		if (in_array(substr($sim,6,4), $year8x)){
			$type .= ',Sim năm sinh,Sim năm sinh 198x';
		}	
		if (in_array(substr($sim,6,4), $year9x)){
			$type .= ',Sim năm sinh,Sim năm sinh 199x';
		}	
		if (in_array(substr($sim,6,4), $year10x)){
			$type .= ',Sim năm sinh,Sim năm sinh 200x';
		}	
		if (in_array(substr($sim,6,4), $year11x)){
			$type .= ',Sim năm sinh,Sim năm sinh 201x';
		}
		// check ngày tháng năm sinh
		if ((substr($sim,8,2) < 20 || substr($sim,8,2) > 49) && substr($sim,6,2) < 13 && substr($sim,6,2) > 0 && substr($sim,4,2) < 32 && substr($sim,4,2) > 0) {
			$type .= ',Năm sinh DD/MM/YY';
		}
		return $type;
	}

	$type = '';

	// check tam hoa kép
	$sort_sim = substr ( $sim, 4, 3);
	$sort_sim2 = substr ( $sim, 7, 3);
	$arr_tamhoa = array(000,111,222,333,444,555,666,777,888,999);
	if (in_array($sort_sim, $arr_tamhoa) && in_array($sort_sim2, $arr_tamhoa)){
		$type = 'Sim tam hoa kép';
		if (substr($sim,0,4) == 0903 || substr($sim,0,4) == 0913 || substr($sim,0,4) == 0983) {
			$type .= ',Sim đầu số cổ';
		}
		// check năm sinh
		if (in_array(substr($sim,6,4), $year5x)){
			$type .= ',Sim năm sinh,Sim năm sinh 195x';
		}	
		if (in_array(substr($sim,6,4), $year6x)){
			$type .= ',Sim năm sinh,Sim năm sinh 196x';
		}	
		if (in_array(substr($sim,6,4), $year7x)){
			$type .= ',Sim năm sinh,Sim năm sinh 197x';
		}	
		if (in_array(substr($sim,6,4), $year8x)){
			$type .= ',Sim năm sinh,Sim năm sinh 198x';
		}	
		if (in_array(substr($sim,6,4), $year9x)){
			$type .= ',Sim năm sinh,Sim năm sinh 199x';
		}	
		if (in_array(substr($sim,6,4), $year10x)){
			$type .= ',Sim năm sinh,Sim năm sinh 200x';
		}	
		if (in_array(substr($sim,6,4), $year11x)){
			$type .= ',Sim năm sinh,Sim năm sinh 201x';
		}
		// check ngày tháng năm sinh
		if ((substr($sim,8,2) < 20 || substr($sim,8,2) > 49) && substr($sim,6,2) < 13 && substr($sim,6,2) > 0 && substr($sim,4,2) < 32 && substr($sim,4,2) > 0) {
			$type .= ',Năm sinh DD/MM/YY';
		}
		return $type;
	}

	// check taxi 4

	if (substr($sim,6,4) == substr($sim,2,4) && substr($sim,9,1) == substr($sim,8,1) && substr($sim,8,1) == substr($sim,7,1) && substr($sim,7,1) != substr($sim,6,1)) {
		$type .= 'Sim taxi 4,Sim taxi ABBB.ABBB';
	}
	if (substr($sim,6,4) == substr($sim,2,4) && substr($sim,9,1) != substr($sim,8,1) && substr($sim,8,1) == substr($sim,7,1) && substr($sim,7,1) == substr($sim,6,1)) {
		$type .= 'Sim taxi 4,Sim taxi AAAB.AAAB';
	}
	if (substr($sim,6,4) == substr($sim,2,4) && substr($sim,9,1) == substr($sim,6,1) && substr($sim,7,1) == substr($sim,8,1) && substr($sim,7,1) != substr($sim,6,1)) {
		$type .= 'Sim taxi 4,Sim taxi ABBA.ABBA';
	}
	if (substr($sim,6,4) == substr($sim,2,4) && substr($sim,9,1) == substr($sim,8,1) && substr($sim,8,1) != substr($sim,7,1) && substr($sim,7,1) == substr($sim,6,1)) {
		$type .= 'Sim taxi 4,Sim taxi AABB.AABB';
	}
	if (substr($sim,6,4) == substr($sim,2,4) && substr($sim,9,1) != substr($sim,8,1) && substr($sim,8,1) != substr($sim,7,1) && substr($sim,7,1) != substr($sim,6,1) && substr($sim,9,1) != substr($sim,6,1) && substr($sim,8,1) != substr($sim,6,1) && substr($sim,9,1) != substr($sim,7,1)) {
		$type .= 'Sim taxi 4,Sim taxi ABCD.ABCD';
	}
	if ( substr($sim,6,4) == substr($sim,2,4) && strpos($type, 'Sim taxi 4') === false) {
		$type .= 'Sim taxi 4,Sim taxi 4 khác';
	}


	//check tam hoa
	if (substr($sim,7,3) == '000') {
		$type .= ',Sim tam hoa,Sim tam hoa 000';
	}
	if (substr($sim,7,3) == '111') {
		$type .= ',Sim tam hoa,Sim tam hoa 111';
	}
	if (substr($sim,7,3) == '222') {
		$type .= ',Sim tam hoa,Sim tam hoa 222';
	}
	if (substr($sim,7,3) == '333') {
		$type .= ',Sim tam hoa,Sim tam hoa 333';
	}
	if (substr($sim,7,3) == '444') {
		$type .= ',Sim tam hoa,Sim tam hoa 444';
	}
	if (substr($sim,7,3) == '555') {
		$type .= ',Sim tam hoa,Sim tam hoa 555';
	}
	if (substr($sim,7,3) == '666') {
		$type .= ',Sim tam hoa,Sim tam hoa 666';
	}
	if (substr($sim,7,3) == '777') {
		$type .= ',Sim tam hoa,Sim tam hoa 777';
	}
	if (substr($sim,7,3) == '888') {
		$type .= ',Sim tam hoa,Sim tam hoa 888';
	}
	if (substr($sim,7,3) == '999') {
		$type .= ',Sim tam hoa,Sim tam hoa 999';
	}

	// check tiến đơn
	if ((substr($sim,9,1) - substr($sim,8,1) == 2) && (substr($sim,8,1) - substr($sim,7,1) == 2) && (substr($sim,7,1) - substr($sim,6,1) == 2)) {
		$type .= ',Sim tiến đơn,Sim tiến đơn đặc biệt';
	}
	if ((substr($sim,9,1) - substr($sim,8,1) == 1) && (substr($sim,8,1) - substr($sim,7,1) == 1) && (substr($sim,7,1) - substr($sim,6,1) == 1) && (substr($sim,6,1) - substr($sim,5,1) == 1) && (substr($sim,5,1) - substr($sim,4,1) == 1)) {
		$type .= ',Sim tiến đơn,Sim tiến đơn 6';
	}	
	if ((substr($sim,9,1) - substr($sim,8,1) == 1) && (substr($sim,8,1) - substr($sim,7,1) == 1) && (substr($sim,7,1) - substr($sim,6,1) == 1) && (substr($sim,6,1) - substr($sim,5,1) == 1) && (substr($sim,5,1) - substr($sim,4,1) != 1 || substr($sim,4,1) > substr($sim,5,1))) {
		$type .= ',Sim tiến đơn,Sim tiến đơn 5';
	}	
	if ((substr($sim,9,1) - substr($sim,8,1) == 1) && (substr($sim,8,1) - substr($sim,7,1) == 1) && (substr($sim,7,1) - substr($sim,6,1) == 1) && (substr($sim,6,1) - substr($sim,5,1) != 1 || substr($sim,5,1) > substr($sim,6,1))) {
		$type .= ',Sim tiến đơn,Sim tiến đơn 4';
	}	
	if ((substr($sim,9,1) - substr($sim,8,1) == 1) && (substr($sim,8,1) - substr($sim,7,1) == 1) && (substr($sim,7,1) - substr($sim,6,1) != 1 || substr($sim,6,1) > substr($sim,7,1))) {
		$type .= ',Sim tiến đơn,Sim tiến đơn 3';
	}	
	if ( (strpos($type, 'tiến') == false) && (substr($sim,9,1) > substr($sim,8,1)) && (substr($sim,8,1) > substr($sim,7,1)) && (substr($sim,7,1) > substr($sim,6,1)) ) {
		$type .= ',Sim tiến đơn,Sim tiến đơn khác';
	}

	// check số lặp
	if (substr($sim,8,2) == substr($sim,6,2) && substr($sim,6,2) != substr($sim,4,2)) {
		$type .= ',Sim số lặp';
	}

	// check số kép
	if (substr($sim,9,1) == substr($sim,8,1) && substr($sim,6,1) == substr($sim,7,1) && substr($sim,6,1) == substr($sim,5,1) && substr($sim,4,1) == substr($sim,5,1)) {
		$type .= ',Sim số kép,Sim số kép AAAA.BB';
	}
	if (substr($sim,8,2) == substr($sim,4,2) && substr($sim,9,1) == substr($sim,8,1) && substr($sim,8,1) == substr($sim,5,1) && substr($sim,6,1) == substr($sim,7,1)) {
		$type .= ',Sim số kép,Sim số kép AA.BB.AA';
	}	
	if (substr($sim,9,1) == substr($sim,8,1) && substr($sim,6,1) == substr($sim,7,1) && substr($sim,4,1) == substr($sim,5,1) && substr($sim,9,1) != substr($sim,4,1) && substr($sim,9,1) != substr($sim,7,1) && substr($sim,4,1) != substr($sim,7,1)) {
		$type .= ',Sim số kép,Sim số kép AA.BB.CC';
	}	
	if (substr($sim,9,1) == substr($sim,8,1) && substr($sim,6,1) == substr($sim,7,1) && substr($sim,4,1) != substr($sim,5,1)) {
		$type .= ',Sim số kép,Sim số kép AA.BB';
	}

	// check năm sinh
	if (in_array(substr($sim,6,4), $year5x)){
		$type .= ',Sim năm sinh,Sim năm sinh 195x';
	}	
	if (in_array(substr($sim,6,4), $year6x)){
		$type .= ',Sim năm sinh,Sim năm sinh 196x';
	}	
	if (in_array(substr($sim,6,4), $year7x)){
		$type .= ',Sim năm sinh,Sim năm sinh 197x';
	}	
	if (in_array(substr($sim,6,4), $year8x)){
		$type .= ',Sim năm sinh,Sim năm sinh 198x';
	}	
	if (in_array(substr($sim,6,4), $year9x)){
		$type .= ',Sim năm sinh,Sim năm sinh 199x';
	}	
	if (in_array(substr($sim,6,4), $year10x)){
		$type .= ',Sim năm sinh,Sim năm sinh 200x';
	}	
	if (in_array(substr($sim,6,4), $year11x)){
		$type .= ',Sim năm sinh,Sim năm sinh 201x';
	}

	// check lục quý giữa
 	if (strpos($sim,'000000') == TRUE || strpos($sim,'111111') == TRUE || strpos($sim,'222222') == TRUE || strpos($sim,'333333') == TRUE || strpos($sim,'444444') == TRUE || strpos($sim,'555555') == TRUE || strpos($sim,'666666') == TRUE || strpos($sim,'777777') == TRUE || strpos($sim,'888888') == TRUE || strpos($sim,'999999') == TRUE) {
		$type .= ',Sim lục quý giữa';
	}
	// check ngũ quý giữa
 	if ((strpos($sim,'000000') == FALSE && strpos($sim,'111111') == FALSE && strpos($sim,'222222') == FALSE && strpos($sim,'333333') == FALSE && strpos($sim,'444444') == FALSE && strpos($sim,'555555') == FALSE && strpos($sim,'666666') == FALSE && strpos($sim,'777777') == FALSE && strpos($sim,'888888') == FALSE && strpos($sim,'999999') == FALSE) && (strpos($sim,'00000') == TRUE || strpos($sim,'11111') == TRUE || strpos($sim,'22222') == TRUE || strpos($sim,'33333') == TRUE || strpos($sim,'44444') == TRUE || strpos($sim,'55555') == TRUE || strpos($sim,'66666') == TRUE || strpos($sim,'77777') == TRUE || strpos($sim,'88888') == TRUE || strpos($sim,'99999') == TRUE)) {
		$type .= ',Sim ngũ quý giữa';
	}	
	// check tứ quý giữa
 	if ((strpos($sim,'000000') == FALSE && strpos($sim,'111111') == FALSE && strpos($sim,'222222') == FALSE && strpos($sim,'333333') == FALSE && strpos($sim,'444444') == FALSE && strpos($sim,'555555') == FALSE && strpos($sim,'666666') == FALSE && strpos($sim,'777777') == FALSE && strpos($sim,'888888') == FALSE && strpos($sim,'999999') == FALSE) && (strpos($sim,'00000') == FALSE && strpos($sim,'11111') == FALSE && strpos($sim,'22222') == FALSE && strpos($sim,'33333') == FALSE && strpos($sim,'44444') == FALSE && strpos($sim,'55555') == FALSE && strpos($sim,'66666') == FALSE && strpos($sim,'77777') == FALSE && strpos($sim,'88888') == FALSE && strpos($sim,'99999') == FALSE) && (strpos($sim,'0000') == TRUE || strpos($sim,'1111') == TRUE || strpos($sim,'2222') == TRUE || strpos($sim,'3333') == TRUE || strpos($sim,'4444') == TRUE || strpos($sim,'5555') == TRUE || strpos($sim,'6666') == TRUE || strpos($sim,'7777') == TRUE || strpos($sim,'8888') == TRUE || strpos($sim,'9999') == TRUE)) {
		$type .= ',Sim tứ quý giữa';
	}

	//check gánh đảo
	if (substr($sim,6,4) != substr($sim,2,4) && (substr($sim,9,1) == substr($sim,6,1) && substr($sim,8,1) == substr($sim,7,1) && substr($sim,2,1) == substr($sim,5,1) && substr($sim,3,1) == substr($sim,4,1))) {
		$type .= ',Sim gánh đảo,Sim gánh đảo kép';
	}
	if (substr($sim,9,1) == substr($sim,6,1) && substr($sim,8,1) == substr($sim,7,1) && (substr($sim,2,1) != substr($sim,5,1) || substr($sim,3,1) != substr($sim,4,1)) ) {
		$type .= ',Sim gánh đảo,Sim gánh đảo đơn';
	}

	// check tiến kép
	if ((strpos($type, 'kép') == false) && (substr($sim,9,1) > substr($sim,6,1) && substr($sim,9,1) == substr($sim,8,1) && substr($sim,6,1) == substr($sim,5,1) && substr($sim,7,1) == substr($sim,4,1) && substr($sim,7,1) != substr($sim,8,1) && substr($sim,7,1) != substr($sim,6,1))) {
		$type .= ',Sim tiến kép,Sim tiến kép ABB.ACC';
	}
	if ((strpos($type, 'kép') == false) && (substr($sim,9,1) == substr($sim,6,1) && substr($sim,8,1) == substr($sim,7,1) && substr($sim,5,1) == substr($sim,4,1) && substr($sim,8,1) > substr($sim,5,1))) {
		$type .= ',Sim tiến kép,Sim tiến kép AAC.BBC';
	}
	if ((strpos($type, 'kép') == false) && (substr($sim,9,1) == substr($sim,8,1) && substr($sim,6,1) == substr($sim,5,1) && substr($sim,8,1) > substr($sim,5,1) && substr($sim,7,1) > substr($sim,4,1))) {
		$type .= ',Sim tiến kép,Sim tiến kép khác';
	}

	// check soi gương
	if (substr($sim,9,1) == substr($sim,4,1) && substr($sim,9,1) != substr($sim,8,1) && substr($sim,8,1) == substr($sim,5,1) && substr($sim,6,1) == substr($sim,7,1)) {
		$type .= ',Sim soi gương';
	}

	// check tiến ba
	if (substr($sim,6,4) != substr($sim,2,4) && substr($sim,7,2) == substr($sim,4,2) && substr($sim,4,1) == substr($sim,5,1) && substr($sim,9,1) > substr($sim,6,1)) {
		$type .= ',Sim tiến ba,Sim tiến ba AAB.AAC';
	}
 	if (substr($sim,6,4) != substr($sim,2,4) && substr($sim,8,2) == substr($sim,5,2) && substr($sim,6,1) != substr($sim,5,1) && substr($sim,7,1) > substr($sim,4,1)) {
		$type .= ',Sim tiến ba,Sim tiến ba CAB.DAB';
	} 	
	if (substr($sim,6,4) != substr($sim,2,4) && substr($sim,7,2) == substr($sim,4,2) && substr($sim,4,1) != substr($sim,5,1) && substr($sim,9,1) > substr($sim,6,1)) {
		$type .= ',Sim tiến ba,Sim tiến ba ABC.ABD';
	}
	if (strpos($type, 'gánh') == false && substr($sim,6,4) != substr($sim,2,4) && substr($sim,4,1) != substr($sim,6,1) && substr($sim,9,1) == substr($sim,6,1) && substr($sim,4,1) == substr($sim,7,1) && substr($sim,8,1) > substr($sim,5,1)) {
		$type .= ',Sim tiến ba,Sim tiến ba ACB.ADB';
	}
	if (substr($sim,6,4) != substr($sim,2,4) && substr($sim,8,2) == substr($sim,5,2) && substr($sim,6,1) == substr($sim,5,1) && substr($sim,7,1) > substr($sim,4,1)) {
		$type .= ',Sim tiến ba,Sim tiến ba ACC.BCC';
	}

	// check tiến đôi
	if ((((substr($sim,9,1) - substr($sim,7,1) == 1 ) && (substr($sim,7,1) - substr($sim,5,1) == 1 ) && substr($sim,8,1) == substr($sim,6,1) && substr($sim,6,1) == substr($sim,4,1)) || ((substr($sim,8,1) - substr($sim,6,1) == 1 ) && (substr($sim,6,1) - substr($sim,4,1) == 1 ) && substr($sim,9,1) == substr($sim,7,1) && substr($sim,7,1) == substr($sim,5,1))) ) {
		$type .= ',Sim tiến đôi,Sim tiến 3 đôi cuối';
	}
	if ( (substr($sim,6,4) != '8386') && (strpos($type, 'tam hoa') == false) && (strpos($type, 'tiến') == false) && (strpos($type, 'giữa') == false) && substr($sim,6,4) != substr($sim,2,4) && ( (substr($sim,9,1) == substr($sim,7,1) && substr($sim,7,1) == substr($sim,5,1) && (substr($sim,8,1) - substr($sim,6,1) >= 1 ) && (substr($sim,6,1) - substr($sim,4,1) >= 1 ) ) || (substr($sim,8,1) == substr($sim,6,1) && substr($sim,6,1) == substr($sim,4,1) && (substr($sim,9,1) - substr($sim,7,1) >= 1 ) && (substr($sim,7,1) - substr($sim,5,1) >= 1 )) )) {
		$type .= ',Sim tiến đôi,Sim tiến đôi khác';
	}
	if (substr($sim,6,4) != substr($sim,2,4)&& (strpos($type, 'tiến') == false) && ( ((substr($sim,9,1) - substr($sim,7,1) == 1 ) && substr($sim,6,1) != substr($sim,7,1) && substr($sim,8,1) == substr($sim,6,1) && (substr($sim,7,1) - substr($sim,5,1) != 1 || substr($sim,4,1) != substr($sim,6,1))) || ((substr($sim,8,1) - substr($sim,6,1) == 1 ) && substr($sim,8,1) != substr($sim,7,1) && (substr($sim,6,1) - substr($sim,4,1) != 1 || substr($sim,5,1) != substr($sim,7,1) ) && substr($sim,9,1) == substr($sim,7,1)) ) ) {
		$type .= ',Sim tiến đôi,Sim tiến 2 đôi cuối';
	}

	// check số gánh
	if ( (strpos($type, 'tiến') == false) && substr($sim,6,2) != substr($sim,8,2) && substr($sim,9,1) == substr($sim,7,1) && substr($sim,7,1) != substr($sim,6,1) && substr($sim,6,1) == substr($sim,4,1) && substr($sim,9,1) != substr($sim,8,1) && substr($sim,8,1) == substr($sim,5,1)) {
		$type .= ',Sim số gánh,Sim số gánh ACA.BCB';
	}
	if ( (strpos($type, 'tiến') == false) && substr($sim,9,1) == substr($sim,7,1) && substr($sim,7,1) == substr($sim,6,1) && substr($sim,6,1) == substr($sim,4,1) && substr($sim,9,1) != substr($sim,8,1) && substr($sim,8,1) != substr($sim,5,1)) {
		$type .= ',Sim số gánh,Sim số gánh ABA.ACA';
	}
 	if ( (strpos($type, 'tiến') == false) && substr($sim,9,1) == substr($sim,7,1) && substr($sim,4,1) == substr($sim,6,1) && substr($sim,7,1) != substr($sim,8,1) && substr($sim,8,1) != substr($sim,5,1) && substr($sim,6,1) != substr($sim,7,1)) {
		$type .= ',Sim số gánh,Sim số gánh ABA.CDC';
	}
	if ( (strpos($type, 'tiến') == false) && substr($sim,6,4) != substr($sim,2,4) && substr($sim,9,1) == substr($sim,7,1) && substr($sim,4,1) != substr($sim,6,1) && substr($sim,6,1) != substr($sim,8,1) && substr($sim,9,1) != substr($sim,8,1)) {
		$type .= ',Sim số gánh,Sim số gánh ABA';
	}


	// check đặc biêt
	if (substr($sim,6,4) == '1102') {
		$type .= ',Sim đặc biệt,Nhất nhất không nhì';
	}
	if (substr($sim,6,4) == '1368') {
		$type .= ',Sim đặc biệt,Sinh tài lộc phát';
	}
	if (substr($sim,6,4) == '4078') {
		$type .= ',Sim đặc biệt,Bốn mùa không thất bát';
	}
	if (substr($sim,6,4) == '8386') {
		$type .= ',Sim đặc biệt,Phát tài phát lộc';
	}
	if (substr($sim,6,4) == '8683') {
		$type .= ',Sim đặc biệt,Phát lộc phát tài';
	}
	if (substr($sim,6,4) == '8910') {
		$type .= ',Sim đặc biệt,Cao hơn người';
	}
	if (substr($sim,4,6) == '151618') {
		$type .= ',Sim đặc biệt,Mỗi năm mỗi lộc mỗi phát';
	}	
	if (substr($sim,4,6) == '049053') {
		$type .= ',Sim đặc biệt,Không gặp hạn';
	}

	// check ngày tháng năm sinh
	if ((substr($sim,8,2) < 20 || substr($sim,8,2) > 49) && substr($sim,6,2) < 13 && substr($sim,6,2) > 0 && substr($sim,4,2) < 32 && substr($sim,4,2) > 0) {
		$type .= ',Năm sinh DD/MM/YY';
	}

	// check lộc phát
	if (substr($sim,8,2) == 68 || substr($sim,8,2) == 86){
		$type .= ',Sim lộc phát';
	}

	// check thần tài
	if (substr($sim,8,2) == 39 || substr($sim,8,2) == 79) {
		$type .= ',Sim thần tài';
	}

	// check ông địa
	if (substr($sim,8,2) == 38 || substr($sim,8,2) == 78) {
		$type .= ',Sim ông địa';
	}

	// check tiến giữa
	if ( (((substr($sim,7,1) - substr($sim,6,1) == 1) && (substr($sim,6,1) - substr($sim,5,1) == 1) && (substr($sim,5,1) - substr($sim,4,1) == 1)) || ((substr($sim,6,1) - substr($sim,5,1) == 1) && (substr($sim,5,1) - substr($sim,4,1) == 1) && (substr($sim,4,1) - substr($sim,3,1) == 1) ) || ((substr($sim,5,1) - substr($sim,4,1) == 1) && (substr($sim,4,1) - substr($sim,3,1) == 1) && (substr($sim,3,1) - substr($sim,2,1) == 1) )) && (substr($sim,9,1) - substr($sim,8,1) != 1) ) {
		$type .= ',Sim tiến giữa';
	}

	// check đầu số cổ
	if (substr($sim,0,4) == '0903' || substr($sim,0,4) == '0913' || substr($sim,0,4) == '0983') {
		$type .= ',Sim đầu số cổ';
	}

	// check giá rẻ
	if($price < 500000){
		$type .= ',Sim giá rẻ';
	}

	if ($type == '') {
		$type .= ',Sim dễ nhớ';
	}

	$type = trim( $type, ',');

	return $type;
}

	function check_type_tu_quy_giua($sim, $key = '') {
		if (! $sim)
			return false;
		$sort_sim = $sim;
		$count_repeat = 0;
		$current_number = null;

		// duyệt các số trước số cuối ( 7 số)
		if ($key) {
			for($i = 0; $i < strlen($sort_sim); $i ++) {
				if ($sort_sim [$i] == $key) {
					$count_repeat ++;
					if ($count_repeat == 4){
						if($sort_sim [$i + 1] != $key && $i != (strlen($sort_sim)-1) )
							return true;
					}
						
				} else {
					$count_repeat = 1;
				}
			}
		} else {
			for($i = 0; $i < strlen($sort_sim); $i ++) {
				if ($sort_sim [$i] == $current_number) {
					$count_repeat ++;
					if ($count_repeat == 4){
						if($sort_sim [$i + 1] != $current_number &&  $i != (strlen($sort_sim)-1))
							return true;
					}
				} else {
					$current_number = $sort_sim [$i];
					$count_repeat = 1;
				}
			}
		}
		return false;
	}

function strip_tags_content($text, $tags = '', $invert = FALSE) { 

  preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags); 
  $tags = array_unique($tags[1]); 
    
  if(is_array($tags) AND count($tags) > 0) { 
    if($invert == FALSE) { 
      return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text); 
    } 
    else { 
      return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text); 
    } 
  } 
  elseif($invert == FALSE) { 
    return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text); 
  } 
  return $text; 
}

function clean($string = '') {
    $string =  str_replace("'", '', $string);
    $string =  str_replace('(', '', $string);
    $string =  str_replace(')', '', $string);
    $string =  str_replace('UNION', '', $string);
    $string =  str_replace('union', '', $string);
    $string =  str_replace('select', '', $string);
    $string =  str_replace('SELECT', '', $string);
    $string =  str_replace('CONCAT', '', $string);
    $string =  str_replace('concat', '', $string);
    $string =  str_replace('count', '', $string);
    $string =  str_replace('COUNT', '', $string);
    $string =  str_replace('from', '', $string);
    $string =  str_replace('FROM', '', $string);
    $string =  str_replace('*', '', $string);
    $string =  str_replace('`', '', $string);
    $string =  str_replace('=', '', $string);
    $string =  str_replace('--', '', $string);
    $string =  str_replace('--+', '', $string);
    $string =  str_replace('--+-', '', $string);
    $string =  str_replace(';%00', '', $string);
    $string =  str_replace('`', '', $string);
    $string =  str_replace('+', '', $string);
    $string =  str_replace('|', '', $string);
    $string =  str_replace('~', '', $string);
    $string =  str_replace('!', '', $string);
    $string =  str_replace('^', '', $string);
    $string =  str_replace('"', '', $string);
    $string =  str_replace('<', '', $string);
    $string =  str_replace('>', '', $string);
    $string =  str_replace('ScRiPt', '', $string);
    $string = str_replace("onclick","", $string);
    $string = str_replace("onmouseover","", $string);
    $string = str_replace("prompt(","", $string);
    $string = str_replace("eval(","", $string);
    $string = str_replace("<script","", $string);
    $string = str_replace("alert(","", $string);
    $string = str_replace("[]","", $string);
    $string = str_replace("'","", $string);
    $string = str_replace('"','', $string);
    $string = str_replace('<','', $string);
    $string = str_replace('>','', $string);
    $string = str_replace('*','', $string);
   return $string; // Removes special chars.
}

function clean2($string = '') {
    $string =  str_replace('UNION', '', $string);
    $string =  str_replace('union', '', $string);

    $string =  str_replace('CONCAT', '', $string);
    $string =  str_replace('concat', '', $string);
    $string =  str_replace('count', '', $string);
    $string =  str_replace('COUNT', '', $string);
    $string =  str_replace('from', '', $string);
    $string =  str_replace('FROM', '', $string);
    $string =  str_replace('`', '', $string);
    $string =  str_replace('--', '', $string);
    $string =  str_replace('--+', '', $string);
    $string =  str_replace('--+-', '', $string);
    $string =  str_replace(';%00', '', $string);

    $string =  str_replace('ScRiPt', '', $string);
    $string = str_replace("onclick","", $string);
    $string = str_replace("onmouseover","", $string);
    $string = str_replace("prompt(","", $string);
    $string = str_replace("eval(","", $string);
    $string = str_replace("<script","", $string);
    $string = str_replace("alert(","", $string);
    $string = str_replace("[]","", $string);
    $string = str_replace('<','', $string);
   return $string; // Removes special chars.
}

function randomkey($str,$keyword = 0){
	$return = '';
	$strreturn = explode(" ",trim($str));
	$i=0;
	$listid = '';
	while($i<count($strreturn)){
		$id = rand(0,count($strreturn));
		if(strpos($listid,'[' . $id . ']')===false){
			if(isset($strreturn[$id])){
				$return .= $strreturn[$id] . ' ';
				$i++;
				if($keyword == 1 && ($i%2)==0 && $i<count($strreturn))  $return .= ',';
				$listid .= '[' . $id . ']';
			}
		}
	}
	return $return;
}
function addRelate($table,$feild_id,$field_relate,$record_id,$arrayRelate=array()){
	$db_delete = new db_execute("DELETE FROM " . $table . " WHERE " . $feild_id . "=" . $record_id);
	unset($db_delete);
	foreach($arrayRelate as $key=>$value){
		$db_relate_execute = new db_execute("INSERT INTO " . $table . "(" . $feild_id . "," . $field_relate . ") VALUES(" . $record_id . ", " . intval($value) . ")");
		unset($db_relate_execute);
	}
}

/*
save to cookie
time : thoi gian save cookie, neu = 0 thi` save o cua so hien ha`nh
*/
//3 ngay : 3*24*60*60
function savecookie($name='Cook',$value='',$time='259200'){
	setcookie($name,$value,time()+$time,'/');
}

function array_language(){
	return array(1=>"vn"
				 ,2=>"en");
}
function formatNumber($value){
	return number_format($value,0,"",".");
}
function random(){
	$rand_value = "";
	$rand_value.=rand(1000,9999);
	$rand_value.=chr(rand(65,90));
	$rand_value.=rand(1000,9999);
	$rand_value.=chr(rand(97,122));
	$rand_value.=rand(1000,9999);
	$rand_value.=chr(rand(97,122));
	$rand_value.=rand(1000,9999);
	return $rand_value;
}

function getAge($birthdate = '0000-00-00') {
if ($birthdate == '0000-00-00') return 'Unknown';

$bits = explode('-', $birthdate);
$age = date('Y') - $bits[0] - 1;

$arr[1] = 'm';
$arr[2] = 'd';

for ($i = 1; $arr[$i]; $i++) {
$n = date($arr[$i]);
if ($n < $bits[$i])
break;
if ($n > $bits[$i]) {
++$age;
break;
}
}
return $age;
}

// '%y Year %m Month %d Day'=>  1 Year 3 Month 14 Days
// '%m Month %d Day'=>  3 Month 14 Day
// '%d Day %h Hours'=>  14 Day 11 Hours
// '%d Day' =>  14 Days
// '%h Hours %i Minute %s Seconds'  =>  11 Hours 49 Minute 36 Seconds
// '%i Minute %s Seconds'   =>  49 Minute 36 Seconds
// '%h Hours=>  11 Hours
// '%a Days =>  468 Days

function count_date($date_1 , $date_2 , $differenceFormat = '%a' )
{
    if(!empty($date_1) && !empty($date_2)){
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);
        $interval = date_diff($datetime1, $datetime2);
        return $interval->format($differenceFormat);
    }else{
        return 'chưa rõ';
    }
}

function count_date_create($date_1,$date_2){
    $count_y = count_date($date_1,$date_2,'%y');
    $count_m = count_date($date_1,$date_2,'%m');
    $count_d = count_date($date_1,$date_2,'%a');
    $count_h = count_date($date_1,$date_2,'%h');
    $count_i = count_date($date_1,$date_2,'%i');
    $count_s = count_date($date_1,$date_2,'%s');
    if($count_y){
    $count_date = $count_y.' năm trước';
    }else if($count_m){
    $count_date = $count_m.' tháng trước';
    }else if($count_d){
    $count_date = $count_d.' ngày trước';
    }else if($count_h){
    $count_date = $count_h.' giờ trước';
    }else if($count_i){
    $count_date = $count_i.' phút trước';
    }else if($count_s){
    $count_date = $count_s.' giây trước';
    }
    return $count_date;
}
function checked($session,$int=0){
    $checked = !empty($session) && $session == $int? 'checked="checked"':'';
    return $checked;
}
function selected($session,$int=0){
    $selected = !empty($session) && $session == $int? 'selected="selected"':'';
    return $selected;
}
function stripUnicode($str){
    if(!$str)
    return false;
    
    $unicode = array(
    'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
    'A'=>'À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ',
    'd'=>'đ',
    'D'=>'Đ',
    'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
    'E'=>'È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ',
    'i'=>'í|ì|ỉ|ĩ|ị',
    'I'=>'Ì|Í|Ị|Ỉ|Ĩ',
    'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
    'O'=>'Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ',
    'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
    'U'=>'Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ',
    'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
    'Y'=>'Ỳ|Ý|Ỵ|Ỷ|Ỹ',
    
    );
    foreach($unicode as $nonUnicode=>$uni){
    $str = preg_replace("/($uni)/i",$nonUnicode,$str);
    }
    
    return $str;
}

function str_encode($encodeStr="")
{
	$returnStr = "";
	if($encodeStr == '') return $encodeStr;
	if(!empty($encodeStr)) {
		$enc = base64_encode($encodeStr);
		$enc = str_replace('=','',$enc);
		$enc = str_rot13($enc);
		$returnStr = $enc;
	}
	return $returnStr;
}

function str_decode($encodedStr="",$type=0)
{
  $returnStr = "";
  $encodedStr = str_replace(" ","+",$encodedStr);
	if(!empty($encodedStr)) {
		 $dec = str_rot13($encodedStr);
		 $dec = base64_decode($dec);
		$returnStr = $dec;
	}
  return $returnStr;
}
function getURLR($mod_rewrite = 1,$serverName=0, $scriptName=0, $fileName=1, $queryString=1, $varDenied=''){
	if($mod_rewrite==1){
		return $_SERVER['REQUEST_URI'];
	}else{
		return getURL($serverName, $scriptName, $fileName, $queryString, $varDenied);
	}
}
//hàm get URL
function getURL($serverName=0, $scriptName=0, $fileName=1, $queryString=1, $varDenied=''){
	$url	 = '';
	$slash = '/';
	if($scriptName != 0)$slash	= "";
	if($serverName != 0){
		if(isset($_SERVER['SERVER_NAME'])){
			$url .= 'http://' . $_SERVER['SERVER_NAME'];
			if(isset($_SERVER['SERVER_PORT'])) $url .= ":" . $_SERVER['SERVER_PORT'];
			$url .= $slash;
		}
	}
	if($scriptName != 0){
		if(isset($_SERVER['SCRIPT_NAME']))	$url .= substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);
	}
	if($fileName	!= 0){
		if(isset($_SERVER['SCRIPT_NAME']))	$url .= substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);
	}
	if($queryString!= 0){
		$dau = 0;
		$url .= '?';
		reset($_GET);
		if($varDenied != ''){
			$arrVarDenied = explode('|', $varDenied);
			while(list($k, $v) = each($_GET)){
				if(array_search($k, $arrVarDenied) === false){
					 $url .= (($dau==0) ? '' : '&') . $k . '=' . urlencode($v);
					 $dau  = 1;
				}
			}
		}
		else{
			while(list($k, $v) = each($_GET)) $url .= '&' . $k . '=' . urlencode($v);
		}
	}
	$url = str_replace('"', '&quot;', strval($url));
	return $url;
}
//hàm t?o link khi c?n thi?t chuy?n sang mod rewrite
function createLink($type="detail",$url=array(),$path="",$con_extenstion='html',$rewrite = 1){
	global $lang_path;
	$menuReturn = '';
	$keyReplace = '_';
	//neu ko de mod rewrite
	if($rewrite == 0){
		$menuReturn = $path . $type . ".php?";
		foreach($url as $key=>$value){
			if($key == "module") $value = strtolower($value);
			if($key != "title"){
				$menuReturn .= $key . "=" . $value . "&";
			}
		}
		$menuReturn = substr($menuReturn,0, strrpos($menuReturn, "&"));
		//tra ve url ko rewrite
		return $menuReturn;
	}
	$module = "d";
	switch(strtolower($url["module"])){
		case "news":
		case "km":
			$module = 'n';
		break;
		case "static":
			$module = 's';
		break;
		case "phukien":
			$module = 'p';
		break;

	}
	//tao luat cho mod rewrite
	switch($type){

		case "detail":
			if(strtolower($url["module"])=="product"){
				$menuReturn = "/" . (isset($url["supname"]) ? $url["supname"] . "/" : "") .  removeTitle($url["title"],$keyReplace) . '-c' . $url["iCat"] . 'd' . $url["iData"] . (isset($url["tab"]) ? 't' . $url["tab"]: '') . '.html';
			}else{
				$menuReturn = "/" .  removeTitle($url["title"],$keyReplace) . '-' . $module . $url["iCat"] . '-' . $url["iData"] . '.html';
			}
		break;
		case "type":
				$menuReturn = '/' .  removeTitle($url["title"],$keyReplace) . '/' . $url["iCat"] . '/';
				if(isset($url["iSup"])) $menuReturn = $lang_path .  removeTitle($url["title"],$keyReplace) . $keyReplace  . strtolower($url["module"]) . $keyReplace . $url["iCat"] . $keyReplace . 'hsx_' . $url["iSup"] . '.' . $con_extenstion;
				if(isset($url["iPri"])) $menuReturn = $lang_path .  removeTitle($url["title"],$keyReplace) . $keyReplace  . strtolower($url["module"]) . $keyReplace . $url["iCat"] . $keyReplace . 'gia_' . $url["iPri"] . '.' . $con_extenstion;
		break;
		case "sup":
			$menuReturn = "/" . removeTitle($url["title"],$keyReplace) . '/';
		break;
	}
	return $menuReturn;
}
function removethuoctinh($value){
	$value = str_replace("|","",$value);
	$value = str_replace(";","",$value);
	return $value;
}
function getKeyword($value){
	$value = str_replace("\'","'",$value);
	$value = str_replace("'","''",$value);
	$value = str_replace(" ","%",$value);
	return $value;
}
//hàm getvalue : 1 tên bi?n; 2 ki?u; 3 phuong th?c; 4 giá tr? m?c d?nh; 5 remove quote
//function getValue($value_name, $data_type = "int", $method = "GET", $default_value = 0, $advance = 0){
//	$value = $default_value;
//	switch($method){
//		case "GET": if(isset($_GET[$value_name])) $value = $_GET[$value_name]; break;
//		case "POST": if(isset($_POST[$value_name])) $value = $_POST[$value_name]; break;
//		case "COOKIE": if(isset($_COOKIE[$value_name])) $value = $_COOKIE[$value_name]; break;
//		case "SESSION": if(isset($_SESSION[$value_name])) $value = $_SESSION[$value_name]; break;
//		case "POSTGET":
//			if(isset($_POST[$value_name])){
//				 $value = $_POST[$value_name];
//			}elseif(isset($_GET[$value_name])){
//				$value = $_GET[$value_name];
//			}
//		break;
//		default: if(isset($_GET[$value_name])) $value = $_GET[$value_name]; break;
//	}
//	$valueArray	= array("int" => intval($value), "str" => trim(strval($value)), "flo" => floatval($value), "dbl" => doubleval($value), "arr" => $value);
//	foreach($valueArray as $key => $returnValue){
//		if($data_type == $key){
//			if($advance != 0){
//				switch($advance){
//					case 1:
//						$returnValue = str_replace('"', '&quot;', $returnValue);
//						$returnValue = str_replace("\'", "'", $returnValue);
//						$returnValue = str_replace("'", "''", $returnValue);
//						break;
//					case 2:
//						$returnValue = htmlspecialbo($returnValue);
//						break;
//				}
//			}
//			//Do s? quá l?n nên ph?i ki?m tra tru?c khi tr? v? giá tr?
//			if((strval($returnValue) == "INF") && ($data_type != "str")) return 0;
//			return $returnValue;
//			break;
//		}
//	}
//	return (intval($value));
//}



/*
*	type: msg, error, alert.
*/

function setRedirect($url,$msg='',$type='')
{
	if($msg)
	{
		switch ($type)
		{
			case'error':
				if(!isset($_SESSION['msg_error']))
					$msg_error = array();
				else
					$msg_error = $_SESSION['msg_error'];

				$msg_error[] = $msg;
				$_SESSION['msg_error'] = $msg_error;
				break;
			case'alert':
				if(!isset($_SESSION['msg_alert']))
					$msg_alert = array();
				else
					$msg_alert = $_SESSION['msg_alert'];

				$msg_alert[] = $msg;
				$_SESSION['msg_alert'] = $msg_alert;
				break;
			case'':
			default:

				if(!isset($_SESSION['msg_suc']))
					$msg_suc = array();
				else
					$msg_suc = $_SESSION['msg_suc'];

				$msg_suc[] = $msg;
				$_SESSION['msg_suc'] = $msg_suc;
				break;
		}
		$_SESSION['have_redirect'] = 1;
	}
	if (headers_sent()) {
        header("Content-Type: text/html; charset=utf-8",true);
        echo "<script>document.location.href='$url';</script>\n";
	} else {
		//@ob_end_clean(); // clear output buffer
        session_write_close();
        header("Content-Type: text/html; charset=utf-8",true);
        //header( 'HTTP/1.1 301 Moved Permanently' );
        header( "Location: ". $url );
	}
	exit();
}




//
function replaceMQ($text){
	$text	= str_replace("\'", "'", $text);
	$text	= str_replace("'", "''", $text);
	return $text;
}
// remove sign
// remove multi space
// lowertocase

//function RemoveSign($str)
//{
//function removeTitle($string,$keyReplace){
//	$string	=	RemoveSign($string);
//	//neu muon de co dau
//	//$string 	=  trim(preg_replace("/[^A-Za-z0-9àá??ãâ?????a?????èé???ê?????ìí??iòó??õô?????o?????ùú??uu??????ý???dÀÁ??ÃÂ?????A?????ÈÉ???Ê?????ÌÍ??IÒÓ??ÕÔ?????O?????ÙÚ??UU??????Ý???]/i"," ",$string));
//
//	$string 	=  trim(preg_replace("/[^A-Za-z0-9]/i"," ",$string)); // khong dau
//	$string 	=  str_replace(" ","-",$string);
//	$string	=	str_replace("--","-",$string);
//	$string	=	str_replace("--","-",$string);
//	$string	=	str_replace("--","-",$string);
//	$string	=	strtolower($string);
//	$string	=	str_replace($keyReplace,"-",$string);
//	return $string;
//}
//function generate_sort($type, $sort, $current_sort, $image_path){
//	if($type == "asc"){
//		$title = "Tang d?n";
//		if($sort != $current_sort) $image_sort = "sortasc.gif";
//		else $image_sort = "sortasc_selected.gif";
//	}
//	else{
//		$title = "Gi?m d?n";
//		if($sort != $current_sort) $image_sort = "sortdesc.gif";
//		else $image_sort = "sortdesc_selected.gif";
//	}
//	return '<a title="' . $title . '" href="' . getURL(0,0,1,1,"sort") . '&sort=' . $sort . '"><img border="0" vspace="2" src="' . $image_path . $image_sort . '" /></a>';
//}
function getKeyRef($query,$keyname="q"){
	$strreturn = '';
	preg_match("#" . $keyname . "=(.*)#si",$query,$match);
	if(isset($match[1])) $strreturn = preg_replace('#\&(.*)#si',"",$match[1]);
	return urldecode($strreturn);
}

function convert_number_to_words( $number )
{
	$hyphen = ' ';
	$conjunction = '  ';
	$separator = ' ';
	$negative = 'âm ';
	$decimal = ' phẩy ';
	$dictionary = array(
		0 => 'không',
		1 => 'một',
		2 => 'hai',
		3 => 'ba',
		4 => 'bốn',
		5 => 'năm',
		6 => 'sáu',
		7 => 'bảy',
		8 => 'tám',
		9 => 'chín',
		10 => 'mười',
		11 => 'mười một',
		12 => 'mười hai',
		13 => 'mười ba',
		14 => 'mười bốn',
		15 => 'mười năm',
		16 => 'mười sáu',
		17 => 'mười bảy',
		18 => 'mười tám',
		19 => 'mười chín',
		20 => 'hai mươi',
		30 => 'ba mươi',
		40 => 'bốn mươi',
		50 => 'năm mươi',
		60 => 'sáu mươi',
		70 => 'bảy mươi',
		80 => 'tám mươi',
		90 => 'chín mươi',
		100 => 'trăm',
		1000 => 'ngàn',
		1000000 => 'triệu',
		1000000000 => 'tỷ',
		1000000000000 => 'nghìn tỷ',
		1000000000000000 => 'ngàn triệu triệu',
		1000000000000000000 => 'tỷ tỷ'
	);

	if( !is_numeric( $number ) )
	{
		return false;
	}

	if( ($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX )
	{
		// overflow
		trigger_error( 'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING );
		return false;
	}

	if( $number < 0 )
	{
		return $negative . convert_number_to_words( abs( $number ) );
	}

	$string = $fraction = null;

	if( strpos( $number, '.' ) !== false )
	{
		list( $number, $fraction ) = explode( '.', $number );
	}

	switch (true)
	{
		case $number < 21:
			$string = $dictionary[$number];
			break;
		case $number < 100:
			$tens = ((int)($number / 10)) * 10;
			$units = $number % 10;
			$string = $dictionary[$tens];
			if( $units )
			{
				$string .= $hyphen . $dictionary[$units];
			}
			break;
		case $number < 1000:
			$hundreds = $number / 100;
			$remainder = $number % 100;
			$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
			if( $remainder )
			{
				$string .= $conjunction . convert_number_to_words( $remainder );
			}
			break;
		default:
			$baseUnit = pow( 1000, floor( log( $number, 1000 ) ) );
			$numBaseUnits = (int)($number / $baseUnit);
			$remainder = $number % $baseUnit;
			$string = convert_number_to_words( $numBaseUnits ) . ' ' . $dictionary[$baseUnit];
			if( $remainder )
			{
				$string .= $remainder < 100 ? $conjunction : $separator;
				$string .= convert_number_to_words( $remainder );
			}
			break;
	}

	if( null !== $fraction && is_numeric( $fraction ) )
	{
		$string .= $decimal;
		$words = array( );
		foreach( str_split((string) $fraction) as $number )
		{
			$words[] = $dictionary[$number];
		}
		$string .= implode( ' ', $words );
	}

	return $string;
}

 function int_to_words($x)
 {
	 $nwords = array("không", "một", "hai", "ba", "bốn", "năm", "sáu", "bảy",
								 "tám", "chín", "mười", "mười một", "mười hai", "mười ba",
								 "mười bốn", "mười lăm", "mười sáu", "mười bảy", "mười tám",
								 "mười chín", "hai mươi", 30 => "ba mươi", 40 => "bốn mươi",
								 50 => "năm mươi", 60 => "sáu mươi", 70 => "bảy mươi", 80 => "tám mươi",
								 90 => "chín mươi" );
  if(!is_numeric($x))
  {
  $w = '#';
  }else if(fmod($x, 1) != 0)
  {
  $w = '#';
  }else{
  if($x < 0)
  {
  $w = 'minus ';
  $x = -$x;
  }else{
  $w = '';
  }
  if($x < 21)
  {
  $w .= $nwords[$x];
  }else if($x < 100)
  {
  $w .= $nwords[10 * floor($x/10)];
  $r = fmod($x, 10);
  if($r > 0)
  {
  $w .= ' '. $nwords[$r];
  }
  } else if($x < 1000)
  {
  $w .= $nwords[floor($x/100)] .' trăm';
  $r = fmod($x, 100);
  if($r > 0)
  {
  $w .= '  '. int_to_words($r);
  }
  } else if($x < 1000000)
  {
  $w .= int_to_words(floor($x/1000)) .' ngàn';
  $r = fmod($x, 1000);
  if($r > 0)
  {
  $w .= ' ';
  if($r < 100)
  {
  $w .= ' ';
  }
  $w .= int_to_words($r);
  }
  } else {
  $w .= int_to_words(floor($x/1000000)) .' triệu';
  $r = fmod($x, 1000000);
  if($r > 0)
  {
  $w .= ' ';
  if($r < 100)
  {
  $word .= ' ';
  }
  $w .= int_to_words($r);
  }
  }
  }
  return $w . '';
 }

 function fsdate($date='',$type = 0 )
 {
 	// format 'D, d/m/Y, H:i '
 	if($date)
 	{
 		$Day = date('D',strtotime($date));
 		$str_date =  date('d/m/Y, H:i',strtotime($date));
 	}
 	else
 	{
 		$Day = date('D');
 		$str_date =  date('d/m/Y, H:i');
 	}
 	$Day = strtoupper($Day);
 	$str = "";
	//TUE WED THU FRI SAT SUN MON TUE WED THU FRI SAT SUN MON JAN FEB
 	switch ($Day) {
 		case 'MON':
 			$str .= "Th&#7913; 2";
 			break;
 		case 'TUE':
 			$str .= "Th&#7913; 3";
 			break;
 		case 'WED':
 			$str .= "Th&#7913; 4";
 			break;
 		case 'THU':
 			$str .= "Th&#7913; 5";
 			break;
 		case 'FRI':
 			$str .= "Th&#7913; 6";
 			break;
 		case 'SAT':
 			$str .= "Th&#7913; 7";
 			break;
 		case 'SUN':
 			$str .= "Ch&#7911; nh&#7853;t ";
 			break;
 	}

 	if($type == 1){
 		$str .= ", ng&#224;y ".$str_date;
 	} else {
 		$str .= ", ".$str_date;
 		$str .= " GMT+7";
 	}

 	return $str;
 }
 function show_datetime($date='')
 	{
	 	// format 'D, d/m/Y, H:i '
	 	if($date)
	 	{
	 		$Day = date('D',strtotime($date));
	 		$str_date =  date('d/m/Y, H:i A',strtotime($date));
	 	}
	 	else
	 	{
	 		$Day = date('D');
	 		$str_date =  date('d/m/Y, H:i A');
	 	}
	 	$Day = strtoupper($Day);
	 	$str = "";
		//TUE WED THU FRI SAT SUN MON TUE WED THU FRI SAT SUN MON JAN FEB
	 	switch ($Day) {
	 		case 'MON':
	 			$str .= "Thứ 2";
	 			break;
	 		case 'TUE':
	 			$str .= "Thứ 3";
	 			break;
	 		case 'WED':
	 			$str .= "Thứ 4";
	 			break;
	 		case 'THU':
	 			$str .= "Thứ 5";
	 			break;
	 		case 'FRI':
	 			$str .= "Thứ 6";
	 			break;
	 		case 'SAT':
	 			$str .= "Thứ 7";
	 			break;
	 		case 'SUN':
	 			$str .= "Chủ nhật";
	 			break;
	 	}
	 	$str .= ", ".$str_date;
	 	return $str;
 	}


    /**
     *  Time post ago
     *
    */

    function timeAgo($time_ago)
    {
        $time_ago = strtotime($time_ago);
        $cur_time   = time();
        $time_elapsed   = $cur_time - $time_ago;
        $seconds    = $time_elapsed ;
        $minutes    = round($time_elapsed / 60 );
        $hours      = round($time_elapsed / 3600);
        $days       = round($time_elapsed / 86400 );
        $weeks      = round($time_elapsed / 604800);
        $months     = round($time_elapsed / 2600640 );
        $years      = round($time_elapsed / 31207680 );
        // Seconds
        if($seconds <= 60){
            return "Just now";
        }
        //Minutes
        else if($minutes <=60){
            if($minutes==1){
                return "1 phút trước";
            }
            else{
                return "$minutes phút trước";
            }
        }
        //Hours
        else if($hours <=24){
            if($hours==1){
                return "1 giờ trước";
            }else{
                return "$hours giờ trước";
            }
        }
        //Days
        else if($days <= 7){
            if($days==1){
                return "Hôm qua";
            }else{
                return "$days ngày trước";
            }
        }
        //Weeks
        else if($weeks <= 4.3){
            if($weeks==1){
                return "Một tuần trước";
            }else{
                return "$weeks tuần trước";
            }
        }
        //Months
        else if($months <=12){
            if($months==1){
                return "1 tháng trước";
            }else{
                return "$months tháng trước";
            }
        }
        //Years
        else{
            if($years==1){
                return "1 năm trước";
            }else{
                return "$years năm trước";
            }
        }
    }









 	/******* CUT STRING BY LENGTH ********/

	function count_words($str) {
			$words = 0;

			$str =  preg_replace("/ +/i", " ", $str);
			$array = explode(" ", $str);
			for($i=0;$i < count($array);$i++){

			  if (preg_match("/[0-9A-Za-zÀ-ÖØ-öø-ÿ]/i", $array[$i]))

			  $words++;
			}
			return $words;
	  }
	  //End function
	  function implodeWord($str,$noWord){

			$str = preg_replace("/ +/i", " ", $str);
			$array = explode(" ", $str);


			for($i=0;$i<$noWord;$i++){
			  if (preg_match("/[0-9A-Za-zÀ-ÖØ-öø-ÿ]/i", $array[$i])) $aryContent[] = $array[$i];

			}
			$strContent = implode(" ",$aryContent);
			return $strContent;
	  }
	  function getWord($noWord,$str,$tag = ''){

if($tag){
$noCountWord = count_words(strip_tags($str,$tag));
}else{
$noCountWord = count_words(strip_tags($str));
}

			if($noCountWord >= $noWord){
			  $content = implodeWord(strip_tags($str),$noWord).'...';
			} else {
			  $content = strip_tags($str);
			}

			$k = chr(92);
			$content = str_replace($k,"",$content);

			return $content;
	  }
	  function get_word_by_length($maxleng = 100,$str,$suppend = '...'){
			$str =  preg_replace("/ +/i", " ", $str);

			$i = $maxleng;
			if(mb_strlen($str) <= $maxleng)
				return $str;

			while(true){
				$character_current = @mb_substr($str,($i),1,'utf-8');

				if(empty($character_current) || $character_current == ' ' || $character_current == ',' || $character_current == '|')
					return mb_substr($str, 0,$i,'utf-8').$suppend;
				$i --;
			}
			return 	$str.$suppend;
	  }
	  function cutString($string = '', $totalChar = 0, $ext = '...'){
		if(mb_strlen($string, 'UTF-8') > $totalChar){
		$string = mb_substr($string, 0, $totalChar, 'UTF-8');
		if(mb_strrpos($string,' ',0,'UTF-8')){
		$string = mb_substr($string, 0, mb_strrpos($string,' ',0,'UTF-8'), 'UTF-8');
		}
		return $string.$ext;
		}
		return $string;
		}
	function standart_money($money){
		$money = str_replace(',','' , trim($money));
		$money = str_replace(' ','' , $money);
		$money = str_replace('.','' , $money);
//		$money = intval($money);
		$money = (double)($money);
		return $money; 
	}
	  function format_money($price,$current = ' đ',$text = 'liên hệ')
	  {
	  	if(!$price)
	  		return $text.$current;
  		return number_format($price, 0, ',', ',').''.$current.'';
	  }
 	  function format_money_0($price,$current = ' ',$text = '0')
	  {
	  	if(!$price)
	  		return $text.$current;
  		return number_format($price, 0, ',', ',').''.$current.'';
	  }
	  function get_price_eps($price)
	  {
	  	if(!$price)
	  		$price =0;
			$rate_vnd_eps = 100000.0;
	  		$price = number_format($price/$rate_vnd_eps, 0, ',', '.');
	  		return $price;
	  }
	  function get_price_usd($price)
	  {
	  		$rate_vnd_usd = 1950000;
	  		return  number_format($price/$rate_vnd_usd, 0, ',', '.');
	  }

	  /*
	   * return price VND
	   */
	  function money_transform_to_vnd($price, $currency) {

	  		if(!$currency || strtoupper($currency) == 'VND') {
				return $price;
	  		}
	  		if($currency == "USD") {
	  			$rate_vnd_usd = 1950000;
	  			return  $price*$rate_vnd_usd;
	  		}
	  }
	  function calculator_price($price, $price_old,$is_promotion=0,$date_start='',$date_end='',$use_wholesale = 0,$wholesale_prices='') {
	  		$result = array();
	 		if($is_promotion){
				if( $date_start <  date('Y-m-d H:i:s') && $date_end >  date('Y-m-d H:i:s') ){
					$result['price']  = $price;
					$result['price_old'] = $price_old;

				}else{
					$result['price'] = $price_old;
					$result['price_old'] =$price_old;
				}
			}else{
				if($price_old - $price && $price)
					$percent = round((($price_old - $price)/$price_old)*100);
					// $percent = 0;
				else
					$percent=0;
				$result['price']= $price;
				$result['percent']= $percent;
				$result['price_old']  = $price_old;
			}
			if($use_wholesale){
				if(isset($_COOKIE['user_id'])){
					$result['wholesale_prices']= $wholesale_prices;
				}else{
					$result['wholesale_prices'] =	$result['price'];
				}
			}


	  	return $result;
	  }
	  /*
	   * Input: date
	   * Output: 12h30 ngày 2-3-2011
	   */
	  function format_date($str_time){
	  	 $time = strtotime($str_time);
	  	 $hour = date('H',$time);
	  	 $minute = date('i',$time);
	  	 $date = date('d-m-Y',$time);
	  	 return $hour.'h'.$minute.' ngày '.$date;
	  }
	  function encodeURIComponent($str) {
	$revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
	return strtr(rawurlencode($str), $revert);
	}

	/******* end CUT STRING BY LENGTH ********/
	function image_to_bytes($img_source,$method_resize='resized_not_crop',$new_width = 1, $new_height = 1,$quality=100) {
// Begin capturing the byte stream
ob_start();
 	$img_source = str_replace(' ','%20', $img_source);

		list($old_width,$old_height) = getimagesize($img_source);
		if($method_resize == 'resized_not_crop'){
			if(!$new_width){
				$new_width  = $old_width * $new_height/ $old_height ;
			}
			if(!$new_height){
				$new_height = $old_height * $new_width /$old_width  ;
			}

			$file_ext =strtolower(substr($img_source, (strripos($img_source, '.')+1),strlen($img_source)));

			$cropped_tmp = @imagecreatetruecolor($new_width,$new_height)
				or die("Cannot Initialize new GD image stream when cropped");

			 // transparent
			imagealphablending($cropped_tmp, false);
	  		imagesavealpha($cropped_tmp,true);
		$transparent = imagecolorallocatealpha($cropped_tmp, 255, 255, 255, 127);//
	  		imagefilledrectangle($cropped_tmp, 0, 0, $new_width, $new_height, $transparent);
		// end transparent
  			if($file_ext == "png"){
	$source = imagecreatefrompng($img_source);
	}elseif($file_ext == "jpg" || $file_ext == "jpeg"){
	$source = imagecreatefromjpeg($img_source);
	}elseif($file_ext == "gif"){
	$source = imagecreatefromgif($img_source);
	}

	imagecopyresampled($cropped_tmp,$source,0,0,0,0,$new_width,$new_height, $old_width,$old_height);


	if($file_ext == "png"){
	   	$img  =  imagepng($cropped_tmp,NULL,0);
	}elseif($file_ext == "jpg" || $file_ext == "jpeg"){
	$img  =  imagejpeg($cropped_tmp,NULL,90);
	}elseif($file_ext == "gif"){
	$img  =  imagegif($cropped_tmp,NULL,0);
	}

		}else if($method_resize == 'resize_image'){
			$crop_width = $new_width;
			$crop_height = $new_height ;
			if(!$crop_width && !$crop_height){
				$crop_width = $old_width;
				$crop_height = $old_height;
			} else if(!$crop_width){
				$crop_width = 	$crop_height * $old_width / $old_height;
			} else if(!$crop_height){
				$crop_height = 	$crop_width *  $old_height/$old_width;
			}
			if(($crop_width/$crop_height)>($old_width/$old_height))
			{
				$real_height = $crop_height;
				$real_width = $real_height*$old_width/$old_height;
			}
			else
			{
				$real_width = $crop_width;
				$real_height = (($real_width*$old_height)/$old_width);
			}

			$file_ext =strtolower(substr($img_source, (strripos($img_source, '.')+1),strlen($img_source)));

			// new
			$newpic = imagecreatetruecolor(round($real_width), round($real_height));

			// transparent
			imagealphablending($newpic, false);
	  		imagesavealpha($newpic,true);
	   	$transparent = imagecolorallocatealpha($newpic, 255, 255, 255, 127);//
	  		imagefilledrectangle($newpic, 0, 0, $real_width, $real_height, $transparent);


	  		if($file_ext == "png"){
	$source = imagecreatefrompng($img_source);
	}elseif($file_ext == "jpg" || $file_ext == "jpeg"){
	$source = imagecreatefromjpeg($img_source);
	}elseif($file_ext == "gif"){
	$source = imagecreatefromgif($img_source);
	}

	if(!imagecopyresampled($newpic, $source, 0, 0, 0, 0, $real_width, $real_height, $old_width, $old_height))
	{
		return false;
	}
		  	// create frame
	$final = imagecreatetruecolor($crop_width, $crop_height);
	// transparent
	imagealphablending($final, false);//
	imagesavealpha($final,true);//
	$transparent = imagecolorallocatealpha($final, 255, 255, 255, 127);//
		imagefill($final, 0, 0, $transparent);
		// end transparent

		imagecopy($final, $newpic, (abs($crop_width - $real_width)/ 2), (abs($crop_height - $real_height) / 2), 0, 0, $real_width, $real_height);


	if($file_ext == "png"){
	   	$img  =  imagepng($final,NULL,0);
	}elseif($file_ext == "jpg" || $file_ext == "jpeg"){
	$img  =  imagejpeg($final,NULL,100);
	}elseif($file_ext == "gif"){
	$img  =  imagegif($final,NULL,0);
	}
		// end transparent
		}else if($method_resize == 'cut_image'){
			$crop_width = $new_width;
			$crop_height = $new_height ;

			if(($crop_width/$crop_height)>($old_width/$old_height))
			{
				$real_width = $crop_width;
				$real_height = (($real_width*$old_height)/$old_width);
				$x_crop = 0;
				$y_crop = 0;
			}
			else
			{
				$real_height = $crop_height;
				$real_width = $real_height*$old_width/$old_height;
				$x_crop = ((abs($real_width - $crop_width))/2)*$old_height/$crop_height;
				$x_crop = round($x_crop);
				$y_crop = 	0;
			}


			$file_ext =strtolower(substr($img_source, (strripos($img_source, '.')+1),strlen($img_source)));

			// new
			$newpic = imagecreatetruecolor($crop_width,$crop_height);
			// transparent
			imagealphablending($newpic, false);
	  		imagesavealpha($newpic,true);
	   	$transparent = imagecolorallocatealpha($newpic, 255, 255, 255, 127);//
	  		imagefilledrectangle($newpic, 0, 0, $crop_width, $crop_height, $transparent);

	  		if($file_ext == "png"){
	$source = imagecreatefrompng($img_source);
	}elseif($file_ext == "jpg" || $file_ext == "jpeg"){
	$source = imagecreatefromjpeg($img_source);
	}elseif($file_ext == "gif"){
	$source = imagecreatefromgif($img_source);
	}

	 	 if(!imagecopyresampled($newpic, $source,0,0, $x_crop, $y_crop, $real_width, $real_height, $old_width, $old_height))
   		{
		// Errors::setErrors("Not copy and resize part of an image with resampling when cropped");
	}


			// header('Content-Type: image/jpeg');

	if($file_ext == "png"){
	   	$img  =  imagepng($newpic,NULL,0);
	}elseif($file_ext == "jpg" || $file_ext == "jpeg"){
	$img  =  imagejpeg($newpic,NULL,90);
	}elseif($file_ext == "gif"){
	$img  =  imagegif($newpic,NULL,0);
	}




		// end transparent
		}

   //  // generate the byte stream
   //  imagejpeg($img, NULL, $quality);

   //  // and finally retrieve the byte stream
$rawImageBytes = ob_get_clean();
   return "data:image/jpeg;base64," . base64_encode( $rawImageBytes );

}
	function image_resized($img_source,$method_resize='resized_not_crop',$new_width = 1, $new_height = 1,$quality=100) {
  		$return = URL_ROOT.'libraries/fsresized.php?s='.$img_source.'&m='.$method_resize.'&w='.$new_width.'&h='.$new_height.'&q='.$quality;

   return  $return;


}
function image_to_base64($path_to_image)
{
$type = pathinfo($path_to_image, PATHINFO_EXTENSION);
$image = file_get_contents($path_to_image);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($image);
return $base64;
}
function recursiveRemoveDirectory($directory)
{
foreach(glob("{$directory}/*") as $file)
{
if(is_dir($file)) {
recursiveRemoveDirectory($file);
} else {
unlink($file);
}
}
rmdir($directory);
}
function time_elapsed_string($ptime){
    $etime = time() - $ptime;
    if ($etime < 1)
    {
        return 'Vừa xong';
    }
    
    $a = array( 365 * 24 * 60 * 60  =>  'year',
                 30 * 24 * 60 * 60  =>  'month',
                      24 * 60 * 60  =>  'day',
                           60 * 60  =>  'hour',
                                60  =>  'minute',
                                 1  =>  'second'
    );
    $a_plural = array( 'year'   => 'năm',
       'month'  => 'tháng',
       'day'=> 'ngày',
       'hour'   => 'giờ',
       'minute' => 'phút',
       'second' => 'giây'
    );
    
    	foreach ($a as $secs => $str)
    {
    $d = $etime / $secs;
    if ($d >= 1)
    {
    	// if ($etime < 86400000){
    	$r = round($d);
    	return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' trước';
    	// }else{
    	// 	return date('d/m/Y | H:i',$ptime);
    	// }
    }
    }
}

function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789!@#$%^&*()+";
    for ($i = 0; $i < 10; $i++) {
        $n = rand(0, count($alphabet)-1);
        $pass[$i] = $alphabet[$n];
    }
    return $pass;
}

function ckeditor($name, $content='', $toolbar = '2', $language = 'vi', $width = 'auto', $height = 200)
{
	global $ckeditor_loaded;

	$code = '';
	if(!$ckeditor_loaded)
	{
		$code.= '<script type="text/javascript" src="'.URL_ROOT.'asset/ckeditor/ckeditor.js"></script>';
		$ckeditor_loaded = true;
	}


	$code.= '<textarea name="'.$name.'" id="'.$name.'">'.$content.'</textarea>';
	$code.= "<script type=\"text/javascript\">
			config  = {};
			config.entities_latin = false;
			config.language = '".$language."';
			config.width = '".$width."';
			config.height = '".$height."';
			config.filebrowserBrowseUrl 		= '".URL_ROOT."asset/ckfinder/ckfinder.html';
			config.filebrowserImageBrowseUrl 	= '".URL_ROOT."asset/ckfinder/ckfinder.html';
			filebrowserUploadUrl: '".URL_ROOT."asset/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
			filebrowserImageUploadUrl: '".URL_ROOT."asset/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	";

	
	if($toolbar == 1)
	{
        //{ name: 'colors', groups: [ 'colors' ] },
        //{ name: 'others', groups: [ 'others' ] }
        //{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        //{ name: 'styles', groups: [ 'styles' ] },
        //{ name: 'insert', groups: [ 'insert' ] },
        //{ name: 'links', groups: [ 'links' ] },
		$code.= "config.toolbarGroups = [
    		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
    		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
    		
    		
    		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
    		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
    		{ name: 'tools', groups: [ 'tools' ] },
    		{ name: 'document', groups: [ 'document', 'doctools' ] },
	
    		{ name: 'about', groups: [ 'about' ] },
    		{ name: 'forms', groups: [ 'forms' ] },
    	];
    	config.removeButtons = 'Checkbox,Radio,TextField,Form,Textarea,Select,Button,ImageButton,HiddenField,SelectAll,Replace,Find,Smiley,Iframe,PageBreak,Anchor,Flash,ShowBlocks,Save,NewPage,Preview,Print,Templates,Underline,Subscript,Superscript,Language,BidiRtl,BidiLtr,CreateDiv,Font,Cut,Undo,Redo,Copy,Scayt,Strike,RemoveFormat,Outdent,Indent,Blockquote,Table,SpecialChar,HorizontalRule,Styles,Format,About';
	";

	}
	elseif ($toolbar == 2)
	{
		$code.= "config.toolbarGroups = [
    		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
    		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
    		{ name: 'links', groups: [ 'links' ] },
    		{ name: 'insert', groups: [ 'insert' ] },
    		{ name: 'tools', groups: [ 'tools' ] },
    		{ name: 'document', groups: [  'document', 'doctools' ] },
    		'/',
    		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
    		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
    		{ name: 'styles', groups: [ 'styles' ] },
    		{ name: 'about', groups: [ 'about' ] },
    		{ name: 'forms', groups: [ 'forms' ] },
    		{ name: 'colors', groups: [ 'colors' ] },
    		{ name: 'others', groups: [ 'others' ] }
    	];
	   config.removeButtons = 'Checkbox,Radio,TextField,Anchor,Form,Textarea,Select,Button,ImageButton,HiddenField,SelectAll,Replace,Find,Smiley,Iframe,PageBreak,Flash,ShowBlocks,Save,NewPage,Preview,Print,Templates,Underline,Subscript,Superscript,Language,BidiRtl,BidiLtr,CreateDiv,JustifyCenter,JustifyRight,Font';
	";
	}
    elseif ($toolbar == 3)
	{
		$code.= "config.toolbarGroups = [
    		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
            { name: 'colors', groups: [ 'colors' ] },
            { name: 'styles', groups: [ 'styles' ] },
    		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
    		{ name: 'links', groups: [ 'links' ] },
    		{ name: 'insert', groups: [ 'insert' ] },
    		{ name: 'tools', groups: [ 'tools' ] },
    		{ name: 'document', groups: [  'document', 'doctools' ] },
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
    		'/',
    		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
    		{ name: 'about', groups: [ 'about' ] },
    		{ name: 'forms', groups: [ 'forms' ] },
    		{ name: 'others', groups: [ 'others' ] }
    	];
	   config.removeButtons = 'Underline,Subscript,Superscript,Anchor,About';
	";
	}

	$code.= 'CKEDITOR.replace(\''.$name.'\', config);';
	$code.= '</script>';

	return $code;
}

function testVar($var){
	print_r('<pre>');
	print_r($var);
	print_r('</pre>');
}

/**
 * Custom error handler
 * @param integer $code
 * @param string $description
 * @param string $file
 * @param interger $line
 * @param mixed $context
 * @return boolean
 */
function handleError($code, $description, $file = null, $line = null, $context = null) {
	$displayErrors = ini_get("display_errors");
	$displayErrors = strtolower($displayErrors);
	if (error_reporting() === 0 || $displayErrors === "on") {
		return false;
	}
	list($error, $log) = mapErrorCode($code);
	$data = array(
		'level' => $log,
		'code' => $code,
		'error' => $error,
		'description' => $description,
		'file' => $file,
		'line' => $line,
		'context' => $context,
		'path' => $file,
		'message' => $error . ' (' . $code . '): ' . $description . ' in [' . $file . ', line ' . $line . ']'
	);
	return fileLog($data);
}

/**
 * This method is used to write data in file
 * @param mixed $logData
 * @param string $fileName
 * @return boolean
 */
function fileLog($logData, $fileName = ERROR_LOG_FILE) {
	// $fh = fopen($fileName, 'a+');
	// if (is_array($logData)) {
	// 	$logData = print_r($logData, 1);
	// }
	// $status = fwrite($fh, $logData);
	// fclose($fh);
	// return ($status) ? true : false;
}

/**
 * Map an error code into an Error word, and log location.
 *
 * @param int $code Error code to map
 * @return array Array of error word, and log location.
 */
function mapErrorCode($code) {
	$error = $log = null;
	switch ($code) {
		case E_PARSE:
		case E_ERROR:
		case E_CORE_ERROR:
		case E_COMPILE_ERROR:
		case E_USER_ERROR:
			$error = 'Fatal Error';
			$log = LOG_ERR;
			break;
		case E_WARNING:
		case E_USER_WARNING:
		case E_COMPILE_WARNING:
		case E_RECOVERABLE_ERROR:
			$error = 'Warning';
			$log = LOG_WARNING;
			break;
		case E_NOTICE:
		case E_USER_NOTICE:
			$error = 'Notice';
			$log = LOG_NOTICE;
			break;
		case E_STRICT:
			$error = 'Strict';
			$log = LOG_NOTICE;
			break;
		case E_DEPRECATED:
		case E_USER_DEPRECATED:
			$error = 'Deprecated';
			$log = LOG_NOTICE;
			break;
		default :
			break;
	}
	return array($error, $log);
}

define('ERROR_LOG_FILE', '/var/www/html/xemay/error.log');
set_error_handler("handleError");