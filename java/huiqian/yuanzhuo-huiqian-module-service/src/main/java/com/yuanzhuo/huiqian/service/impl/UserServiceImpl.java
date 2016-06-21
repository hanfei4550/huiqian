package com.yuanzhuo.huiqian.service.impl;

import com.yuanzhuo.huiqian.dao.UserMapper;
import com.yuanzhuo.huiqian.model.User;
import com.yuanzhuo.huiqian.service.UserService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;


/**
 * Created by hanfei on 16/4/19.
 */
@Service("userService")
public class UserServiceImpl implements UserService {
    @Autowired
    private UserMapper userMapper;

    @Override
    public User getUserById(Integer id) {
        return userMapper.selectByPrimaryKey(id);
    }

    @Override
    public int insert(User user) {
        int result = userMapper.insert(user);
        return result;
    }
}
