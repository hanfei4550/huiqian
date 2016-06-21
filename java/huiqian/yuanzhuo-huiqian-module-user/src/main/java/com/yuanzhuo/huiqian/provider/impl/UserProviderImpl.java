package com.yuanzhuo.huiqian.provider.impl;

import com.yuanzhuo.huiqian.dao.UserMapper;
import com.yuanzhuo.huiqian.model.User;
import com.yuanzhuo.huiqian.provider.UserProvider;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

/**
 * Created by hanfei on 16/4/19.
 */
@Service
public class UserProviderImpl implements UserProvider {
    @Autowired
    private UserMapper userMapper;

    @Override
    public User getUserById(Integer id) {
        return userMapper.selectByPrimaryKey(id);
    }
}
