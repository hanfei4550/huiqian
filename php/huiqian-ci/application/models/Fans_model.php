<?php

/**
 * 用于维护签到的粉丝数据
 * User: coffeecat
 * Date: 2016-3-16
 * Time: 11:41
 */
class Fans_model extends CI_Model
{
    /**
     * 加载数据库的配置信息
     */
    public function __construct()
    {
        $this->load->database();
    }

    /**
     * 根据用户id和活动id获取新签到的粉丝列表
     * @param $userId 用户id
     * @param $activityId  活动id
     * @return mixed 新签到的粉丝列表
     */
    public function getFansByUserAndActivity($userId, $activityId)
    {
        $params = array(
            "user_id" => $userId,
            "activity_id" => $activityId
        );
        $query = $this->db->query("SELECT f.id,f.nick,f.head_portraint FROM t_activitycenter_user_activity_fans uaf INNER JOIN t_usercenter_fans f ON uaf.fans_id= f.id WHERE user_id=? AND activity_id=? AND create_time < NOW() and status=0", $params);
        return $query->result_array();
    }

    /**
     * 根据粉丝昵称获取粉丝头像
     * @param $nick 粉丝昵称
     * @return mixed 粉丝头像
     */
    function getFansInfoByNick($nick)
    {
        $params = array(
            "nick" => $nick
        );
        $query = $this->db->query("select id,head_portraint from t_usercenter_fans where nick=?");
        return $query->result_array();
    }

    /**
     * 保存粉丝信息
     * @return 新签到的粉丝id
     */
    function insertFans()
    {
        $datestring = "%Y-%m-%d %h:%m:%s";
        $time = time();
        $datetime = mdate($datestring, $time);
        $params = array(
            "nick" => $this->input->get("nick"),
            "head_portraint" => $this->input->get("head_portraint"),
            "create_time" => $datetime
        );
        $this->db->trans_start();
        $this->db->insert("t_usercenter_fans", $params);
        $newId = $this->db->insert_id();
        $this->db->trans_complete();
        return $newId;
    }

    /**
     * 根据用户id和活动id查询签到的用户次序
     * @param $userId 用户id
     * @param $activityId 活动id
     * @return 签到次序
     */
    function getUserCountByActivity($userId, $activityId)
    {
        $params = array(
            "user_id" => $userId,
            "activity_id" => $activityId
        );
        $query = $this->db->query("SELECT * FROM t_activitycenter_user_activity_fans WHERE user_id=? AND activity_id=?", $params);
        $count = $query->num_rows();
        $userCount = 0;
        $userCount = $count + 1;
        return $userCount;
    }

    /**
     * 插入用户的签到次序
     * @param $userId 用户id
     * @param $activityId 活动id
     * @param $fansId  粉丝id
     * @param $orderNum 粉丝签到次序
     * @return int 签到的粉丝ID
     */
    function insertUserActivityFans($userId, $activityId, $fansId, $orderNum)
    {
        $params = array(
            "user_id" => $userId,
            "activity_id" => $activityId,
            "fans_id" => $fansId,
            "order_num" => $orderNum
        );
        $this->db->trans_start();
        $this->db->insert("t_activitycenter_user_activity_fans", $params);
        $id = $this->db->insert_id();
        $this->db->trans_complete();
        return $id;
    }

    /**
     * 根据用户id，活动id，粉丝id查询粉丝的签到次序
     * @param $userId 用户id
     * @param $activityId 活动id
     * @param $fansId  粉丝id
     * @return mixed  粉丝的签到次序
     */
    function getOrderNumByUser($userId, $activityId, $fansId)
    {
        $params = array(
            "user_id" => $userId,
            "activity_id" => $activityId,
            "fansId" => $fansId
        );
        $query = $this->db->query("SELECT order_num FROM t_activitycenter_user_activity_fans WHERE user_id=? AND activity_id=? and fans_id=?", $params);
        $order_num = $query->row()->order_num;
        return $order_num;
    }


    /**
     * 更新粉丝签到状态
     * @param $userId 用户id
     * @param $activityId 活动id
     * @param $fansId 粉丝id
     * @return 更新的记录数
     */
    function updateFansSignStatus($userId, $activityId, $fansId)
    {
        $this->db->where('user_id', $userId);
        $this->db->where('activity_id', $activityId);
        $this->db->where('fans_id', $fansId);
        $data = array('status' => 1);
        $this->db->trans_start();
        $this->db->update("t_activitycenter_user_activity_fans", $data);
        $count = $this->db->affected_rows();
        $this->db->trans_complete();
        return $count;
    }

    /**
     * 根据粉丝昵称更新粉丝的名称和手机
     * @param $name 粉丝名称
     * @param $phone 粉丝手机
     * @param $nick 粉丝昵称
     * @return 更新的条数
     */
    function updateFans($name, $phone, $nick)
    {
        $data = array(
            'name' => $name,
            'phone' => $phone
        );
        $this->db->trans_start();
        $this->db->where('nick', $nick);
        $this->db->update("t_usercenter_fans", $data);
        $count = $this->db->affected_rows();
        $this->db->trans_complete();
        return $count;
    }


}