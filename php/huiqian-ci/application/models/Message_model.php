<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-3-17
 * Time: 11:14
 */
class Message_model extends CI_Model
{
    /**
     * 加载数据库的配置信息
     */
    public function __construct()
    {
        $this->load->database();
    }

    /**
     * 插入粉丝发表的评论信息
     * @param $fansId 粉丝ID
     * @param $content 评论内容
     * @param $userId 用户ID
     * @param $activityId 活动ID
     * @return 插入的评论ID
     */
    function insertFansMessage($fansId, $content, $userId, $activityId)
    {
        $datestring = "%Y-%m-%d %H:%m:%s";
        $time = time();
        $datetime = mdate($datestring, $time);

        $data = array(
            'fans_id' => $fansId,
            'content' => $content,
            'user_id' => $userId,
            'activity_id' => $activityId,
            'create_datetime' => $datetime
        );
        $this->db->trans_start();
        $this->db->insert("t_usercenter_fans_message", $data);
        $id = $this->db->insert_id();
        $this->db->trans_complete();
        return $id;
    }

    /**
     * 根据用户ID和活动ID获取最新的评论信息
     * @param $userId 用户Id
     * @param $activityId 活动Id
     * @return mixed 最近的评论信息列表
     */
    function getRecentFansMessage($userId, $activityId)
    {
        $params = array(
            'user_id' => $userId,
            'activityId' => $activityId
        );
        $query = $this->db->query("SELECT m.id,nick,content FROM t_usercenter_fans_message m INNER JOIN t_usercenter_fans f ON m.fans_id= f.id WHERE user_id=? AND activity_id=? AND  STATUS=0 AND create_datetime <= NOW()", $params);
        return $query->result_array();
    }

    /**
     * 根据评论Id更新评论状态
     * @param $id 评论id
     * @return int 影响的行数
     */
    function updateMessageStatus($id)
    {
        $this->db->trans_start();
        $this->db->where("id", $id);
        $data = array(
            'status' => 1
        );
        $this->db->update("t_usercenter_fans_message", $data);
        $count = $this->db->affected_rows();
        $this->db->trans_complete();
        return $count;
    }

    /**
     * 根据用户ID和活动ID获取最新的手机端评论信息
     * @param $userId 用户Id
     * @param $activityId 活动Id
     * @return mixed 最近的评论信息列表
     */
    function getMobileFansMessage($userId, $activityId)
    {
        $params = array(
            'user_id' => $userId,
            'activityId' => $activityId
        );
        $query = $this->db->query("SELECT m.id,nick,f.head_portraint,content FROM t_usercenter_fans_message m INNER JOIN t_usercenter_fans f ON m.fans_id= f.id WHERE user_id=? AND activity_id=? AND create_datetime >= now()-interval 5 second order by id desc limit 0,5", $params);
        return $query->result_array();
    }
}