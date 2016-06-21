package com.yuanzhuo.huiqian.util;

/**
 * Created by hanfei on 16/5/19.
 */

import com.alibaba.fastjson.JSON;
import com.alibaba.fastjson.JSONObject;
import org.apache.commons.httpclient.HttpClient;
import org.apache.commons.httpclient.HttpStatus;
import org.apache.commons.httpclient.methods.PostMethod;
import org.apache.commons.httpclient.methods.StringRequestEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.CloseableHttpClient;
import org.apache.http.impl.client.HttpClients;
import org.apache.http.util.EntityUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import java.io.BufferedInputStream;
import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.net.URLDecoder;
import java.net.URLEncoder;

public class HttpRequestUtil {
    private static Logger logger = LoggerFactory.getLogger(HttpRequestUtil.class);    //日志记录

    /**
     * httpPost
     *
     * @param url       路径
     * @param jsonParam 参数
     * @return
     */
    public static JSONObject httpPost(String url, JSONObject jsonParam) {
        return httpPost(url, jsonParam, false);
    }

    /**
     * post请求
     *
     * @param url            url地址
     * @param jsonParam      参数
     * @param noNeedResponse 不需要返回结果
     * @return
     */
    public static JSONObject httpPost(String url, JSONObject jsonParam, boolean noNeedResponse) {
        //post请求返回结果
        CloseableHttpClient httpClient = HttpClients.createDefault();
        JSONObject jsonResult = null;
        HttpPost method = new HttpPost(url);
        try {
            if (null != jsonParam) {
                //解决中文乱码问题
                StringEntity entity = new StringEntity(jsonParam.toString(), "utf-8");
                entity.setContentEncoding("UTF-8");
                entity.setContentType("application/json");
                method.setEntity(entity);
            }
            HttpResponse result = httpClient.execute(method);
            url = URLDecoder.decode(url, "UTF-8");
            /**请求发送成功，并得到响应**/
            if (result.getStatusLine().getStatusCode() == 200) {
                String str = "";
                try {
                    /**读取服务器返回过来的json字符串数据**/
                    str = EntityUtils.toString(result.getEntity());
                    if (noNeedResponse) {
                        return null;
                    }
                    /**把json字符串转换成json对象**/
                    jsonResult = JSONObject.parseObject(str);
                } catch (Exception e) {
                    logger.error("post请求提交失败:" + url, e);
                }
            }
        } catch (IOException e) {
            logger.error("post请求提交失败:" + url, e);
        }
        return jsonResult;
    }


    /**
     * 发送get请求
     *
     * @param url 路径
     * @return
     */
    public static JSONObject httpGet(String url) {
        //get请求返回结果
        JSONObject jsonResult = null;
        try {
            CloseableHttpClient client = HttpClients.createDefault();
            //发送get请求
            HttpGet request = new HttpGet(url);
            HttpResponse response = client.execute(request);

            /**请求发送成功，并得到响应**/
            if (response.getStatusLine().getStatusCode() == HttpStatus.SC_OK) {
                /**读取服务器返回过来的json字符串数据**/
                String strResult = EntityUtils.toString(response.getEntity());
                /**把json字符串转换成json对象**/
                jsonResult = JSONObject.parseObject(strResult);
                url = URLDecoder.decode(url, "UTF-8");
            } else {
                logger.error("get请求提交失败:" + url);
            }
        } catch (IOException e) {
            logger.error("get请求提交失败:" + url, e);
        }
        return jsonResult;
    }

    /**
     * 发送xml数据请求到server端
     *
     * @param url        xml请求数据地址
     * @param xmlContent 发送的xml数据流
     * @return null发送失败，否则返回响应内容
     */
    public static String postXml(String url, String xmlContent) {
        logger.info("parameters:" + xmlContent);
        //创建httpclient工具对象
        HttpClient client = new HttpClient();
        //创建post请求方法
        PostMethod myPost = new PostMethod(url);
        //设置请求超时时间
        String responseString = null;
        try {
            //设置请求头部类型
            myPost.setRequestHeader("Content-Type", "text/xml");
            myPost.setRequestHeader("charset", "utf-8");

            myPost.setRequestEntity(new StringRequestEntity(xmlContent, "text/xml", "utf-8"));
            int statusCode = client.executeMethod(myPost);
            if (statusCode == HttpStatus.SC_OK) {
                BufferedInputStream bis = new BufferedInputStream(myPost.getResponseBodyAsStream());
                byte[] bytes = new byte[1024];
                ByteArrayOutputStream bos = new ByteArrayOutputStream();
                int count = 0;
                while ((count = bis.read(bytes)) != -1) {
                    bos.write(bytes, 0, count);
                }
                byte[] strByte = bos.toByteArray();
                responseString = new String(strByte, 0, strByte.length, "utf-8");
                bos.close();
                bis.close();
            }
        } catch (Exception e) {
            logger.info("调用接口状态：" + e.getMessage());
        } finally {
            myPost.releaseConnection();
        }
        return responseString;
    }

    /**
     * 发送json数据请求到server端
     *
     * @param url         xml请求数据地址
     * @param jsonContent 发送的json数据流
     * @return null发送失败，否则返回响应内容
     */
    public static String postJson(String url, String jsonContent) {
        //创建httpclient工具对象
        HttpClient httpClient = new HttpClient();
        //创建post请求方法
        PostMethod method = new PostMethod(url);

        String body = null;
        logger.info("parameters:" + jsonContent);
        String responseString = null;
        if (method != null & jsonContent != null
                && !"".equals(jsonContent.trim())) {
            try {

                // 建立一个NameValuePair数组，用于存储欲传送的参数
                method.setRequestHeader("Content-Type", "application/json; charset=utf-8");
                method.setRequestEntity(new StringRequestEntity(jsonContent, "application/json", "UTF-8"));
                int statusCode = httpClient.executeMethod(method);
                if (statusCode == HttpStatus.SC_OK) {
                    BufferedInputStream bis = new BufferedInputStream(method.getResponseBodyAsStream());
                    byte[] bytes = new byte[1024];
                    ByteArrayOutputStream bos = new ByteArrayOutputStream();
                    int count = 0;
                    while ((count = bis.read(bytes)) != -1) {
                        bos.write(bytes, 0, count);
                    }
                    byte[] strByte = bos.toByteArray();
                    responseString = new String(strByte, 0, strByte.length, "utf-8");
                    bos.close();
                    bis.close();
                }
            } catch (IOException e) {
                logger.info("调用接口状态：" + e.getMessage());
            } finally {
                method.releaseConnection();
            }
        }
        return responseString;
    }

    public static void main(String[] args) throws UnsupportedEncodingException {
        String url = URLEncoder.encode("https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxec230c866b34a22b&redirect_uri=http://www.hn-coffeecat.cn/huiqian/HuiqianService.php%3Factivityno=c62e072e&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect", "UTF-8");
        JSONObject result = httpGet("http://localhost:63343/huiqian/baidu_shorturl_test.php?url=" + url);
        System.out.println(JSON.toJSONString(result));
    }
}
