package com.yuanzhuo.huiqian.util;

import org.apache.http.HttpEntity;
import org.apache.http.client.methods.CloseableHttpResponse;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.conn.ssl.SSLConnectionSocketFactory;
import org.apache.http.conn.ssl.SSLContexts;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.CloseableHttpClient;
import org.apache.http.impl.client.HttpClients;
import org.apache.http.util.EntityUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import javax.net.ssl.SSLContext;
import java.io.File;
import java.io.FileInputStream;
import java.security.KeyStore;
import java.security.KeyStoreException;
import java.util.HashMap;
import java.util.Map;

/**
 * Created by hanfei on 16/6/9.
 */
public class WXPacketUtil {
    private static final Logger LOGGER = LoggerFactory.getLogger(WXPacketUtil.class);

    /**
     * post调用微信支付接口
     *
     * @param mchId 商户id
     * @param url   请求url
     * @param data  请求数据
     * @return 红包预下单接口返回数据
     */
    public static String postWxPay(String mchId, String url, String data) {
        try {
            KeyStore keyStore = KeyStore.getInstance("PKCS12");
            //1.会签证书
//          FileInputStream instream = new FileInputStream(new File("/Users/hanfei/Downloads/cert/apiclient_cert.p12"));
            //2.塞法特证书
            FileInputStream instream = new FileInputStream(new File("/Users/hanfei/huiqian-common/cert/apiclient_cert.p12"));
            keyStore.load(instream, mchId.toCharArray());
            instream.close();
            SSLContext sslcontext = SSLContexts.custom().loadKeyMaterial(keyStore, mchId.toCharArray()).build();
            SSLConnectionSocketFactory sslsf = new SSLConnectionSocketFactory(sslcontext, new String[]{"TLSv1"}, null,
                    SSLConnectionSocketFactory.BROWSER_COMPATIBLE_HOSTNAME_VERIFIER);
            CloseableHttpClient httpclient = HttpClients.custom().setSSLSocketFactory(sslsf).build();
            HttpPost httpost = new HttpPost(url);
            httpost.addHeader("Connection", "keep-alive");
            httpost.addHeader("Accept", "*/*");
            httpost.addHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
            httpost.addHeader("Host", "api.mch.weixin.qq.com");
            httpost.addHeader("X-Requested-With", "XMLHttpRequest");
            httpost.addHeader("Cache-Control", "max-age=0");
            httpost.addHeader("User-Agent", "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0) ");
            httpost.setEntity(new StringEntity(data, "UTF-8"));
            CloseableHttpResponse response = httpclient.execute(httpost);
            HttpEntity entity = response.getEntity();
            String jsonStr = EntityUtils.toString(response.getEntity(), "UTF-8");
            EntityUtils.consume(entity);
            return jsonStr;
        } catch (KeyStoreException e) {
            LOGGER.error("商户:{}创建红包失败:{}", mchId, e.getMessage());
        } catch (Exception e) {
            LOGGER.error("商户:{}创建红包失败:{}", mchId, e.getMessage());
        }
        return "";
    }

    /**
     * 红包预下单
     *
     * @param params 红包参数
     * @return 红包预下单接口返回数据
     */
    public static String hbpreorder(Map<String, Object> params) {
        String mchId = String.valueOf(params.get("mch_id"));
        String sign = WXUtil.generateSign(params);
        params.put("sign", sign);
        String paramXml = WXUtil.generateParamXml(params);
        String url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/hbpreorder";
        return postWxPay(mchId, url, paramXml);
    }


    /**
     * 查询红包
     *
     * @param params 查询红包参数
     * @return 红包查询接口返回数据
     */
    public static String gethbinfo(Map<String, Object> params) {
        String mchId = String.valueOf(params.get("mch_id"));
        String url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/gethbinfo";
        String sign = WXUtil.generateSign(params);
        params.put("sign", sign);
        String paramXml = WXUtil.generateParamXml(params);
        return postWxPay(mchId, url, paramXml);
    }


    public static void main(String[] args) {
        //1.红包预下单工作流程
        Map<String, Object> params = new HashMap<String, Object>();
        params.put("mch_billno", "1351709401201606130000000005");
        params.put("mch_id", "1351709401");
        params.put("wxappid", "wx613472cd2a425abd");
        params.put("send_name", "会签");
        params.put("hb_type", "NORMAL");
        params.put("auth_mchid", "1000052601");
        params.put("auth_appid", "wxbf42bd79c4391863");
        params.put("total_amount", "101");
        params.put("amt_type", "ALL_RAND");
        params.put("total_num", "1");
        params.put("wishing", "恭喜发财");
        params.put("act_name", "红包");
        params.put("remark", "红包");
        params.put("risk_cntl", "NORMAL");
        params.put("nonce_str", "50780e0cca98c8c8e814883e5caa672e");
        hbpreorder(params);


        //2.查询红包
//        Map<String, String> params = new HashMap<String, String>();
//        params.put("nonce_str", "50780e0cca98c8c8e814883e5caa672e");
//        params.put("mch_billno", "1351709401201606090000000002");
//        params.put("mch_id", "1351709401");
//        params.put("appid", "wx613472cd2a425abd");
//        params.put("bill_type", "MCHT");
//        gethbinfo(params);
    }
}
