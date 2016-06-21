package com.yuanzhuo.huiqian.util;

import org.apache.commons.beanutils.PropertyUtils;

import java.lang.reflect.InvocationTargetException;

/**
 * Created by hanfei on 16/5/12.
 */
public class BeanUtil {
    public static Object copyProperties(Object dest, Object src) {
        try {
            PropertyUtils.copyProperties(dest, src);
        } catch (IllegalAccessException e) {
            e.printStackTrace();
        } catch (InvocationTargetException e) {
            e.printStackTrace();
        } catch (NoSuchMethodException e) {
            e.printStackTrace();
        }
        return dest;
    }
}
