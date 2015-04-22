<?php
class PhoneCodeAction
{
    public function getPhoneCode()
    {
        $data=array(
            array('phone','string','sj','手机号')
        );
        dataFilter($data,'post');
        
        $rs=D('PhoneCode')->getPhoneCode($data['phone']);
       
        if($rs==-1)
        {
            returnJson(FAIL,'禁止频繁拉取');
        }
        else
        {
            returnJson(SUCCESS,$rs);            
        }
    }
}

?>