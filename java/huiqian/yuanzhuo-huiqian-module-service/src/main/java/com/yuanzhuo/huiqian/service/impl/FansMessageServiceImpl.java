package com.yuanzhuo.huiqian.service.impl;

import com.yuanzhuo.huiqian.dao.FansMessageMapper;
import com.yuanzhuo.huiqian.service.FansMessageService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.HashMap;
import java.util.Map;

/**
 * Created by hanfei on 16/5/31.
 */
@Service("fansMessageService")
public class FansMessageServiceImpl implements FansMessageService {

    @Autowired
    private FansMessageMapper fansMessageMapper;

    @Override
    public int deleteMessageByActivityAndFans(int activityId, int fansId) {
        Map<String, Object> params = new HashMap<String, Object>();
        params.put("activityId", activityId);
        params.put("fansId", fansId);
        return fansMessageMapper.deleteByParams(params);
    }

    @Override
    public void deleteByActivityId(int activityId) {
        Map<String, Object> params = new HashMap<String, Object>();
        params.put("activityId", activityId);
        fansMessageMapper.deleteByParams(params);
    }
}
