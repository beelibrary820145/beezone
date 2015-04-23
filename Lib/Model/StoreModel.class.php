<?php
class StoreModel
{
    protected $trueTableName='tbl_store';
    
    public function getInfo($store_id)
    {
        $hm=date('Hm',NOW);
        
        $rs=M($this->trueTableName)->select('id,name,icon,score,time_from,type_id,time_to','id='.$store_id,1);
        $rs['icon']=D('Img')->getImageById($rs['icon']);
        $rs['isBusiness']=($hm>$rs['time_from'] && $hm<$rs['time_to'])?1:0;
        $rs['time_from']=substr($rs['time_from'],0,-2).':'.substr($rs['time_from'],-2);
        $rs['time_to']=substr($rs['time_to'],0,-2).':'.substr($rs['time_from'],-2);
        $rs['type_name']=D('StoreType')->getTypeName($rs['type_id']);
        return $rs;
    }
    /**
     * 获取详情
     */
    public function getDetailInfo($store_id,$lng,$lat)
    {
        $rs=$this->getInfo($store_id);
        $pos=D('StorePosition')->getDetailInfo($store_id,$lng,$lat);
        
        return array_merge($rs,$pos);
    }
}

?>