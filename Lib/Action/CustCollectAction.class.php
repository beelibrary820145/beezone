<?php
class CustCollectAction
{
    public function collect()
    {
        codecheck();
        
        $data=array(
            array('type','int'),
            array('obj_id','int')
        );
        dataFilter($data,'post');
        
        $rs=D('CustCollect')->save($_SESSION['userinfo']['id'],$data['obj_id'],$data['type']);
        
        returnJson(SUCCESS,'','操作成功!');
    }
    public function cacelCollect()
    {
        codecheck();
        
        $data=array(
            array('type','int'),
            array('obj_id','int')
        );
        dataFilter($data,'post');
        
        $rs=D('CustCollect')->delete('cust_id='.$_SESSION['userinfo']['id'].' AND type='.$data['type'].' AND obj_id='.$data['obj_id']);
        
        returnJson(SUCCESS,'','操作成功!');
    }
    public function getList()
    {
        codecheck();
        
        $data=array(
            array('type','int'),
            array('lng','double'),
            array('lat','double')
        );
        dataFilter($data,'post');
        
        $rs=D('CustCollect')->getList($_SESSION['userinfo']['id'],STORE_TYPE,$data['lng'],$data['lat']);
        
        returnJson(SUCCESS,$rs);
    }
    
}
?>