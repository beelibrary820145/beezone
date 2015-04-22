<?php
class StoreModel
{
    protected $trueTableName='tbl_store';
    
    public function getInfo($store_id)
    {
        $hm=date('Hm',NOW);
        
        $rs=M($this->trueTableName)->select('id,name,time,icon,score,time_from,time_to','id='.$store_id,1);
        $rs['icon']=D('Img')->getImageById($rs['icon']);
        $rs['isBusiness']=($hm>$rs['time_from'] && $hm<$rs['time_to'])?1:0;
        $rs['time_from']=substr($rs['time_from'],0,-2).':'.substr($rs['time_from'],-2);
        $rs['time_to']=substr($rs['time_to'],0,-2).':'.substr($rs['time_from'],-2);
        
        return $rs;
    }
}

?>