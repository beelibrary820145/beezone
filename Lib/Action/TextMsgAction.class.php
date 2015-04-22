<?php
/**
 * 消息相关
 */
class TextMsgAction extends Codecheck
{
    /**
     * 发送消息
     */
    public function sendMsg()
    {
        $data=array(
            array('target_id','int'),
            array('msg_type','int'),
            array('msg','string'),
            array('perOrGroup','int')     //群消息 和 用户消息
        );
        dataFilter($data,'post');
        
        $user_id=$group_id=0;
        $data['perOrGroup']==1?$user_id=$data['target_id']:$group_id=$data['target_id'];
        $msg_id=D('Chatmsg')->sendMsg($_SESSION['userinfo']['c_id'],$data['perOrGroup'],$user_id,$group_id,$data['msg_type'],$data['msg']);

        $retData=array(
            'id'=>$msg_id,
            'content'=>$data['msg'],
            'time'=>NOW,
            'type'=>$data['msg_type'],
            'perOrGroup'=>$data['perOrGroup'],
            'receive_userid'=>$user_id,
            'group_id'=>$group_id
        );
        returnJson(SUCCESS,$retData);
    }
}
?>