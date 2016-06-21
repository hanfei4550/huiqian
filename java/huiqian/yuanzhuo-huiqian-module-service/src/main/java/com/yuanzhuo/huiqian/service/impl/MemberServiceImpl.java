package com.yuanzhuo.huiqian.service.impl;

import com.yuanzhuo.huiqian.core.BusinessException;
import com.yuanzhuo.huiqian.core.HuiqianErrorCode;
import com.yuanzhuo.huiqian.core.HuiqianRole;
import com.yuanzhuo.huiqian.dao.MemberMapper;
import com.yuanzhuo.huiqian.model.Member;
import com.yuanzhuo.huiqian.service.MemberService;
import org.apache.commons.lang.StringUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

/**
 * Created by hanfei on 16/5/7.
 */
@Service("memberService")
public class MemberServiceImpl extends BaseServiceImpl implements MemberService {

    @Autowired
    private MemberMapper memberMapper;

    @Override
    public Member getMemberByNameAndPassword(String userName, String password) {
        if (StringUtils.isBlank(userName)) {
            throw new BusinessException(HuiqianErrorCode.HUIQIAN_USERCENTER_USERNAME_NULL);
        }
        if (StringUtils.isBlank(password)) {
            throw new BusinessException(HuiqianErrorCode.HUIQIAN_USERCENTER_PASSWORD_NULL);
        }
        Member member = new Member();
        member.setUserName(userName);
        member.setPassword(password);
        return memberMapper.selectByNameAndPassword(member);
    }

    @Override
    public int saveMember(Member member) throws BusinessException {
        if (null == member) {
            throw new BusinessException(HuiqianErrorCode.HUIQIAN_USERCENTER_MEMBER_NULL);
        }
        try {
            return memberMapper.insert(member);
        } catch (Exception ex) {
            throw new BusinessException(HuiqianErrorCode.HUIQIAN_USERCENTER_DATABASE_OPERATE_ERROR);
        }
    }

    @Override
    public int updateMember(Member member) {
        if (null == member) {
            throw new BusinessException(HuiqianErrorCode.HUIQIAN_USERCENTER_MEMBER_NULL);
        }
        return memberMapper.updateByPrimaryKeySelective(member);
    }

    @Override
    public int updateMemmberStatus(int memberId, int status) {
        Member member = new Member();
        member.setId(memberId);
        member.setStatus(status);
        return memberMapper.updateByPrimaryKeySelective(member);
    }

    @Override
    public List<Member> getAllMembers(int pageIndex, int pageSize) throws Exception {
        return (List<Member>) getPageList(MemberMapper.class, "selectAllMember", null, pageIndex, pageSize);
    }

    @Override
    public int getTotal(Member member) throws Exception {
        return getTotal(MemberMapper.class, "selectTotal", member);
    }

    @Override
    public boolean isAdministrator(Member user) {
        if (HuiqianRole.HUIQIAN_USERCENTER_ROLE_ADMINISTRATOR.ordinal() == user.getStatus().intValue()) {
            return true;
        }
        return false;
    }
}
