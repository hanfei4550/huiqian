package com.yuanzhuo.huiqian.service;

import com.yuanzhuo.huiqian.model.User;

import java.util.List;

/**
 * Created by hanfei on 16/4/19.
 */
public interface UserService {

    User getUserById(Integer id);


    int insert(User user);
}
