<?php
class OrderModel
{
    protected $trueTableName='tbl_order';
    
    public function isConsumed($cust_id,$store_id)
    {
        return M($this->trueTableName)->select('id','cust_id='.$cust_id.' AND store_id='.$store_id.' AND status=1',1);
    }
}

?>