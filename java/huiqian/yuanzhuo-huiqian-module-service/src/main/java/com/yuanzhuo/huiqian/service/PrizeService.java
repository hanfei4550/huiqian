package com.yuanzhuo.huiqian.service;

import com.yuanzhuo.huiqian.model.Prize;

import java.util.List;

/**
 * Created by hanfei on 16/4/19.
 */
public interface PrizeService {

    List<Prize> getPrizeByActivityId(int activityId);

    int savePrize(Prize prize);

    int deleteById(int id);

    void deleteByActivityId(int activityId);
}
