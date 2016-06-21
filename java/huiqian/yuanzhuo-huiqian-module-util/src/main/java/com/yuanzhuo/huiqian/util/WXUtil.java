package com.yuanzhuo.huiqian.util;

import com.alibaba.fastjson.JSONArray;
import com.alibaba.fastjson.JSONObject;
import org.apache.commons.lang.StringUtils;
import org.dom4j.Document;
import org.dom4j.DocumentHelper;
import org.dom4j.Element;

import java.util.*;

/**
 * 微信服务工具类
 */
public class WXUtil {
    public static List<String> sortParamsByAscii(List<String> paramNames) {
        Collections.sort(paramNames);
        return paramNames;
    }

    public static String generateSignStr(List<String> notEmptyParams, Map<String, Object> params) {
        StringBuilder sb = new StringBuilder(500);
        String separator = "";
        for (String paramName : notEmptyParams) {
            sb.append(separator);
            String paramValue = String.valueOf(params.get(paramName));
            sb.append(paramName).append("=").append(paramValue);
            separator = "&";
        }
        //拼接支付密钥
        String secret = String.valueOf(params.get("secret"));
//        sb.append("&key=ee7894de99588c88df2ad0f7ac6e7bec");
        sb.append("&key=" + secret);
        String sign = MD5Util.md5Encode(sb.toString()).toUpperCase();

        return sign;
    }

    public static String generateSign(Map<String, Object> params) {
        List<String> notEmptyParams = new ArrayList<String>();
        for (Map.Entry<String, Object> param : params.entrySet()) {
            String key = param.getKey();
            if ("secret".equalsIgnoreCase(key)) {
                continue;
            }
            String value = String.valueOf(param.getValue());
            if (StringUtils.isNotBlank(value)) {
                notEmptyParams.add(param.getKey());
            }
        }

        sortParamsByAscii(notEmptyParams);

        String sign = generateSignStr(notEmptyParams, params);

        return sign;
    }

    public static String generateParamXml(Map<String, Object> params) {
        Document document = DocumentHelper.createDocument();
        Element rootElement = document.addElement("xml");
        for (Map.Entry<String, Object> paramEntry : params.entrySet()) {
            Element param = rootElement.addElement(paramEntry.getKey());
            param.setText(String.valueOf(paramEntry.getValue()));
        }
        return document.asXML();
    }


    public static String getWXToken(String appId, String appSecret) {
        String url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" + appId + "&secret=" + appSecret;
        JSONObject result = HttpRequestUtil.httpGet(url);
        System.out.println(result.toJSONString());
        return result.getString("access_token");
    }

    /**
     * 调用创建红包活动接口
     *
     * @param params {
     *               "access_token":"",
     *               "use_template":"",
     *               "logo_url":"",
     *               "body":""
     *               }
     * @return 创建红包活动结果
     * {
     * "errcode":0,
     * "errmsg":"",
     * "lottery_id":"xxxxxxllllll",
     * "page_id":1,
     * }
     */
    public static String applyLotteryInfo(Map<String, String> params) {
        String requestUrl = "https://api.weixin.qq.com/shakearound/lottery/addlotteryinfo";
        String accessToken = params.get("access_token");
        requestUrl = requestUrl + "?access_token=" + accessToken;
        String useTemplate = params.get("use_template");
        requestUrl = requestUrl + "&use_template=" + useTemplate;
        if ("1" == useTemplate) {
            String logoUrl = params.get("logo_url");
            requestUrl = requestUrl + "&logo_url=" + logoUrl;
        }
        String body = params.get("body");
        String result = HttpRequestUtil.postJson(requestUrl, body);
        return result;
    }

    /**
     * 录入红包信息接口
     *
     * @param params {
     *               "access_token":"",
     *               "body":{
     *               "lottery_id":"",
     *               "mchid":"",
     *               "sponsor_appid":"",
     *               "prize_info_list":""
     *               "ticket":""
     *               }
     *               }
     * @return 录入红包信息结果
     * {
     * <p>
     * }
     */
    public static String setPrizeBucket(Map<String, String> params) {
        String accessToken = params.get("access_token");
        String requestUrl = "https://api.weixin.qq.com/shakearound/lottery/setprizebucket?access_token=" + accessToken;
        String body = params.get("body");
        String result = HttpRequestUtil.postJson(requestUrl, body);
        return result;
    }

    /**
     * 设置红包活动抽奖开关
     *
     * @param accessToken token调用
     * @param lotteryId   红包抽奖id
     * @param status      活动抽奖开关 0:关闭 1:开启
     * @return 红包活动抽奖结果{
     * "errcode":"",
     * "errmsg":""
     * }
     */
    public static JSONObject setLotterySwitch(String accessToken, String lotteryId, int status) {
        String requestUrl = "https://api.weixin.qq.com/shakearound/lottery/setlotteryswitch??access_token=" + accessToken + "&lottery_id=" + lotteryId + "&onoff=" + status;
        JSONObject result = HttpRequestUtil.httpGet(requestUrl);
        return result;
    }

    public static void main(String[] args) {
//        Map<String, String> params = new HashMap<String, String>();
//        params.put("mch_billno", "0010010404201411170000046545");
//        params.put("mch_id", "10000097");
//        params.put("wxappid", "wxcbda96de0b165486");
//        params.put("send_name", "send_name");
//        params.put("hb_type", "NORMAL");
//        params.put("auth_mchid", "10000098");
//        params.put("auth_appid", "wx7777777");
//        params.put("total_amount", "200");
//        params.put("amt_type", "ALL_RAND");
//        params.put("total_num", "3");
//        params.put("wishing", "恭喜发财");
//        params.put("act_name", "新年红包");
//        params.put("remark", "新年红包");
//        params.put("risk_cntl", "NORMAL");
//        params.put("nonce_str", "50780e0cca98c8c8e814883e5caa672e");
//
//        String sign = generateSign(params);
//        params.put("sign", sign);
//
//        String paramXml = generateParamXml(params);
//        System.out.println(paramXml);

        //1.获取token
//        getWXToken("wx613472cd2a425abd", "7c607d6e08247bd8a49d6d850703a059");

        //2.创建红包活动
//        Map<String, String> params = new HashMap<String, String>();
//        params.put("access_token", "s-9gjNOzBtowK13WFTzQvI47ydFWrugdP1327Q9hsM-YNErz5oi9bqCk3QI3A4K--DKdIidgzOeEBFGSlD1vyx-OIucjkwoLv8t2FRBKeuMdfi56aQJfVKBDn_J7uYM3ODCcAHAETS");
//        params.put("use_template", "1");
//        params.put("logo_url", "1.png");
//        JSONObject body = new JSONObject();
//        body.put("title", "红包");
//        body.put("desc", "红包");
//        body.put("onoff", 1);
//        body.put("begin_time", 1465785000);
//        body.put("expire_time", 1465871400);
//        body.put("sponsor_appid", "wx613472cd2a425abd");
//        body.put("total", 3);
//        body.put("jump_url", "http://www.huiqian.me");
//        body.put("key", "ee7894de99588c88df2ad0f7ac6e7bec");
//        params.put("body", body.toJSONString());
//        applyLotteryInfo(params);


        //3.录入红包信息
        Map<String, String> params = new HashMap<String, String>();
        params.put("access_token", "s-9gjNOzBtowK13WFTzQvI47ydFWrugdP1327Q9hsM-YNErz5oi9bqCk3QI3A4K--DKdIidgzOeEBFGSlD1vyx-OIucjkwoLv8t2FRBKeuMdfi56aQJfVKBDn_J7uYM3ODCcAHAETS");
        JSONObject body = new JSONObject();
        body.put("lottery_id", "2UYLQ2m_SbomZECvtkd9rA");
        body.put("mchid", "1351709401");
        body.put("sponsor_appid", "wx613472cd2a425abd");
        JSONArray tickets = new JSONArray();
        JSONObject ticket = new JSONObject();
        ticket.put("ticket", "v1|+5IS5TGfitUrypGzyGUH4Z67Q85+GZbUH9jmbmTify+q6Oz3ZAaBcLNI5YKkDnlKYXxYPZiQzBAswYZXIUxrDUKe2s0TP6QdLrSioje39yLVzuc4WyOJaNSnW/IjhSEjTGqCB5iSYPnZKLOgqBaq3g==");
        tickets.add(ticket);
        JSONObject ticket1 = new JSONObject();
        ticket1.put("ticket", "v1|+5IS5TGfitUrypGzyGUH4SarVyk7vsB5QYotNqVx10Kq6Oz3ZAaBcLNI5YKkDnlKYXxYPZiQzBAswYZXIUxrDUKe2s0TP6QdLrSioje39yKdCJzw882td77ugyDcJ8MwckCLnq+tYnwdO1l8X9pQ/w==");
        tickets.add(ticket1);
        JSONObject ticket2 = new JSONObject();
        ticket2.put("ticket", "v1|+5IS5TGfitUrypGzyGUH4aPvU9sB4kop8x6XqMTe9N+q6Oz3ZAaBcLNI5YKkDnlKYXxYPZiQzBAswYZXIUxrDV1bsFws1+gpVTMvFSsq7M7q05rSA2uUGSP3FYvftXO5ZaeZKsaMC9xZZ2er+aenAg==");
        tickets.add(ticket2);
        body.put("prize_info_list", tickets);
        params.put("body", body.toJSONString());
        setPrizeBucket(params);

//        System.out.println(body.toJSONString());
//        params.put("body", "{\"mchid\":\"1351709401\",\"prize_info_list\":[{\"ticket\":\"v1|+5IS5TGfitUrypGzyGUH4YvWdUnd2kPAIaES4xznsXWq6Oz3ZAaBcLNI5YKkDnlKYXxYPZiQzBAswYZXIUxrDVfm95rxAfirf4JCPgOi0YpcgIIOpqPdRcoIQGU+4SCmoDfKm4lxUbaz4cq/B/ZRSA==\"}],\"lottery_id\":\"iBbgp00th3n5K_A2SiY_OA\",\"sponsor_appid\":\"wx613472cd2a425abd\"}");
    }
}
