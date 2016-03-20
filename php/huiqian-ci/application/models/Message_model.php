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
     * �������ݿ��������Ϣ
     */
    public function __construct()
    {
        $this->load->database();
    }

    /**
     * �����˿�����������Ϣ
     * @param $fansId ��˿ID
     * @param $content ��������
     * @param $userId �û�ID
     * @param $activityId �ID
     * @return ���������ID
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
     * �����û�ID�ͻID��ȡ���µ�������Ϣ
     * @param $userId �û�Id
     * @param $activityId �Id
     * @return mixed �����������Ϣ�б�
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
     * ��������Id��������״̬
     * @param $id ����id
     * @return int Ӱ�������
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
     * �����û�ID�ͻID��ȡ���µ��ֻ���������Ϣ
     * @param $userId �û�Id
     * @param $activityId �Id
     * @return mixed �����������Ϣ�б�
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