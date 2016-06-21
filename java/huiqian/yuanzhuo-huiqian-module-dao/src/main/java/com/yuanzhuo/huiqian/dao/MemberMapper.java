package com.yuanzhuo.huiqian.dao;

import com.yuanzhuo.huiqian.model.Member;

import java.util.List;

public interface MemberMapper {
    int deleteByPrimaryKey(Integer id);

    int insert(Member record);

    int insertSelective(Member record);

    Member selectByPrimaryKey(Integer id);

    int updateByPrimaryKeySelective(Member record);

    int updateByPrimaryKey(Member record);

    /**
     * 根据用户名和密码查询管理员信息
     *
     * @param record 包括用户名和密码
     * @return 管理员信息
     */
    Member selectByNameAndPassword(Member record);

    List<Member> getAllMember(int pageIndex, int pageSize);

}