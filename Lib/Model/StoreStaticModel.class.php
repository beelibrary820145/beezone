<?php
class StoreStaticModel
{
    protected $trueTableName='tbl_store_static';
    /**
     * 获取统计信息
     */
    public function getStatic($store_id)
    {
        return M($this->trueTableName)->select('comment_total,comment_high,comment_middle,comment_lower','store_id='.$store_id,1);
    }
    public function add($store_id,$k,$star=0)
    {
        $rs=$this->isExists($store_id);
        $data=array();
        
        if($rs)
        {
            $data['comment_total']=array('comment_total+1','ignore');
            $data[$k]=array($k.'+1','ignore');
            $data['score']=array('score+'.$star,'ignore');
            
            return M($this->trueTableName)->update($data,'id='.$rs['id']);
        }
        else
        {
            $data[$k]=1;
            $data['comment_total']=1;
            $data['store_id']=$store_id;
            $data['score']=$star;
            
            return M($this->trueTableName)->insert($data);    
        }
           
    }
    public function isExists($store_id)
    {
        return M($this->trueTableName)->select('id','store_id='.$store_id,1);
    }
}

?>