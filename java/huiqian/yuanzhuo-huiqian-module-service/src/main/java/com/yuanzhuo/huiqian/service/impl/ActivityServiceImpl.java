package com.yuanzhuo.huiqian.service.impl;

import com.yuanzhuo.huiqian.core.BusinessException;
import com.yuanzhuo.huiqian.core.HuiqianErrorCode;
import com.yuanzhuo.huiqian.core.HuiqianFansStatus;
import com.yuanzhuo.huiqian.dao.ActivityMapper;
import com.yuanzhuo.huiqian.dao.FansMapper;
import com.yuanzhuo.huiqian.dao.UserActivityFansMapper;
import com.yuanzhuo.huiqian.model.*;
import com.yuanzhuo.huiqian.service.*;
import com.yuanzhuo.huiqian.util.ActivityNoUtil;
import com.yuanzhuo.huiqian.util.DateUtil;
import jxl.Cell;
import jxl.Sheet;
import jxl.Workbook;
import org.apache.commons.lang.StringUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.io.File;
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
    private FansService fansService;

    @Autowired
    private UserActivityFansService userActivityFansService;

    @Autowired
    private FansMessageService fansMessageService;

    @Autowired
    private WhiteListService whiteListService;

    @Autowired
    private UserActivityService userActivityService;

    @Autowired
    private ActivityFansService activityFansService;

    @Autowired
    private ActivityWinningListService activityWinningListService;

    @Autowired
    private PrizeService prizeService;

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
        Date beginTime = activity.getBeginTime();
        Date currentTime = new Date();
        if (beginTime.before(currentTime)) {
            logger.info("当前时间:{}晚于活动开始时间:{},直接退出.", DateUtil.dateToString(currentTime), DateUtil.dateToString(beginTime));
            return;
        }
        int activityId = activity.getId();
        UserActivity userActivity = userActivityService.getByActivityId(activityId);
        fansMessageService.deleteMessageByActivityAndFans(activityId, 0);
        List<WhiteList> whiteLists = whiteListService.getWhiteListByActivityId(activityId);
//        whiteListService.deleteByActivityAndFans (activityId, 0);
        fansService.deleteByActivityNo(activityNo);
        userActivityFansService.deleteByActivityNo(activityNo);
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
            fansService.saveFans(fans);

            UserActivityFans userActivityFans = new UserActivityFans();
            userActivityFans.setFansId(fans.getId());
            userActivityFans.setActivityId(activityId);
            userActivityFans.setUserId(userActivity.getUserId());
            userActivityFans.setOrderNum(orderNum);
            userActivityFans.setStatus(HuiqianFansStatus.HUIQIAN_USERCENTER_FANS_STATUS_PROCESS.ordinal());
            userActivityFansService.saveUserActivityFans(userActivityFans);

            whiteList.setFansId(fans.getId());
            whiteListService.updateWhiteList(whiteList);
            orderNum++;
        }
    }

    @Override
    public void deleteActivityById(int activityId) {
        activityFansService.deleteByActivityId(String.valueOf(activityId));
        activityWinningListService.deleteByActivityId(activityId);
        fansMessageService.deleteByActivityId(activityId);
        prizeService.deleteByActivityId(activityId);
        whiteListService.deleteByActivityId(activityId);
        userActivityFansService.deleteByActivityId(activityId);
        userActivityService.deleteByActivityId(activityId);
        activityMapper.deleteByPrimaryKey(activityId);
    }

    @Override
    public void recoverActivityDataByActivityNoAndFile(int userId, int activityId, String filePath) {
        Workbook workbook = null;
        String currentName = "";
        try {
            workbook = Workbook.getWorkbook(new File(filePath));
            Sheet sheet = workbook.getSheet(0);
            int totalCount = sheet.getRows();
            System.out.println("总共有多少条数据:" + totalCount);
            for (int i = 0; i < totalCount; i++) {
                Cell[] cells = sheet.getRow(i);
                String nick = cells[0].getContents();
                String name = cells[1].getContents();
                String mobile = cells[2].getContents();
                String company = cells[3].getContents();
                currentName = nick;
                Fans fans = new Fans();
                fans.setNick(nick);
                fans.setName(name);
                fans.setPhone(mobile);
                fans.setCompany(company);
                fans.setCreateTime(new Date());
                fansService.saveFans(fans);
                UserActivityFans userActivityFans = new UserActivityFans();
                userActivityFans.setActivityId(activityId);
                userActivityFans.setFansId(fans.getId());
                userActivityFans.setStatus(HuiqianFansStatus.HUIQIAN_USERCENTER_FANS_STATUS_PROCESS.ordinal());
                userActivityFans.setOrderNum(i + 1);
                userActivityFans.setUserId(userId);
                userActivityFansService.saveUserActivityFans(userActivityFans);
                logger.info("插入用户名为:{}成功!", nick);
            }
        } catch (Exception e) {
            logger.error("当前用户名为:{},异常信息:{}", currentName, e.getMessage());
        }
    }

}
