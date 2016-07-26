package com.yuanzhuo.huiqian.service;

import com.yuanzhuo.huiqian.core.BusinessException;
import com.yuanzhuo.huiqian.model.Activity;
import com.yuanzhuo.huiqian.model.ActivityVO;
import com.yuanzhuo.huiqian.model.Fans;

import java.util.List;

/**
 * Created by hanfei on 16/4/19.
 */
public interface FansService {
    List<Fans> getFansByParams(int activityId, String nick, int pageIndex, int pageSize) throws Exception;

    int getTotalByParams(int activityId, String nick) throws Exception;

    int getTotalByActivityId(int activityId) throws Exception;

    Fans getFansById(int fansId);

    int saveFans(int userId, int activityId, String nick);

    int deleteFans(int activityId, int fansId);

    void deleteByActivityId(int activityId);

    int saveFans(Fans fans);

    void deleteByActivityNo(String activityNo);
}
