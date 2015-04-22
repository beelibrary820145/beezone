<?php
class StorePositionModel
{
    protected $trueTableName='tbl_store_position';
    /**
     * 获取店铺详情
     */
    public function getDetailInfo($store_id,$lng,$lat)
    {
        $rs=M($this->trueTableName)->select('province_id,city_id,district_id,detail,lng,lat','store_id='.$store_id,1);
        
        if($rs)
        {
            $rs['address']=D('Location')->getAddress($rs['province_id'],$rs['city_id'],$rs['district_id']);
            $rs['distance']=D('Location.Distance')->getDistance($lng,$lat,$rs['lng'],$rs['lat']);
        }
        
        return $rs?$rs:'::';
    }
    /**
     * 获取店铺简要信息
     */
    public function getInfo($store_id)
    {
        $rs=M($this->trueTableName)->select('province_id,city_id,district_id,detail,lng,lat','store_id='.$store_id,1);
        
        return $rs?$rs:'::';
    }
    /**
     * 店铺地址设置
     */
    public function save($data,$store_id=0)
    {
        
    }
    private function isExists($store_id)
    {
        return M($this->trueTableName)->select('id','store_id='.$store_id,1);
    }
    public function insert($inData)
    {
        return M($this->trueTableName)->insert($inData);
    }
    public function update($upData,$where)
    {
        return M($this->trueTableName)->update($upData,$where);
    }
}
?>