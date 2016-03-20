<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-3-17
 * Time: 11:23
 */
class Activity extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('activity_model');
        $this->load->helper('date');
    }

    public function update_activity_time()
    {
        $id = $this->input->get("id");
        $count = $this->activity_model->updateActivityTime($id);
        echo $count;
    }

    public function clear_activity_data()
    {
        $this->activity_model->clearActivity();
        echo 'clear data success!';
    }

    public function get()
    {
        $activitys = $this->activity_model->getCurrentActivity();
        foreach ($activitys as $activity) {
            echo 'user_id=' . $activity['user_id'] . ',activity_id=' . $activity['activity_id'] . 'banner=' . $activity['banner'];
        }
    }
}