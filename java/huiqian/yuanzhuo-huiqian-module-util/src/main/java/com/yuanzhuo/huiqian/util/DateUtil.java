package com.yuanzhuo.huiqian.util;

import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;

/**
 * Created by hanfei on 16/5/12.
 */
public class DateUtil {
    private static DateFormat df;

    static {
        df = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
    }

    public static Date parse(String dateStr) {
        try {
            Date dateTime = df.parse(dateStr);
            return dateTime;
        } catch (ParseException e) {
            throw new RuntimeException("日期格式转换异常!");
        }
    }

    public static String dateToString(Date date) {
        return df.format(date);
    }

    /**
     * unix时间戳转换为dateFormat
     *
     * @param beginDate
     * @return
     */
    public static String timestampToDate(String beginDate) {
        SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        String sd = sdf.format(new Date(Long.parseLong(beginDate)));
        return sd;
    }

    /**
     * 自定义格式时间戳转换
     *
     * @param beginDate
     * @return
     */
    public static String timestampToDate(String beginDate, String format) {
        SimpleDateFormat sdf = new SimpleDateFormat(format);
        String sd = sdf.format(new Date(Long.parseLong(beginDate)));
        return sd;
    }

    /**
     * 将字符串转为时间戳
     *
     * @param user_time
     * @return
     */
    public static String dateToTimestamp(String user_time) {
        String re_time = null;
        SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm");
        Date d;
        try {
            d = sdf.parse(user_time);
            long l = d.getTime();
            String str = String.valueOf(l);
            re_time = str.substring(0, 10);
        } catch (ParseException e) {
            e.printStackTrace();
        }
        return re_time;
    }


    public static String dateToTimestamp(Date time) {
        long l = time.getTime();
        String str = String.valueOf(l);
        String re_time = str.substring(0, 10);
        return re_time;
    }
}
