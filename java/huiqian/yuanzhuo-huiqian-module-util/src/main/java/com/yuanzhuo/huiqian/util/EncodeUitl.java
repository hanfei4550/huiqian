package com.yuanzhuo.huiqian.util;

import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;

/**
 * Created by hanfei on 16/5/16.
 */
public class EncodeUitl {
    public static String encode(String source) {
        try {
            return URLEncoder.encode(source, "UTF-8");
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
        }
        return "";
    }

    public static String doubleEncode(String url) {
        try {
            return URLEncoder.encode(URLEncoder.encode(url, "UTF-8"), "UTF-8");
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
        }
        return "";
    }

    public static void main(String[] args) {
        System.out.println(doubleEncode("https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxec230c866b34a22b&redirect_uri=http://www.hn-coffeecat.cn/huiqian/HuiqianService.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect"));
    }
}
