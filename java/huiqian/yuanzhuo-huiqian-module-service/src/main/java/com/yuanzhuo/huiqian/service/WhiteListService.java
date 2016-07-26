package com.yuanzhuo.huiqian.service;

import com.yuanzhuo.huiqian.model.Prize;
import com.yuanzhuo.huiqian.model.WhiteList;

import java.util.List;

/**
 * Created by hanfei on 16/4/19.
 */
public interface WhiteListService {

    int saveWhiteList(WhiteList whiteList);

    int updateWhiteList(WhiteList whiteList);

    List<WhiteList> getWhiteListByActivityId(int activityId);

    String getPrize(List<Prize> prizes, List<WhiteList> whiteLists, int activityId, int fansId);

    WhiteList getWhiteListByActivityAndFans(int activityId, int fansId);

    int deleteByActivityAndFans(int activityId, int fansId);

    void deleteByActivityId(int activityId);
}
