package com.yuanzhuo.huiqian.service;

import com.alibaba.fastjson.JSON;
import com.alibaba.fastjson.JSONObject;
import com.yuanzhuo.huiqian.model.Commercial;
import com.yuanzhuo.huiqian.model.Packet;
import com.yuanzhuo.huiqian.model.PacketActivityParam;
import com.yuanzhuo.huiqian.util.HttpRequestUtil;
import com.yuanzhuo.huiqian.util.MD5Util;
import com.yuanzhuo.huiqian.util.PropertiesUtil;
import com.yuanzhuo.huiqian.util.WXUtil;
import org.joda.time.DateTimeUtils;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.test.context.ContextConfiguration;
import org.springframework.test.context.junit4.SpringJUnit4ClassRunner;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.List;

/**
 * Created by hanfei on 16/4/19.
 */
@RunWith(SpringJUnit4ClassRunner.class)
@ContextConfiguration(locations = {"classpath:spring.xml",
        "classpath:spring-mybatis.xml"})
public class TestPacketService {

    private static final Logger LOGGER = LoggerFactory
            .getLogger(TestPacketService.class);

    @Autowired
    private PacketService packetService;


    @Test
    public void testGetCommercialByUserId() {
        List<Packet> packetList = packetService.getPacketsByCommercialId(1);
        LOGGER.info("红包信息:{}", JSON.toJSONString(packetList));
    }

    @Test
    public void testCreatePacket() {
        List<Packet> packets = packetService.createPacket(16, 20);
        for (Packet packet : packets) {
            System.out.println("==================" + packet);
        }
    }

    @Test
    public void testGetWXToken() {
        //1.会签token
//        String token = WXUtil.getWXToken("wx613472cd2a425abd", "7c607d6e08247bd8a49d6d850703a059");
        //2.塞法特token
        String token = WXUtil.getWXToken("wxc2ac43765ab8cb59", "955699e0ee98b95f113881deb4a16342");
        System.out.println("微信的token=================" + token);
    }

    @Test
    public void testCreatePacketActivity() {
        //1.获取token
//        String env = PropertiesUtil.getStringPropValue("env");
//        String appId = PropertiesUtil.getStringPropValue(env + ".appId");
//        String appSecret = PropertiesUtil.getStringPropValue(env + ".appSecret");
//        String token = WXUtil.getWXToken(appId, appSecret);
//        String token = WXUtil.getWXToken("wx613472cd2a425abd", "7c607d6e08247bd8a49d6d850703a059");
//        System.out.println("微信的token=================" + token);

        //2.创建红包活动
        Calendar startTime = Calendar.getInstance();
        Calendar endTime = Calendar.getInstance();
        endTime.set(Calendar.DATE, 25);
        PacketActivityParam param = new PacketActivityParam();
        param.setDesc("红包");
        param.setJumpUrl("http://www.zfbcs.com/");
        param.setKey("20fc54b237c02a09105df92a5fe4007d");
        param.setEndTime(endTime.getTime());
        param.setMchId(1352683102);
        param.setOnoff(1);
        param.setStartTime(startTime.getTime());
        param.setTitle("红包");
        param.setSponsorAppid("wxc2ac43765ab8cb59");
        param.setTotal(520);
        param.setLogoUrl("http://www.huiqian.me/images/hongbao.png");
        String lotteryId = packetService.createPacketActivity("HsOn5ZEqTMtAT808QTAzOVzLjlqZqVkHykO4FUY9-cVDOC215M6ET2IojTtL5cMONid_zK-0eixmUuFoXo5RWwYYXv0WbWIsGBHStEvq5yP2s5RMcrSTB2Ki0GGGx1mBBXDaAJAMIO", param);
        System.out.println("红包活动ID=========" + lotteryId);
    }

    @Test
    public void testImportPackage() {
        packetService.importPacket("HsOn5ZEqTMtAT808QTAzOVzLjlqZqVkHykO4FUY9-cVDOC215M6ET2IojTtL5cMONid_zK-0eixmUuFoXo5RWwYYXv0WbWIsGBHStEvq5yP2s5RMcrSTB2Ki0GGGx1mBBXDaAJAMIO", "_PuWn2FXigHY_CyWkKKFcw", 16);
    }

    @Test
    public void testInsert() {
        Packet packet = new Packet();
        packet.setBillNo("1351709401201606140000000002");
        packet.setActName("红包活动");
        packet.setCommercialId(1);
        packet.setCreateTime(new Date());
        packet.setHbType("NORMAL");
        packet.setPacket("v1|+5IS5TGfitUrypGzyGUH4QL5tlBR/MzUiUTrhhwyqf+q6Oz3ZAaBcLNI5YKkDnlKYXxYPZiQzBAswYZXIUxrDT7V0imoEMQ9bVtKF41x/jX1AdjAHoJDmDPkWGQM2y3vaCdivub6Y1LQz9Kt+F7gHw==");
        packet.setRemark("红包活动");
        packet.setRiskCntl("NORMAL");
        packet.setTotalAmount(102);
        packet.setTotalNum(1);
        packet.setWishing("恭喜发财");
        int result = packetService.insert(packet);
        LOGGER.info("插入数量:{}", result);
    }

    public static void main(String[] args) {
        //4.控制活动开关
        String requestUrl = "https://api.weixin.qq.com/shakearound/lottery/setlotteryswitch?access_token=oLZd9qwEX-eiDOcxN1URHLIpDcHa3kzZXqV3xQ5aI_1kEbGL1Owhfa0gcBXnn3b4R4iBrM4pCA8DubxXtaTaJV4-EBLauL1k1VAIhzA07SUC_C7f0CrEXX66QRAOJiLcJQTcAJAXEH&lottery_id=jBGCrf2f7uKklfUy-ArdjA&onoff=1";
        JSONObject result = HttpRequestUtil.httpGet(requestUrl);
        System.out.println(result);
    }
}
