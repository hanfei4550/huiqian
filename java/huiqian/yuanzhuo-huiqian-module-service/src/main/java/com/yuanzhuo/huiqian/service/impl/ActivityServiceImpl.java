package com.yuanzhuo.huiqian.service.impl;

import com.yuanzhuo.huiqian.core.BusinessException;
import com.yuanzhuo.huiqian.core.HuiqianErrorCode;
import com.yuanzhuo.huiqian.core.HuiqianFansStatus;
import com.yuanzhuo.huiqian.dao.ActivityMapper;
import com.yuanzhuo.huiqian.dao.FansMapper;
import com.yuanzhuo.huiqian.dao.UserActivityFansMapper;
import com.yuanzhuo.huiqian.model.*;
import com.yuanzhuo.huiqian.service.ActivityService;
import com.yuanzhuo.huiqian.service.FansMessageService;
import com.yuanzhuo.huiqian.service.UserActivityService;
import com.yuanzhuo.huiqian.service.WhiteListService;
import com.yuanzhuo.huiqian.util.ActivityNoUtil;
import com.yuanzhuo.huiqian.util.DateUtil;
import org.apache.commons.lang.StringUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.Date;
import java.util.List;


/**
 * Created by hanfei on 16/4/19.
 */
@Service("activityService")
public class ActivityServiceImpl extends BaseServiceImpl implements ActivityService {
    @Autowired
    private ActivityMapper activityMapper;

    @Autowired
    private FansMapper fansMapper;

    @Autowired
    private UserActivityFansMapper userActivityFansMapper;

    @Autowired
    private FansMessageService fansMessageService;

    @Autowired
    private WhiteListService whiteListService;

    @Autowired
    private UserActivityService userActivityService;

    @Override
    public List<Activity> getAllActivity(int pageIndex, int pageSize) throws Exception {
        return (List<Activity>) this.getPageList(ActivityMapper.class, "selectAllActivity", null, pageIndex, pageSize);
    }

    @Override
    public int getTotal() throws Exception {
        return this.getTotal(ActivityMapper.class, "selectTotal", null);
    }

    @Override
    public Activity getActivityById(int id) {
        return activityMapper.selectByPrimaryKey(id);
    }

    @Override
    public List<Activity> getActivityByMemberId(int memberId, int pageIndex, int pageSize) throws Exception {
        return (List<Activity>) this.getPageList(ActivityMapper.class, "selectActivityByUserId", memberId, pageIndex, pageSize);
    }

    @Override
    public int getTotalByMemberId(int memberId) throws Exception {
        return this.getTotal(ActivityMapper.class, "selectTotalByUserId", memberId);
    }

    @Override
    public int saveActivity(ActivityVO activityVO) {
        Activity activity = new Activity();
        String beginTimeStr = activityVO.getBeginTime();
        String endTimeStr = activityVO.getEndTime();
        Date beginTime = DateUtil.parse(beginTimeStr);
        Date endTime = DateUtil.parse(endTimeStr);
        activity.setBeginTime(beginTime);
        activity.setEndTime(endTime);
        activity.setName(activityVO.getName());
        activity.setSubject(activityVO.getSubject());
        activity.setScale(activityVO.getScale());
        activity.setIndustry(activityVO.getIndustry());
        activity.setBanner("");
        activity.setIsValidateUser(activityVO.getIsValidateUser());
        activity.setFunctions(activityVO.getFunctions());
        String activityNo = ActivityNoUtil.generateActivityNo();
        if (StringUtils.isBlank(activityNo)) {
            throw new BusinessException(HuiqianErrorCode.HUIQIAN_ACTIVITYCENTER_ACTIVITYNO_NULL);
        }
        activity.setActivityNo(activityNo);
        activityMapper.insert(activity);
        return activity.getId();
    }

    @Override
    public Activity getActivityByActivityNo(String activityNo) {
        return activityMapper.selectByActivityNo(activityNo);
    }

    @Override
    public void deleteActivityDataByActivityNo(String activityNo) {
        if (StringUtils.isBlank(activityNo)) {
            throw new BusinessException(HuiqianErrorCode.HUIQIAN_ACTIVITYCENTER_ACTIVITYNO_NULL);
        }
        Activity activity = activityMapper.selectByActivityNo(activityNo);
        if (null == activity) {
            throw new BusinessException(HuiqianErrorCode.HUIQIAN_ACTIVITYCENTER_ACTIVITY_NOT_EXISTS);
        }
        int activityId = activity.getId();
        UserActivity userActivity = userActivityService.getByActivityId(activityId);
        fansMessageService.deleteMessageByActivityAndFans(activityId, 0);
        List<WhiteList> whiteLists = whiteListService.getWhiteListByActivityId(activityId);
//        whiteListService.deleteByActivityAndFans (activityId, 0);
        fansMapper.deleteByActivityNo(activityNo);
        userActivityFansMapper.deleteByActivityNo(activityNo);
        int orderNum = 1;
        for (WhiteList whiteList : whiteLists) {
            Fans fans = new Fans();
            fans.setNick(whiteList.getFansNick());
            fans.setName(whiteList.getFans().getName());
            fans.setHeadPortraint(whiteList.getFans().getHeadPortraint());
            fans.setPhone(whiteList.getFans().getPhone());
            fans.setCompany(whiteList.getFans().getCompany());
            fans.setPrize(String.valueOf(whiteList.getPrizeCode()));
            fans.setCreateTime(new Date());
            fansMapper.insertSelective(fans);

            UserActivityFans userActivityFans = new UserActivityFans();
            userActivityFans.setFansId(fans.getId());
            userActivityFans.setActivityId(activityId);
            userActivityFans.setUserId(userActivity.getUserId());
            userActivityFans.setOrderNum(orderNum);
            userActivityFans.setStatus(HuiqianFansStatus.HUIQIAN_USERCENTER_FANS_STATUS_PROCESS.ordinal());
            userActivityFansMapper.insertSelective(userActivityFans);

            whiteList.setFansId(fans.getId());
            whiteListService.updateWhiteList(whiteList);
            orderNum++;
        }
    }

}
