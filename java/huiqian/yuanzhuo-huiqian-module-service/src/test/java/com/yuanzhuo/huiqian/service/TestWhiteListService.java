package com.yuanzhuo.huiqian.service;

import com.yuanzhuo.huiqian.model.WhiteList;
import org.junit.Test;
import org.junit.runner.RunWith;
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
public class TestWhiteListService {

    @Autowired
    private WhiteListService whiteListService;


    @Test
    public void testSelectByActivityId() {
        List<WhiteList> whiteListList = whiteListService.getWhiteListByActivityId(6);
        for (WhiteList whiteList : whiteListList) {
            System.out.println("======================" + whiteList.getFans().getHeadPortraint());
        }
    }
}
