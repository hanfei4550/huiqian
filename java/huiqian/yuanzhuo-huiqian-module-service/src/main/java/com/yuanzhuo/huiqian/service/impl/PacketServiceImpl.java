package com.yuanzhuo.huiqian.service.impl;

import com.alibaba.fastjson.JSON;
import com.alibaba.fastjson.JSONArray;
import com.alibaba.fastjson.JSONObject;
import com.yuanzhuo.huiqian.core.BusinessException;
import com.yuanzhuo.huiqian.core.HuiqianErrorCode;
import com.yuanzhuo.huiqian.dao.PacketMapper;
import com.yuanzhuo.huiqian.model.Activity;
import com.yuanzhuo.huiqian.model.Commercial;
import com.yuanzhuo.huiqian.model.Packet;
import com.yuanzhuo.huiqian.model.PacketActivityParam;
import com.yuanzhuo.huiqian.service.ActivityService;
import com.yuanzhuo.huiqian.service.CommercialService;
import com.yuanzhuo.huiqian.service.PacketService;
import com.yuanzhuo.huiqian.util.BillNoUtil;
import com.yuanzhuo.huiqian.util.DateUtil;
import com.yuanzhuo.huiqian.util.WXPacketUtil;
import com.yuanzhuo.huiqian.util.WXUtil;
import org.apache.commons.lang.StringUtils;
import org.dom4j.*;
import org.dom4j.io.SAXReader;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.*;

/**
 * 红包服务实现
 * Created by hanfei on 16/6/14.
 */
@Service("packetService")
public class PacketServiceImpl implements PacketService {
    private static final Logger LOGGER = LoggerFactory.getLogger(PacketServiceImpl.class);

    @Autowired
    private CommercialService commercialService;

    @Autowired
    private ActivityService activityService;

    @Autowired
    private PacketMapper packetMapper;

    @Override
    public List<Packet> getPacketsByCommercialId(Integer commercialId) throws BusinessException {
        if (null == commercialId) {
            throw new BusinessException(HuiqianErrorCode.HUIQIAN_USERCENTER_COMMERCIALID_NULL);
        }
        return packetMapper.selectByRelationId(commercialId);
    }

    @Override
    public int insert(Packet packet) throws BusinessException {
        return packetMapper.insert(packet);
    }


    @Override
    public List<Packet> createPacket(Integer userId, Integer activityId) throws BusinessException {
        List<Packet> packets = new ArrayList<Packet>();
        //1.根据活动id查询活动信息
        Activity activity = activityService.getActivityById(activityId);
        String packetConfigStr = activity.getPacketConfig();
        JSONArray packetConfig = JSON.parseArray(packetConfigStr);

        //2.根据用户id查询商户信息
        Commercial commercial = commercialService.getCommercialByUserId(userId);

        SAXReader sr = new SAXReader();
        //3.构造红包接口参数
        for (Object o : packetConfig) {
            JSONObject packetJson = (JSONObject) o;
            int amount = packetJson.getIntValue("amount");
            int num = packetJson.getIntValue("num");
            for (int i = 0; i < num; i++) {
                Map<String, Object> params = new HashMap<String, Object>();
                params.put("mch_id", commercial.getMchId());
                params.put("wxappid", commercial.getWxAppId());
                params.put("send_name", commercial.getMchName());
                params.put("auth_mchid", Packet.authmchid);
                params.put("auth_appid", Packet.authAppId);
                params.put("total_amount", amount);
                params.put("total_num", "1");
                params.put("wishing", "恭喜发财");
                params.put("act_name", "红包");
                params.put("remark", "红包");
                params.put("hb_type", "NORMAL");
                params.put("amt_type", "ALL_RAND");
                params.put("risk_cntl", "NORMAL");
                params.put("nonce_str", commercial.getNonceStr());
                params.put("secret", commercial.getSecret());
                String billNo = BillNoUtil.generateBillNo(commercial.getMchId());
                params.put("mch_billno", billNo);
                String result = WXPacketUtil.hbpreorder(params);
                if (StringUtils.isBlank(result)) {
                    continue;
                }
                try {
                    Document doc = DocumentHelper.parseText(result);
                    Element root = doc.getRootElement();
                    Node returnCode = root.selectSingleNode("return_code");
                    String returnCodeContent = returnCode.getStringValue();
                    Node resultCode = root.selectSingleNode("result_code");
                    String resultCodeContent = resultCode.getStringValue();
                    if ("SUCCESS".equalsIgnoreCase(returnCodeContent) && "SUCCESS".equalsIgnoreCase(resultCodeContent)) {
                        Node spTicket = root.selectSingleNode("sp_ticket");
                        Packet packet = new Packet();
                        packet.setBillNo(String.valueOf(params.get("mch_billno")));
                        packet.setActName(String.valueOf(params.get("act_name")));
                        packet.setCommercialId(commercial.getId());
                        packet.setCreateTime(new Date());
                        packet.setHbType(String.valueOf(params.get("hb_type")));
                        packet.setPacket(spTicket.getStringValue());
                        packet.setRemark(String.valueOf(params.get("remark")));
                        packet.setRiskCntl(String.valueOf(params.get("risk_cntl")));
                        packet.setTotalAmount(amount);
                        packet.setTotalNum(1);
                        packet.setWishing(String.valueOf(params.get("wishing")));
                        insert(packet);
                        packets.add(packet);
                    }
                    Thread.sleep(500);
                } catch (DocumentException e) {
                    LOGGER.error("活动:{}解析红包:{}创建接口返回结果失败:{}", activityId, amount, e.getMessage());
                } catch (Exception e) {
                    LOGGER.error("活动:{}解析红包:{}创建接口返回结果失败:{}", activityId, amount, e.getMessage());
                }
            }
        }
        return packets;
    }

    @Override
    public String createPacketActivity(String token, PacketActivityParam param) throws BusinessException {
        Map<String, String> params = new HashMap<String, String>();
        params.put("access_token", token);
        params.put("use_template", "1");
        params.put("logo_url", param.getLogoUrl());
        JSONObject body = new JSONObject();
        body.put("title", param.getTitle());
        body.put("desc", param.getDesc());
        body.put("onoff", param.getOnoff());
        body.put("begin_time", DateUtil.dateToTimestamp(param.getStartTime()));
        body.put("expire_time", DateUtil.dateToTimestamp(param.getEndTime()));
        body.put("sponsor_appid", param.getSponsorAppid());
        body.put("total", param.getTotal());
        body.put("jump_url", param.getJumpUrl());
        body.put("key", param.getKey());
        params.put("body", body.toJSONString());
        String resultStr = WXUtil.applyLotteryInfo(params);
        JSONObject result = JSONObject.parseObject(resultStr);
        int errcode = result.getIntValue("errcode");
        if (errcode == 0) {
            String lotteryId = result.getString("lottery_id");
            return lotteryId;
        }
        return "";
    }

    @Override
    public void importPacket(String token, String lotteryId, Integer userId) throws BusinessException {
        Commercial commercial = commercialService.getCommercialByUserId(userId);
        Integer commercialId = commercial.getId();
        List<Packet> packets = packetMapper.selectByRelationId(commercialId);
        //分批处理
        if (null != packets && packets.size() > 0) {
            int pointsDataLimit = 100;//限制条数
            Integer size = packets.size();
            //判断是否有必要分批
            if (pointsDataLimit < size) {
                int part = size / pointsDataLimit;//分批数
                LOGGER.info("共有 ： " + size + "条，！" + " 分为 ：" + part + "批");
                for (int i = 0; i < part; i++) {
                    //100条
                    List<Packet> listPage = packets.subList(0, pointsDataLimit);

                    partImportPacket(token, lotteryId, commercial, listPage);
                    //剔除
                    packets.subList(0, pointsDataLimit).clear();
                }
                if (!packets.isEmpty()) {
                    partImportPacket(token, lotteryId, commercial, packets);//表示最后剩下的数据
                }
            } else {
                partImportPacket(token, lotteryId, commercial, packets);
            }
        } else {
            LOGGER.info("没有数据!!!");
        }
    }

    /**
     * 分批导入红包 100个红包导入一次
     *
     * @param token     微信token
     * @param lotteryId 红包活动id
     * @param packets   红包总数量
     */
    private void partImportPacket(String token, String lotteryId, Commercial commercial, List<Packet> packets) throws BusinessException {
        Map<String, String> params = new HashMap<String, String>();
        params.put("access_token", token);
        JSONObject body = new JSONObject();
        body.put("lottery_id", lotteryId);
        body.put("mchid", commercial.getMchId());
        body.put("sponsor_appid", commercial.getWxAppId());
        JSONArray tickets = new JSONArray();
        for (Packet packet : packets) {
            JSONObject ticket = new JSONObject();
            ticket.put("ticket", packet.getPacket());
            tickets.add(ticket);
        }
        body.put("prize_info_list", tickets);
        params.put("body", body.toJSONString());
        String result = WXUtil.setPrizeBucket(params);
        LOGGER.info("导入红包结果:" + result);
    }
}
