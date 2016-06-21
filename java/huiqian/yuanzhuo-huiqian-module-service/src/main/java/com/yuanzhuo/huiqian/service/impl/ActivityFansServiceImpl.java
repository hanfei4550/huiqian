package com.yuanzhuo.huiqian.service.impl;

import com.yuanzhuo.huiqian.dao.ActivityFansMapper;
import com.yuanzhuo.huiqian.model.ActivityFans;
import com.yuanzhuo.huiqian.service.ActivityFansService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;


/**
 * Created by hanfei on 16/4/19.
 */
@Service("activityFansService")
public class ActivityFansServiceImpl implements ActivityFansService {
    @Autowired
    private ActivityFansMapper activityFansMapper;

    @Override
    public int insert(ActivityFans activityFans) {
        int result = activityFansMapper.insert(activityFans);
        return result;
    }
}
