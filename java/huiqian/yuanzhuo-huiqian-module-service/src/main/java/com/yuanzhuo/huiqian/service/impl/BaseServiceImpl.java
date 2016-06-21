package com.yuanzhuo.huiqian.service.impl;

import com.github.miemiedev.mybatis.paginator.domain.PageBounds;
import org.apache.ibatis.session.SqlSession;
import org.apache.ibatis.session.SqlSessionFactory;
import org.mybatis.spring.SqlSessionFactoryBean;
import org.mybatis.spring.SqlSessionUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;

import java.util.List;

/**
 * Created by hanfei on 16/5/10.
 */
public class BaseServiceImpl {
    protected Logger logger = LoggerFactory.getLogger(this.getClass());

    @Autowired
    protected SqlSessionFactoryBean sqlSessionFactory;

    /**
     * 查询分页数据
     *
     * @param mapperClass
     * @param sqlId
     * @param sqlParameter
     * @param pageIndex
     * @param pageSize
     * @return
     * @throws Exception
     */
    protected List<?> getPageList(Class<?> mapperClass, String sqlId,
                                  Object sqlParameter, int pageIndex, int pageSize) throws Exception {
        SqlSession session = null;
        try {
            SqlSessionFactory sessionFactory = sqlSessionFactory.getObject();
            session = SqlSessionUtils.getSqlSession(sessionFactory);
            if (pageIndex <= 0) {
                pageIndex = 1;
            }
            if (pageSize <= 0) {
                pageSize = 1;
            }
            PageBounds pageBounds = new PageBounds(pageIndex, pageSize);
            return session.selectList(mapperClass.getName() + "." + sqlId,
                    sqlParameter, pageBounds);
        } finally {
            session.close();
        }

    }

    protected int getTotal(Class<?> mapperClass, String sqlId, Object sqlParameter) throws Exception {
        SqlSession session = null;
        try {
            SqlSessionFactory sessionFactory = sqlSessionFactory.getObject();
            session = SqlSessionUtils.getSqlSession(sessionFactory);
            return session.selectOne(mapperClass.getName() + "." + sqlId, sqlParameter);
        } finally {
            session.close();
        }
    }

}
