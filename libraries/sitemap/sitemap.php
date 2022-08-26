<?php

class SITEMAP
{
	public function SITEMAP()
	{
	}
	
	public function GetFeed()
	{
		return $this->getDetails()
            . $this->getItems_network_cat()
            . $this-> getItems_network_child()
            . $this->getItems_SimType()
            . $this->getItems_Contents()
            . $this->getItems_Ex()
            . $this->getItemsNews()
            . $this->getItems_Par();
	}
	
	
	private function getDetails()
	{
		$details = '
                    <url>
                      <loc>'.URL_ROOT.'</loc>
                      <lastmod>'.date("Y-m-d").'</lastmod>
                      <changefreq>daily</changefreq>
                    </url>   
                    ';
		return $details;
	}
    
    private function getItems_network_cat()
	{
		global $db;
		
		$query = " SELECT id,name,alias,created_time,updated_time
				FROM fs_network
				WHERE published = 1
				ORDER BY ID DESC
				";
		$db->query($query);
		$result = $db->getObjectList();
		$xml = '';
		for($i = 0; $i < count($result); $i ++ ){
			$row = $result[$i];
//			$link = FSRoute::_('index.php?module=network&view=network&code='.$row->alias.'&Itemid=2');
            $link = URL_ROOT.$row->alias.'.html';
			$xml .= '
                      <url>
                          <loc>'.$link.'</loc>
                          <lastmod>'.date("Y-m-d",strtotime($row->updated_time)).'</lastmod>
                          <changefreq>daily</changefreq>
                        </url>  
                    ';
		}

		return $xml;
	}

	private function getItems_network_child()
	{
		global $db;

		$query = " SELECT id,name,alias,created_time,updated_time, header
				FROM fs_network
				WHERE published = 1
				ORDER BY ID DESC
				";
		$db->query($query);
		$result = $db->getObjectList();
		$xml = '';
		foreach ($result as $item){
		    if($item->header){
		        $array_header = explode(',',$item->header);
		        foreach ($array_header as $it){
                    $link = URL_ROOT.$item->alias.'/'.$it.'.html';
		            $xml.='
		                <url>
                          <loc>'.$link.'</loc>
                          <lastmod>'.date("Y-m-d",strtotime($item->updated_time)).'</lastmod>
                          <changefreq>daily</changefreq>
                        </url> 
		            ';
                }
            }
        }

		return $xml;
	}

    private function getItems_SimType()
    {
        global $db;

        $query = " SELECT id,name,alias,created_time,updated_time
				FROM fs_sim_type
				WHERE published = 1
				ORDER BY ID DESC
				";
        $db->query($query);
        $result = $db->getObjectList();
        $xml = '';
        for($i = 0; $i < count($result); $i ++ ){
            $row = $result[$i];
//			$link = FSRoute::_('index.php?module=network&view=network&code='.$row->alias.'&Itemid=2');
            $link = URL_ROOT.$row->alias.'.html';
            $xml .= '
                      <url>
                          <loc>'.$link.'</loc>
                          <lastmod>'.date("Y-m-d",strtotime($row->updated_time)).'</lastmod>
                          <changefreq>daily</changefreq>
                      </url>  
                    ';
        }

        return $xml;
    }

    private function getItems_Contents()
    {
        global $db;

        $query = " SELECT id,title,alias,created_time,updated_time
				FROM fs_contents
				WHERE published = 1
				ORDER BY ID DESC
				";
        $db->query($query);
        $result = $db->getObjectList();
        $xml = '';
        for($i = 0; $i < count($result); $i ++ ){
            $row = $result[$i];
//			$link = FSRoute::_('index.php?module=network&view=network&code='.$row->alias.'&Itemid=2');
            $link = URL_ROOT.'apl/'.$row->alias.'.html';
            $xml .= '<url>
                          <loc>'.$link.'</loc>
                          <lastmod>'.date("Y-m-d",strtotime($row->updated_time)).'</lastmod>
                        <changefreq>daily</changefreq>
                        </url>  
                    ';
        }

        return $xml;
    }



    private function getItems_Ex()
    {
        $xml='';
        $xml.='
            <url>
              <loc>https://simsodepgiare.com.vn/sim-phong-thuy.html</loc>
              <lastmod>'.date("Y-m-d").'</lastmod>
              <changefreq>daily</changefreq>
            </url>
            <url>
              <loc>https://simsodepgiare.com.vn/ky-gui-sim.html</loc>
              <lastmod>'.date("Y-m-d").'</lastmod>
              <changefreq>daily</changefreq>
            </url>
            <url>
              <loc>https://simsodepgiare.com.vn/tim-sim-theo-yeu-cau.html</loc>
              <lastmod>'.date("Y-m-d").'</lastmod>
              <changefreq>daily</changefreq>
            </url>
            <url>
              <loc>https://simsodepgiare.com.vn/dinh-gia-sim.html</loc>
              <lastmod>'.date("Y-m-d").'</lastmod>
              <changefreq>daily</changefreq>
            </url>
            <url>
              <loc>https://simsodepgiare.com.vn/lap-dat-internet.html</loc>
              <lastmod>'.date("Y-m-d").'</lastmod>
              <changefreq>daily</changefreq>
            </url>
            <url>
              <loc>https://simsodepgiare.com.vn/tin-tuc.html</loc>
              <lastmod>'.date("Y-m-d").'</lastmod>
                <changefreq>daily</changefreq>
            </url>
            <url>
              <loc>https://simsodepgiare.com.vn/sim-viettel-v90.html</loc>
              <lastmod>'.date("Y-m-d").'</lastmod>
                <changefreq>daily</changefreq>
            </url>
            <url>
              <loc>https://simsodepgiare.com.vn/sim-vip.html</loc>
              <lastmod>'.date("Y-m-d").'</lastmod>
                <changefreq>daily</changefreq>
            </url>
            <url>
              <loc>https://simsodepgiare.com.vn/sim-tra-sau.html</loc>
              <lastmod>'.date("Y-m-d").'</lastmod>
                <changefreq>daily</changefreq>
            </url>
            <url>
              <loc>https://simsodepgiare.com.vn/sim-de-xuat.html</loc>
              <lastmod>'.date("Y-m-d").'</lastmod>
                <changefreq>daily</changefreq>
            </url>
            <url>
              <loc>https://simsodepgiare.com.vn/khuyen-mai-sim-so-dep.html</loc>
              <lastmod>'.date("Y-m-d").'</lastmod>
                <changefreq>daily</changefreq>
            </url>
        ';
        $xml.='
            
        ';

        return $xml;
    }

    private function getItems_Par()
    {
        global $db;
        $result = ["sim-hop-menh-tho", "sim-hop-menh-hoa" ,"sim-hop-menh-thuy","sim-hop-menh-moc","sim-hop-menh-kim"];


        $xml = '';
        foreach ($result as $item){
            $link = URL_ROOT.$item.'.html';
            $xml .= '<url>
                          <loc>'.$link.'</loc>
                          <lastmod>'.date("Y-m-d").'</lastmod>
                          <changefreq>daily</changefreq>
                        </url>
            ';
        }
        return $xml;
    }



    private function getItemsNews()
    {
        global $db;

        $query = " SELECT id,title,alias,created_time,updated_time
				FROM fs_news
				WHERE published = 1
				ORDER BY ID DESC
				";
        $db->query($query);
        $result = $db->getObjectList();
        $xml = '';
        for($i = 0; $i < count($result); $i ++ ){
            $row = $result[$i];
//			$link = FSRoute::_('index.php?module=network&view=network&code='.$row->alias.'&Itemid=2');
            $link = URL_ROOT.'tin-tuc/'.$row->alias.'.html';
            $xml .= '<url>
                          <loc>'.$link.'</loc>
                          <lastmod>'.date("Y-m-d",strtotime($row->updated_time)).'</lastmod>
                        <changefreq>daily</changefreq>
                        </url>  
                    ';
        }

        return $xml;
    }

}

?>