<?php
class StoreCommentModel
{
    protected $trueTableName='tbl_store_comment';
    /**
     * 评论图片最多两张
     */
    public function comment($cust_id,$store_id,$content,$img_ids='',$star=3)
    {
        $data=array(
            'cust_id'=>$cust_id,
            'store_id'=>$store_id,
            'content'=>$content,
            'time'=>NOW,
            'star'=>$star
        );
        
        if($img_ids)
        {
            $imgArr=explode(',',$img_ids);
            $len=count($imgArr);
            ($len>2)&&($len=2);
            
            for($i=1;$i<=2;$i++)
            {
                $data['img_id'.$i]=$imgArr[$i-1]; 
            }
        }
        /**
         * 更新统计信息
         */
        $sData=array(
            'comment_total'=>array('comment_total+1','ignore'),
            'score'=>array($data['star'].'+score')
        );
        
        $k='';
        if($star<3)
        {
            $k='comment_lower';
        }else if($star<5)
        {
            $k='comment_middle';
        }else 
        {
            $k='comment_high';
        }
        D('StoreStatic')->add($store_id,$k,$star);
        
        if(D('Order')->isConsumed($cust_id,$store_id))
        {
            return M($this->trueTableName)->insert($data);
        }
        else
        {
          return -1;  
        }
    }
    /**
     * 判断是否已经评论过指定店铺
     */
    public function isCommented($cust_id,$store_id)
    {
        return M($this->trueTableName)->select('id','store_id='.$store_id.' AND cust_id='.$cust_id,1);
    }
}

?>