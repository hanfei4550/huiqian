package com.yuanzhuo.huiqian.service;

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
public class TestActivityWinningListService {

    private static final Logger LOGGER = LoggerFactory
            .getLogger(TestActivityWinningListService.class);

    @Autowired
    private ActivityWinningListService activityWinningListService;


    @Test
    public void testSaveActivityWinningList() {
        String winningList = "[{'activityId':1,'nick':'hanfei','prizeCode':1,'prizeName':'一等奖'},{'activityId':1,'nick':'zhangsan','prizeCode':2,'prizeName':'二等奖'}]";
        activityWinningListService.saveActivityWinningList(winningList);
    }

}
