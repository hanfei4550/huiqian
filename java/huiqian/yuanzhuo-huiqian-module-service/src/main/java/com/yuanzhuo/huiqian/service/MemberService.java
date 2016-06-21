package com.yuanzhuo.huiqian.service;

import com.yuanzhuo.huiqian.core.BusinessException;
import com.yuanzhuo.huiqian.model.Member;

import java.util.List;

/**
 * 注册会员服务
 * Created by hanfei on 16/4/19.
 */
public interface MemberService {
    /**
     * 根据用户名和密码查询有效用户
     *
     * @param userName 用户名
     * @param password 密码
     * @return 注册用户信息
     */
    Member getMemberByNameAndPassword(String userName, String password);

    /**
     * 保存注册用户信息
     *
     * @param member 用户信息
     * @return 插入成功的数量
     */
    int saveMember(Member member) throws BusinessException;

    /**
     * 更新注册用户信息
     *
     * @param member 用户信息
     * @return 更新成功的数量
     */
    int updateMember(Member member);

    /**
     * 根据会员id更新会员状态
     *
     * @param memberId 会员id
     * @param status   会员状态
     * @return 更新的会员数量
     */
    int updateMemmberStatus(int memberId, int status);

    /**
     * 分页查询所有的注册会员信息
     *
     * @param pageIndex 当前页
     * @param pageSize  每页条数
     * @return 当前页的注册会员
     * @throws
     */
    List<Member> getAllMembers(int pageIndex, int pageSize) throws Exception;

    /**
     * 根据会员查询条件查询会员总数
     *
     * @param member 会员查询条件
     * @return 会员总数
     * @throws Exception
     */
    int getTotal(Member member) throws Exception;

    /**
     * 判断用户是否是管理员
     *
     * @param user 用户信息
     * @return 是否是管理员
     */
    boolean isAdministrator(Member user);


}
