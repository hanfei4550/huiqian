<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-3-17
 * Time: 11:14
 */
class Activity_model extends CI_Model
{
    /**
     * �������ݿ��������Ϣ
     */
    public function __construct()
    {
        $this->load->database();
    }

    /**
     * ����id���»ʱ��
     * @param $id �id
     * @return int Ӱ�������
     */
    function updateActivityTime($id)
    {
        $time = time();
        $date = date("Y-m-d", $time);
        $beginTime = $date . " 09:00:00";
        $endTime = $date . " 18:00:00";
        $data = array(
            'begin_time' => $beginTime,
            'end_time' => $endTime
        );
        $this->db->trans_start();
        $this->db->where("id", $id);
        $this->db->update("t_activitycenter_activity", $data);
        $count = $this->db->affected_rows();
        $this->db->trans_complete();
        return $count;
    }

    /**
     * �������л����
     */
    function clearActivity()
    {
        $this->db->trans_start();
        $this->db->truncate("t_usercenter_fans");
        $this->db->truncate("t_usercenter_fans_message");
        $this->db->truncate("t_activitycenter_user_activity_fans");
        $this->db->trans_complete();
    }

    /**
     * ��ѯ����Ļ
     * @return ����Ļ��Ϣ
     */
    function getCurrentActivity()
    {
        $time = time();
        $date = date("Y-m-d", $time);
        $beginTime = $date . " 00:00:00";
        $endTime = $date . " 23:59:59";
        $params = array(
            'begin_time' => $beginTime,
            'end_time' => $endTime
        );
        $query = $this->db->query("SELECT user_id,activity_id,banner FROM t_usercenter_user_activity ua INNER JOIN t_activitycenter_activity a ON ua.activity_id=a.id WHERE a.begin_time > ? AND a.end_time <= ?", $params);
        return $query->result_array();
    }
}