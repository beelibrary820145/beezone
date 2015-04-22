<?php
class CustPositionAction
{
    public function saveLocation()
    {
        codecheck();
        
        $data=array(
            array('lat','float'),
            array('lng','float')
        );
        dataFilter($data,'post');
        $rs=D('CustPosition')->saveLocation($_SESSION['userinfo']['id'],$data['lng'],$data['lat']);
        returnJson(SUCCESS,'','操作成功');
    }
    public function saveAreaById()
    {
        $detail=array();
        
        $data=array(
            array('province_id','int'),
            array('city_id','int'),
            array('district_id','int')
                
        );
        dataFilter($data,'post');
        
        if(isset($_POST['detail']) && $_POST['detail'])
        {
            $detail=$_POST['detail'];
        }
        
        D('CustPosition')->saveArea($_SESSION['userinfo']['id'],$data['province_id'],$data['city_id'],$data['district_id'],$detail);
        returnJson(SUCCESS,'','操作成功!');
    }
    public function saveArea()
    {
        codecheck();
        
        $province='';
        $city='';
        $district='';
        $detail='';
        
        if(isset($_POST['province']) && $_POST['province'])
        {
            $province=$_POST['province'];
        }
        if(isset($_POST['city']) && $_POST['city'])
        {
            $province=$_POST['city'];
        }
        if(isset($_POST['district']) && $_POST['district'])
        {
            $district=$_POST['district'];
        }
        if(isset($_POST['detail']) && $_POST['detail'])
        {
            $detail=$_POST['detail'];
        }
        
        $areaData=D('Location')->getRefer($province,$city,$district);
   
        D('CustPosition')->saveArea($_SESSION['userinfo']['id'],$areaData['province_id'],$areaData['city_id'],$areaData['district_id'],$detail);
        
        returnJson(SUCCESS,'','操作成功!');
    }
}
?>