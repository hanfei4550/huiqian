package com.yuanzhuo.huiqian.service.impl;

import com.yuanzhuo.huiqian.core.BusinessException;
import com.yuanzhuo.huiqian.dao.FansMapper;
import com.yuanzhuo.huiqian.model.Fans;
import com.yuanzhuo.huiqian.model.UserActivityFans;
import com.yuanzhuo.huiqian.service.FansMessageService;
import com.yuanzhuo.huiqian.service.FansService;
import com.yuanzhuo.huiqian.service.UserActivityFansService;
import com.yuanzhuo.huiqian.service.WhiteListService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

/**
 * Created by hanfei on 16/5/13.
 */
@Service("fansService")
public class FansServiceImpl extends BaseServiceImpl implements FansService {

    @Autowired
    private FansMapper fansMapper;

    @Autowired
    private UserActivityFansService userActivityFansService;

    @Autowired
    private WhiteListService whiteListService;

    @Autowired
    private FansMessageService fansMessageService;

    @Override
    public List<Fans> getFansByParams(int activityId, String nick, int pageIndex, int pageSize) throws Exception {
        Map<String, Object> params = new HashMap<String, Object>();
        params.put("activityId", activityId);
        params.put("nick", nick);
        return (List<Fans>) this.getPageList(FansMapper.class, "selectFansByParams", params, pageIndex, pageSize);
    }

    @Override
    public int getTotalByParams(int activityId, String nick) throws Exception {
        Map<String, Object> params = new HashMap<String, Object>();
        params.put("activityId", activityId);
        params.put("nick", nick);
        return this.getTotal(FansMapper.class, "selectTotalByParams", params);
    }

    @Override
    public int getTotalByActivityId(int activityId) throws Exception {
        return this.getTotal(FansMapper.class, "selectTotalByActivityId", activityId);
    }

    @Override
    public Fans getFansById(int fansId) {
        return fansMapper.selectByPrimaryKey(fansId);
    }

    @Override
    public int saveFans(int userId, int activityId, String nick) {
        Fans fans = new Fans();
        fans.setNick(nick);
        fans.setCreateTime(new Date());
        fansMapper.insertSelective(fans);
        UserActivityFans userActivityFans = new UserActivityFans();
        userActivityFans.setUserId(userId);
        userActivityFans.setActivityId(activityId);
        userActivityFans.setFansId(fans.getId());
        return userActivityFansService.saveUserActivityFans(userActivityFans);
    }

    @Override
    public int deleteFans(int activityId, int fansId) {
        fansMessageService.deleteMessageByActivityAndFans(activityId, fansId);
        whiteListService.deleteByActivityAndFans(activityId, fansId);
        userActivityFansService.deleteByActivityAndFans(activityId, fansId);
        return fansMapper.deleteByPrimaryKey(fansId);
    }

    @Override
    public void deleteByActivityId(int activityId) {
        fansMapper.deleteByRelationId(activityId);
    }

    @Override
    public int saveFans(Fans fans) {
        return fansMapper.insertSelective(fans);
    }

    @Override
    public void deleteByActivityNo(String activityNo) {
        fansMapper.deleteByActivityNo(activityNo);
    }


}
