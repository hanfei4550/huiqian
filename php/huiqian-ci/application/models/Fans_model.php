<?php

/**
 * ����ά��ǩ���ķ�˿����
 * User: coffeecat
 * Date: 2016-3-16
 * Time: 11:41
 */
class Fans_model extends CI_Model
{
    /**
     * �������ݿ��������Ϣ
     */
    public function __construct()
    {
        $this->load->database();
    }

    /**
     * �����û�id�ͻid��ȡ��ǩ���ķ�˿�б�
     * @param $userId �û�id
     * @param $activityId  �id
     * @return mixed ��ǩ���ķ�˿�б�
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
     * ���ݷ�˿�ǳƻ�ȡ��˿ͷ��
     * @param $nick ��˿�ǳ�
     * @return mixed ��˿ͷ��
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
     * �����˿��Ϣ
     * @return ��ǩ���ķ�˿id
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
     * �����û�id�ͻid��ѯǩ�����û�����
     * @param $userId �û�id
     * @param $activityId �id
     * @return ǩ������
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
     * �����û���ǩ������
     * @param $userId �û�id
     * @param $activityId �id
     * @param $fansId  ��˿id
     * @param $orderNum ��˿ǩ������
     * @return int ǩ���ķ�˿ID
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
     * �����û�id���id����˿id��ѯ��˿��ǩ������
     * @param $userId �û�id
     * @param $activityId �id
     * @param $fansId  ��˿id
     * @return mixed  ��˿��ǩ������
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
     * ���·�˿ǩ��״̬
     * @param $userId �û�id
     * @param $activityId �id
     * @param $fansId ��˿id
     * @return ���µļ�¼��
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
     * ���ݷ�˿�ǳƸ��·�˿�����ƺ��ֻ�
     * @param $name ��˿����
     * @param $phone ��˿�ֻ�
     * @param $nick ��˿�ǳ�
     * @return ���µ�����
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