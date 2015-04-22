<?php
class StoreTypeAction
{
    public function getList()
    {
        $rs=D('StoreType')->getList();
        
        returnJson(SUCCESS,$rs);
    }
}

?>