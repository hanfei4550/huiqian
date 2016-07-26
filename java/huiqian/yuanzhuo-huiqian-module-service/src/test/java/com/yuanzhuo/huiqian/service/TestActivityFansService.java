package com.yuanzhuo.huiqian.service;

import com.yuanzhuo.huiqian.model.ActivityFans;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.test.context.ContextConfiguration;
import org.springframework.test.context.junit4.SpringJUnit4ClassRunner;

/**
 * Created by hanfei on 16/4/19.
 */
@RunWith(SpringJUnit4ClassRunner.class)
@ContextConfiguration(locations = {"classpath:spring.xml",
        "classpath:spring-mybatis.xml"})
public class TestActivityFansService {

    private static final Logger LOGGER = LoggerFactory
            .getLogger(TestActivityFansService.class);

    @Autowired
    private ActivityFansService activityFansService;


    @Test
    public void testGetActivityFansByUserInfo() {
        ActivityFans activityFans = activityFansService.getActivityFansByUserInfo("1", "韩飞", "18684746456");
        System.out.println(activityFans);
    }
}
