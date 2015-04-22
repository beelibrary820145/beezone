<?php
class StoreTypeModel
{
    protected $trueTableName='tbl_store_type';
    
    public function getList()
    {
        return M($this->trueTableName)->select('id,name','1 ORDER BY `order` ASC');
    }
}

?>