package com.yuanzhuo.huiqian.service.impl;

import com.alibaba.fastjson.JSON;
import com.yuanzhuo.huiqian.dao.ActivityWinningListMapper;
import com.yuanzhuo.huiqian.model.ActivityWinningList;
import com.yuanzhuo.huiqian.service.ActivityWinningListService;
import org.apache.commons.lang3.StringUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

/**
 * Created by hanfei on 16/5/30.
 */
@Service("activityWinningListService")
public class ActivityWinningListServiceImpl extends BaseServiceImpl implements ActivityWinningListService {

    @Autowired
    private ActivityWinningListMapper activityWinningListMapper;

    @Override
    public void saveActivityWinningList(String activityWinningList) {
        List<ActivityWinningList> awlList = JSON.parseArray(activityWinningList, ActivityWinningList.class);
        for (ActivityWinningList awl : awlList) {
            activityWinningListMapper.insert(awl);
        }
    }

    @Override
    public List<ActivityWinningList> getWinningListByActivityId(int activityId) {
        return activityWinningListMapper.selectByActivityId(activityId);
    }

    @Override
    public void deleteByActivityId(int activityId) {
        activityWinningListMapper.deleteByRelationId(activityId);
    }
}
