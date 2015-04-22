<?php
class PhoneCodeModel
{
    protected $trueTableName='tbl_phone_code';
    
    public function getPhoneCode($phone)
    {
        $rs=$this->isExists($phone);
        $phoneCode=D('Identify')->getNumCode(6);
        
        if($rs)
        {
            //判断上次拉取时间和当前时间是否>=指定间隔时间
            if(NOW-$rs['pull_time']>PHONE_CODE_INTERVAL)
            {
                return -1;   //拉取频率过快
            }
            $this->saveCode($phoneCode,$phone,$rs['id']);
        }
        else
        {
            $this->saveCode($phoneCode,$phone);        
        }
        return $phoneCode;
    }
    public function isExists($phone)
    {
        $rs=M($this->trueTableName)->select('id,expire_time,pull_time','phone=\''.$phone.'\'',1);
                
        return $rs?$rs['id']:0;
    }
    public function saveCode($code,$phone,$id=0)
    {
        $data=array(
            'phone'=>$phone,
            'mcode'=>$code,
            'expire_time'=>NOW+PHONE_CODE_EXPIRE_TIME,
            'pull_time'=>NOW
        );
        //发送短信验证码
        D('Message.Sms')->sendMessage($code,$phone);
        if($id)
        {
            return M($this->trueTableName)->update($data,'id='.$id);
        }
        else
        {
            return M($this->trueTableName)->insert($data);
        }
    }
}

?>