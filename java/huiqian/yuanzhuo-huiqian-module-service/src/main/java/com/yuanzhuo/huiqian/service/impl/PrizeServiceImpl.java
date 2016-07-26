package com.yuanzhuo.huiqian.service.impl;

import com.yuanzhuo.huiqian.dao.PrizeMapper;
import com.yuanzhuo.huiqian.model.Prize;
import com.yuanzhuo.huiqian.service.PrizeService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

/**
 * Created by hanfei on 16/5/26.
 */
@Service("prizeService")
public class PrizeServiceImpl implements PrizeService {

    @Autowired
    private PrizeMapper prizeMapper;

    @Override
    public List<Prize> getPrizeByActivityId(int activityId) {
        return prizeMapper.selectByActivityId(activityId);
    }

    @Override
    public int savePrize(Prize prize) {
        return prizeMapper.insertSelective(prize);
    }

    @Override
    public int deleteById(int id) {
        return prizeMapper.deleteByPrimaryKey(id);
    }

    @Override
    public void deleteByActivityId(int activityId) {
        prizeMapper.deleteByRelationId(activityId);
    }
}
