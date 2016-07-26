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

import java.util.Calendar;
import java.util.Date;
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

    @Test
    public void testRecoverActivityDataByActivityNoAndFile() {
        activityService.recoverActivityDataByActivityNoAndFile(27, 23, "/Users/hanfei/Documents/菁英时代_1.xls");
    }

    public static void main(String[] args) {
        Date start = new Date();

        Calendar end = Calendar.getInstance();
        end.set(Calendar.DATE, 28);

        System.out.println(start.after(end.getTime()));
    }

}
