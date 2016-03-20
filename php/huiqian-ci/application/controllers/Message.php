<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-3-17
 * Time: 16:16
 */
class Message extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('message_model');
        $this->load->helper('date');
    }

    public function add()
    {
        $userId = $this->input->get("userId");
        $activityId = $this->input->get("activityId");
        $fansId = $this->input->get("fansId");
        $content = $this->input->get("content");
        $id = $this->message_model->insertFansMessage($fansId, $content, $userId, $activityId);
        echo $id;
    }

    public function get()
    {
        $userId = $this->input->get("userId");
        $activityId = $this->input->get("activityId");
        $messages = $this->message_model->getRecentFansMessage($userId, $activityId);
        foreach ($messages as $message) {
            echo $message['nick'] . $message['content'];
        }
    }

    public function get_mobile_message()
    {
        $userId = $this->input->get("userId");
        $activityId = $this->input->get("activityId");
        $messages = $this->message_model->getMobileFansMessage($userId, $activityId);
        foreach ($messages as $message) {
            echo $message['nick'] . $message['content'];
        }
    }

    public function update_status()
    {
        $id = $this->input->get("id");
        $count = $this->message_model->updateMessageStatus($id);
        echo $count;
    }
}