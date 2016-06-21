package com.yuanzhuo.huiqian.service;

import com.alibaba.fastjson.JSON;
import com.yuanzhuo.huiqian.model.Commercial;
import com.yuanzhuo.huiqian.model.User;
import com.yuanzhuo.huiqian.util.MD5Util;
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
public class TestCommercialService {

    private static final Logger LOGGER = LoggerFactory
            .getLogger(TestCommercialService.class);

    @Autowired
    private CommercialService commercialService;


    @Test
    public void testGetCommercialByUserId() {
        Commercial commercial = commercialService.getCommercialByUserId(15);
        LOGGER.info("商户信息:{}", JSON.toJSONString(commercial));
    }

    @Test
    public void testInsert() {
        Commercial commercial = new Commercial();
        commercial.setMchId(1352683102);
        commercial.setMchName("赛法特");
        commercial.setWxAppId("wxc2ac43765ab8cb59");
        commercial.setNonceStr(MD5Util.md5Encode("1352683102"));
        commercial.setUserId(16);
        commercial.setSecret(MD5Util.md5Encode("yzqs1605"));
        int result = commercialService.insert(commercial);
        LOGGER.info("插入数量:{}", result);
    }
}
