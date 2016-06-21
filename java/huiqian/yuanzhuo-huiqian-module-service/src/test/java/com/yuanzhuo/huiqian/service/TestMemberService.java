package com.yuanzhuo.huiqian.service;

import com.alibaba.fastjson.JSON;
import com.yuanzhuo.huiqian.model.Member;
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
public class TestMemberService {

    private static final Logger LOGGER = LoggerFactory
            .getLogger(TestMemberService.class);

    @Autowired
    private MemberService memberService;

    @Test
    public void testGetMemberByNameAndPasswordAllMembers() throws Exception {
        Member member = memberService.getMemberByNameAndPassword("admin", "admin");
        LOGGER.info("用户信息:" + JSON.toJSONString(member));
    }

    @Test
    public void testGetAllMembers() throws Exception {
        List<Member> members = memberService.getAllMembers(1, 10);
        LOGGER.info("用户信息:" + JSON.toJSONString(members));
    }

    @Test
    public void testGetTotal() throws Exception {
        int count = memberService.getTotal(null);
        LOGGER.info("用户总数:" + count);
    }

}
