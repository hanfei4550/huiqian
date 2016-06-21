package com.yuanzhuo.huiqian.util;

import org.apache.commons.lang3.RandomStringUtils;
import org.dom4j.*;
import org.dom4j.io.SAXReader;
import org.joda.time.DateTime;

import java.util.Date;

/**
 * Created by hanfei on 16/6/14.
 */
public class BillNoUtil {
    /**
     * 根据商户号随机生成当天的订单号
     *
     * @param mchId 商户号
     * @return 订单号
     */
    public static String generateBillNo(Integer mchId) {
        StringBuilder billNo = new StringBuilder(30);
        DateTime dttime = DateTime.now();
        int year = dttime.getYear();
        String monthStr = "";
        String dateStr = "";
        int month = dttime.getMonthOfYear();
        if (month < 10) {
            monthStr = "0" + month;
        } else {
            monthStr = "" + month;
        }
        int date = dttime.getDayOfMonth();
        if (date < 10) {
            dateStr = "0" + date;
        } else {
            dateStr = "" + date;
        }
        String randomNo = RandomStringUtils.randomNumeric(10);
        billNo.append(mchId).append(year).append(monthStr).append(dateStr).append(randomNo);
        return billNo.toString();
    }

    public static void test(String result) {
        try {
            Document doc = DocumentHelper.parseText(result);
            Element root = doc.getRootElement();
            Node returnCode = root.selectSingleNode("return_code");
            String returnCodeContent = returnCode.getStringValue();
            Node resultCode = root.selectSingleNode("result_code");
            String resultCodeContent = resultCode.getStringValue();
        } catch (DocumentException e) {
            e.printStackTrace();
        }
    }

    public static void main(String[] args) {
//        String billNo = generateBillNo(111);
//        System.out.println(billNo);
//        String result = "<xml>\n" +
//                "<return_code><![CDATA[SUCCESS]]></return_code>\n" +
//                "<return_msg><![CDATA[发放成功]]></return_msg>\n" +
//                "<result_code><![CDATA[SUCCESS]]></result_code>\n" +
//                "<mch_billno><![CDATA[1351709401201606130000000004]]></mch_billno>\n" +
//                "<mch_id>1351709401</mch_id>\n" +
//                "<wxappid><![CDATA[wx613472cd2a425abd]]></wxappid>\n" +
//                "<total_amount>101</total_amount>\n" +
//                "<sp_ticket><![CDATA[v1|+5IS5TGfitUrypGzyGUH4SarVyk7vsB5QYotNqVx10Kq6Oz3ZAaBcLNI5YKkDnlKYXxYPZiQzBAswYZXIUxrDUKe2s0TP6QdLrSioje39yKdCJzw882td77ugyDcJ8MwckCLnq+tYnwdO1l8X9pQ/w==]]></sp_ticket>\n" +
//                "<detail_id><![CDATA[0012703523201606130872639451]]></detail_id>\n" +
//                "<send_time><![CDATA[20160613104738]]></send_time>\n" +
//                "</xml>";
//        test(result);
        Date date = new Date();
        System.out.println(date.getTime());
    }
}
