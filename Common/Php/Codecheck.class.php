<?php
class Codecheck
{
    public function __construct()
    {
        $this->checkCode();
    }
    public function checkCode()
    {
        $data=array(
            array('code','string')
        );
        dataFilter($data,'post');
        //校验码检查
        
        $rs=D('CustCode')->checkValid($data['code']);
        
        if($rs===false)
        {
            returnJson(CODE_RROR,'校验码错误');
        }
        else if($rs==-1)
        {
            returnJson(CODE_EXPIRE,'用户校验码已过期,请重新登陆');    
        } 
        else
        {
            $_SESSION['userinfo']=array();
            $_SESSION['userinfo']['id']=$rs;
        }
        return true;
    }
}
?>