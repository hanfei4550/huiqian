package com.yuanzhuo.huiqian.consumer;

import com.yuanzhuo.huiqian.model.User;
import com.yuanzhuo.huiqian.provider.UserProvider;
import org.springframework.context.support.ClassPathXmlApplicationContext;

/**
 * Created by hanfei on 16/4/19.
 */
public class UserConsumer {
    public static void main(String[] args) throws Exception {
        ClassPathXmlApplicationContext context = new ClassPathXmlApplicationContext(
                new String[]{"huiqian-consumer.xml"});
        context.start();
        UserProvider demoService = (UserProvider) context
                .getBean("userProvider"); // 获取远程服务代理
        User user = demoService.getUserById(1); // 执行远程方法
        System.out.println(user.getWeixinName()); // 显示调用结果
    }
}
