package com.yuanzhuo.huiqian.service;

import com.alibaba.fastjson.JSON;
import com.yuanzhuo.huiqian.model.Activity;
import com.yuanzhuo.huiqian.model.User;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.test.context.ContextConfiguration;
import org.springframework.test.context.junit4.SpringJUnit4ClassRunner;

import java.util.List;

/**
 * Created by hanfei on 16/4/19.
 */
@RunWith(SpringJUnit4ClassRunner.class)
@ContextConfiguration(locations = {"classpath:spring.xml",
        "classpath:spring-mybatis.xml"})
public class TestActivityService {

    private static final Logger LOGGER = LoggerFactory
            .getLogger(TestActivityService.class);

    @Autowired
    private ActivityService activityService;


    @Test
    public void testDeleteActivityDataByActivityNo() {
        activityService.deleteActivityDataByActivityNo("7306b7b7");
    }
}
