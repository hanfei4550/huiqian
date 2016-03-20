<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-3-16
 * Time: 12:03
 */
class Fans extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('fans_model');
        $this->load->helper('date');
    }

    public function get($userId = 1, $activityId = 1)
    {

        $data['fansItems'] = $this->fans_model->getFansByUserAndActivity($userId, $activityId);
        $this->load->view('fans/index', $data);
    }

    public function add()
    {
        $new_fans_id = $this->fans_model->insertFans();
        echo $new_fans_id;
    }

    public function total()
    {
        $userId = $this->input->get("userId");
        $activityId = $this->input->get("activityId");
        $orderNum = $this->fans_model->getUserCountByActivity($userId, $activityId);
        echo $orderNum;
    }

    public function add_ordernum()
    {
        $userId = $this->input->get("userId");
        $activityId = $this->input->get("activityId");
        $fansId = $this->input->get("fansId");
        $orderNum = $this->input->get("orderNum");
        $id = $this->fans_model->insertUserActivityFans($userId, $activityId, $fansId, $orderNum);
        echo $id;
    }

    public function get_ordernum()
    {
        $userId = $this->input->get("userId");
        $activityId = $this->input->get("activityId");
        $fansId = $this->input->get("fansId");
        $order_num = $this->fans_model->getOrderNumByUser($userId, $activityId, $fansId);
        echo $order_num;
    }

    public function update_signstatus()
    {
        $userId = $this->input->get("userId");
        $activityId = $this->input->get("activityId");
        $fansId = $this->input->get("fansId");
        $count = $this->fans_model->updateFansSignStatus($userId, $activityId, $fansId);
        echo $count;
    }

    public function update()
    {
        $name = $this->input->get("name");
        $phone = $this->input->get("phone");
        $nick = $this->input->get("nick");
        $count = $this->fans_model->updateFans($name, $phone, $nick);
        echo $count;
    }
}