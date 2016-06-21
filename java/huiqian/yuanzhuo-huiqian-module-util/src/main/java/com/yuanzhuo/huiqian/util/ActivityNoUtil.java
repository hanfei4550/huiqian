package com.yuanzhuo.huiqian.util;

/**
 * Created by hanfei on 16/5/12.
 */
public class ActivityNoUtil {
    public static String generateActivityNo() {
        long nowTime = System.currentTimeMillis();
        String activityNo = "";
        try {
            activityNo = MD5Util.md5Encode(String.valueOf(nowTime)).substring(0, 8);
        } catch (Exception e) {
            e.printStackTrace();
        }
        return activityNo;
    }

    public static void main(String[] args) throws Exception {
        System.out.println(generateActivityNo());
    }
}
