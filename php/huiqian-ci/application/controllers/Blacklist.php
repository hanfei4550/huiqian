<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-3-17
 * Time: 15:03
 */
class Blacklist extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('blacklist_model');
        $this->load->helper('date');
    }

    public function add()
    {
        $fansId = $this->input->get("fansId");
        $nick = $this->input->get("nick");
        $name = $this->input->get("name");
        $userId = $this->input->get("userId");
        $activityId = $this->input->get("activityId");
        $id = $this->blacklist_model->addBlacklist($fansId, $nick, $name, $userId, $activityId);
        echo $id;
    }

    public function get()
    {
        $userId = $this->input->get("userId");
        $activityId = $this->input->get("activityId");
        $blacklists = $this->blacklist_model->getBlacklistByUserAndActivity($userId, $activityId);
        foreach ($blacklists as $blacklist) {
            echo 'id=' . $blacklist['id'] . ',nick=' . $blacklist['nick'] . 'name=' . $blacklist['name'];
        }
    }

    public function delete()
    {
        $id = $this->input->get("id");
        $count = $this->blacklist_model->removeBlacklist($id);
        echo $count;
    }

}