<?php
class StoreCommentAction
{
    public function comment()
    {
        codecheck();
        
        $data=array(
            array('s_id','int'),
            array('star','int')
        );
        dataFilter($data,'post');
        
        $content='';
        $img_ids='';
        
        if(isset($_POST['content']) && $_POST['content'])
        {
            $content=$_POST['content'];
        }
        if(isset($_POST['img_ids']) && $_POST['img_ids'])
        {
            $img_ids=$_POST['img_ids'];
        }
        
        $rs=D('StoreComment')->comment($_SESSION['userinfo']['id'],$data['s_id'],$content,$img_ids,$data['star']);
        
        if($rs==-1)
        {
            returnJson(FAIL,'您在该店铺无消费记录,暂不支持评论!');
        }
        else
        {
            returnJson(SUCCESS,'','操作成功!');   
        }
    }
}
?>