<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-3-17
 * Time: 14:38
 */
class Blacklist_model extends CI_Model
{
    /**
     * 加载数据库的配置信息
     */
    public function __construct()
    {
        $this->load->database();
    }

    public function addBlacklist($fansId, $nick, $name, $userId, $activityId)
    {
        $params = array(
            'fans_id' => $fansId,
            'nick' => $nick,
            'name' => $name,
            'user_id' => $userId,
            'activity_id' => $activityId
        );
        $this->db->trans_start();
        $this->db->insert("t_usercenter_blacklist", $params);
        $id = $this->db->insert_id();
        $this->db->trans_complete();
        return $id;
    }

    function getBlacklistByUserAndActivity($userId, $activityId)
    {
        $params = array(
            'user_id' => $userId,
            'activity_id' => $activityId
        );
        $query = $this->db->query("SELECT id,nick,name FROM t_usercenter_blacklist WHERE user_id=? AND activity_id=?", $params);
        return $query->result_array();
    }

    function removeBlacklist($id)
    {
        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->delete('t_usercenter_blacklist');
        $count = $this->db->affected_rows();
        $this->db->trans_complete();
        return $count;
    }
}