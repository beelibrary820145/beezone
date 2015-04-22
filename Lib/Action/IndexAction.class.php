<?php
class IndexAction extends Action
{
    public function index()
    {
        $dbConf=array(
            'host'=>'localhost',
            'port'=>3306,
            'username'=>'root',
            'psd'=>'',
            'dbname'=>'library_o2o',
            'charset'=>'utf8'
        );
        
        $dealData=array();
        $flag=false;        //处理状态
        if(isset($_POST['sub']))
        {
           $dealData=$_POST;
           $flag=true;      
        }
        
        $oAuto=D('AutoLoad');
        $oAuto->conn($dbConf);
        
        $oAuto->init('Store',$dealData,$flag);
        $this->display();
    }
    public function built()
    {
        $oM=D('AutoLoad');
        $oM->builtDir('Store');
        
         
    }
}
?>