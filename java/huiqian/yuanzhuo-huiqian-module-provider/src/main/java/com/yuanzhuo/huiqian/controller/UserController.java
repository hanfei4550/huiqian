package com.yuanzhuo.huiqian.controller;

import com.yuanzhuo.huiqian.model.User;
import com.yuanzhuo.huiqian.service.UserService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.ModelMap;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;

/**
 * Created by hanfei on 16/4/19.
 */
@Controller
@RequestMapping("/user")
public class UserController {
    @Autowired
    private UserService userService;

    @RequestMapping("/showInfo/{userId}")
    public String showUserInfo(ModelMap modelMap, @PathVariable int userId) {
        User userInfo = userService.getUserById(userId);
        modelMap.addAttribute("userInfo", userInfo);
        return "/user/showInfo";
    }

}
