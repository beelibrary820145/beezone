<?php
class CustPositionModel
{
    protected $trueTableName='tbl_cust_position';
    
    public function saveLocation($cust_id,$lng,$lat)
    {
        $data=array(
            'cust_id'=>$cust_id,
            'lat'=>$lat,
            'lng'=>$lng
        );
        $oM=M($this->trueTableName);
        
        $rs=$this->ifExists($cust_id);
        if($rs)
        {
            return $oM->update($data,'id='.$rs);   
        }
        else
        {
            return $oM->insert($data);
        }
    } 
    public function saveArea($cust_id,$province_id,$city_id,$district_id,$detail)
    {
        $rs=$this->ifExists($cust_id);
        
        
        $data=array();
        
        if($province_id)
        {
            $data['province_id']=$province_id;
        }
        if($city_id)
        {
            $data['city_id']=$city_id;
        }
        if($district_id)
        {
            $data['district_id']=$district_id;
        }
        if($detail)
        {
            $data['detail']=$detail;
        }
        
        if($rs)
        {
            return M($this->trueTableName)->update($data,'id='.$rs);
        }
        else
        {
            $data['cust_id']=$cust_id;
            return M($this->trueTableName)->insert($data);
        }
    }
    public function saveAreaId($cust_id,$province_id,$city_id,$district_id,$detail)
    {
        $rs=$this->ifExists($cust_id);
        
        
        $data=array();
        
        if($province_id)
        {
            $data['province_id']=$province_id;
        }
        if($city_id)
        {
            $data['city_id']=$city_id;
        }
        if($district_id)
        {
            $data['district_id']=$district_id;
        }
        if($detail)
        {
            $data['detail']=$detail;
        }
        
        if($rs)
        {
            return M($this->trueTableName)->update($data,'id='.$rs);
        }
        else
        {
            $data['cust_id']=$cust_id;
            return M($this->trueTableName)->insert($data);
        }
    }
    /**
     * 判断用户是否存在 
     */
    public function ifExists($cust_id)
    {
        $rs=M($this->trueTableName)->select('id','cust_id='.$cust_id,1);
        return $rs?$rs['id']:0;
    }
    /**
     * 获取用户信息
     */
    public function getPositionInfo($cust_id)
    {
        $rs=M($this->trueTableName)->select('lat,lng,province_id,city_id,district_id,detail','cust_id='.$cust_id,1);
        return $rs?$rs:'::';
    }
    
}
?>