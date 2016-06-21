package com.yuanzhuo.huiqian.util;

import org.apache.commons.configuration.Configuration;
import org.apache.commons.configuration.ConfigurationException;
import org.apache.commons.configuration.PropertiesConfiguration;

/**
 * Created by hanfei on 16/5/19.
 */
public class PropertiesUtil {
    private static Configuration config;

    static {
        try {
            config = new PropertiesConfiguration("classpath:config.properties");
        } catch (ConfigurationException e) {
            e.printStackTrace();
        }
    }

    public static String getStringPropValue(String key) {
        return config.getString(key);
    }
}
