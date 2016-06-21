package com.yuanzhuo.huiqian.service.impl;

import com.yuanzhuo.huiqian.dao.WhiteListMapper;
import com.yuanzhuo.huiqian.model.Prize;
import com.yuanzhuo.huiqian.model.WhiteList;
import com.yuanzhuo.huiqian.service.WhiteListService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

/**
 * Created by hanfei on 16/5/26.
 */
@Service("whiteListService")
public class WhiteListServiceImpl implements WhiteListService {
    @Autowired
    private WhiteListMapper whiteListMapper;

    @Override
    public int saveWhiteList(WhiteList whiteList) {
        return whiteListMapper.insert(whiteList);
    }

    @Override
    public int updateWhiteList(WhiteList whiteList) {
        return whiteListMapper.updateByPrimaryKey(whiteList);
    }

    @Override
    public List<WhiteList> getWhiteListByActivityId(int activityId) {
        List<WhiteList> whiteLists = whiteListMapper.selectByActivityId(activityId);
        if (null == whiteLists || whiteLists.isEmpty()) {
            return new ArrayList<WhiteList>();
        }
        return whiteLists;
    }

    @Override
    public String getPrize(List<Prize> prizes, List<WhiteList> whiteLists, int activityId, int fansId) {
        for (WhiteList whiteList : whiteLists) {
            if (whiteList.getActivityId().intValue() == activityId && whiteList.getFansId().intValue() == fansId) {
                return getPrizeName(prizes, whiteList.getPrizeCode());
            }
        }
        return "";
    }

    @Override
    public WhiteList getWhiteListByActivityAndFans(int activityId, int fansId) {
        Map<String, Object> params = new HashMap<String, Object>();
        params.put("activityId", activityId);
        params.put("fansId", fansId);
        return whiteListMapper.selectByParams(params);
    }

    @Override
    public int deleteByActivityAndFans(int activityId, int fansId) {
        Map<String, Object> params = new HashMap<String, Object>();
        params.put("activityId", activityId);
        params.put("fansId", fansId);
        return whiteListMapper.deleteByParams(params);
    }

    private String getPrizeName(List<Prize> prizes, int prizeCode) {
        for (Prize prize : prizes) {
            if (prize.getCode().intValue() == prizeCode) {
                return prize.getName();
            }
        }
        return "";
    }
}
