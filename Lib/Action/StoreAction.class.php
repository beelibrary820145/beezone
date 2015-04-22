<?php
class StoreAction
{
    private $lng=0,
            $lat=0;
    
    public function getList()
    {
        $data=array(
            array('lng','double'),
            array('lat','double')
        );
        dataFilter($data,'post');
        $whereArr=array();
        $this->lng=$data['lng'];
        $this->lat=$data['lat'];
        
        $condData=array();
        $city_id=0;
        
        if(isset($_POST['city']))
        {
            $city_id=D('Location')->getCityIdByName($_POST['city']);
        }
        else if($_POST['city_id'])
        {
            $city_id=(int)$_POST['city_id'];
        }
        //$condData['city_id']=array($city_id,'=','int');
        
        $fillData=array(
            'name'=>array('`name`','%%','string'),
            'type_id'=>array('type','=','int')
        );
        foreach($fillData as $k=>$v)
        {
            if(isset($_POST[$k]) && $_POST[$k])
            {
                $tmpData=array(
                    array($k,$v[2])
                );
                dataFilter($tmpData,'post');
                $whereArr[$v[0]]=array($_POST[$k],$v[1],$v[2]);
            }
        }
        $where=1;
            
        //'字段名2'=>array(array(1,4),'between'),
        if($whereArr)
        {
            $where=D('Page')->getWhere($whereArr);
        }
        
        if(isset($_POST['order']) && $_POST['order'])
        {
            //'字段名2'=>array(array(1,4),'between'),
        
            $this->getListByOther($city_id,$whereArr,$_POST['order']);
        }
        else
        {
            //'字段名2'=>array(array(1,4),'between'),
            if($whereArr)
            {
                $where=D('Page')->getWhere($whereArr);
            }
            $this->getListByDistance($city_id,$where);
        }
    }  
    /**
     * 同城距离排序
     */
    private function getListByDistance($city_id,$where)
    {
        //` IN (SELECT `id` FROM tbl_store WHERE '.$where.')
        $data=array();
      
        $condData=array(
            'city_id'=>array($city_id,'=','int'),
            'store_id'=>array('SELECT id FROM tbl_store WHERE '.$where,'in','ignore'), 
        );
         
        $data=array(
          'condition'=>$condData,
          'pg'=>getPage(),
          'cols'=>'province_id,city_id,district_id,detail,lng,lat,store_id',
          'pageSize'=>100, 
          'trueTableName'=>'tbl_store_position',
          'extWhere'=>'',
          'keepLength'=>8,
          'lng_name'=>'lng',
          'lat_name'=>'lat',
          'lng'=>$this->lng,
          'lat'=>$this->lat
        ); 
       
        $rs=D('Distance.DistanceSort')->getPager($data);
        
        if($rs['data'])
        {
            $oStore=D('Store');
            
            foreach($rs['data'] as &$v)
            {
                $storeInfo=$oStore->getInfo($v['store_id']);
                $v=array_merge($v,$storeInfo);
            }    
        }
        returnJson(SUCCESS,$rs,array());
    }
    /**
    * 根据其它方式排序
    */ 
    private function getListByOther($city_id,$condData,$order)
    {
        $orderRef=array(
            '1'=>'score DESC',
        );
         
        $order=isset($orderRef[$order])?$orderRef[$order]:'';
        
        $condData['id']=array('SELECT store_id FROM tbl_store_position WHERE city_id='.$city_id,'in','ignore');
        
        $data=array(
          'condition'=>$condData,
          'pg'=>getPage(),
          'cols'=>'id,name,time,icon,score,time_from,time_to',
          'pageSize'=>8, 
          'order'=>$order,
          'pageStrategy'=>'phone',
          'trueTableName'=>'tbl_store',
          'extWhere'=>''
        );
          
        $rs=D('Page')->getPager($data);
        
        if($rs['data'])
        {
            $oPos=D('StorePosition');
            
            foreach($rs['data'] as &$v)
            {
                $posData=$oPos->getDetailInfo($v['id'],$this->lng,$this->lat);
                $v=array_merge($v,$posData);
            }
        }
        
        returnJson(SUCCESS,$rs,array());
    }
    
}
?>