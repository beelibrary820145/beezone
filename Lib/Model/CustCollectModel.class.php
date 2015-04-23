<?php
class CustCollectModel
{
    protected $trueTableName='tbl_cust_collect';
    
    public function save($cust_id,$obj_id,$type)
    {
        $rs=$this->isCollected($cust_id,$obj_id,$type);
        
        if($rs)
        {
            return -1;
        }
        
        $inData=array(
            'cust_id'=>$cust_id,
            'obj_id'=>$obj_id,
            'type'=>$type,
            'time'=>NOW
        );
        
        return M($this->trueTableName)->insert($inData);
    }
    public function isCollected($cust_id,$obj_id,$type)
    {
         return M($this->trueTableName)->select('id','cust_id='.$cust_id.' AND obj_id='.$obj_id.' AND type='.$type,1);
    }
    public function delete($where)
    {
        return M($this->trueTableName)->delete($where);
    }
    public function getList($cust_id,$type,$lng,$lat)
    {
        $strategy=array(
            STORE_TYPE=>'store'
        );
        
        $rs=M($this->trueTableName)->select('id,obj_id,time','cust_id='.$cust_id.' AND type='.$type);
        //内容加工
        
        if(isset($strategy[$type]))
        {
            $rs=call_user_func(array($this,$strategy[$type].'Strategy'),$rs,$lng,$lat);  
        }
        
        return $rs;
    }
    private function storeStrategy($rs,$lng,$lat)
    { 
        $oStore=D('Store');
        
        foreach($rs as &$v)
        {
            $storeInfo=$oStore->getDetailInfo($v['obj_id'],$lng,$lat);
            $v=array_merge($v,$storeInfo);
        }
        
        return $rs;
    }
}
?>