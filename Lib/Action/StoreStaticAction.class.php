<?php
class StoreStaticAction
{
    public function getStatic()
    {
        $data=array(
            array('s_id','int')
        );
        dataFilter($data,'post');
        
        $rs=D('StoreStatic')->getStatic($data['s_id']);
        
        returnJson(SUCCESS,$rs);
    }
}
?>