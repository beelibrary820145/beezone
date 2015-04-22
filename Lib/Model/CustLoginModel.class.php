<?php
class CustLoginModel
{
    protected $trueTableName='tbl_cust_login';
    /**
     * 登录成功
     */
    public function success($cust_id)
    {
        $rs=$this->isExists($cust_id);
        
        $oIp=D('Ip');
        
        $ip=$oIp->get_client_ip();
        $ip=$oIp->getInt($ip);
        
        $data=array(
            'ip'=>$ip,
            'last_login_time'=>NOW,
            'error_times'=>0,
            'times'=>array('times+1','ignore')
        );
        
        if($rs)
        {
            M($this->trueTableName)->update($data,'id='.$rs['id']);    
        }
        else
        {
            $data['cust_id']=$cust_id;
            M($this->trueTableName)->insert($data);
        }
        return true;
    }
    /**
     * 登录失败
     */
    public function fail($cust_id)
    {
        $data=array(
            'ip'=>$ip,
            'last_login_time'=>NOW,
            'error_times'=>array('error_time'),
            //'times'=>array('times+1','ignore')
        );
    }
    public function isExists($cust_id)
    {
        $rs=M($this->trueTableName)->select('id,ip,last_login_time,error_time','cust_id='.$cust_id,1);
        
        return $rs?$rs:'';
    }
}
?>