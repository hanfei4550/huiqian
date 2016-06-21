package com.yuanzhuo.huiqian.controller;

import com.yuanzhuo.huiqian.core.BusinessException;
import com.yuanzhuo.huiqian.core.JsonResult;
import com.yuanzhuo.huiqian.model.Activity;
import com.yuanzhuo.huiqian.model.Member;
import com.yuanzhuo.huiqian.service.ActivityService;
import com.yuanzhuo.huiqian.service.MemberService;
import com.yuanzhuo.huiqian.util.EncodeUitl;
import com.yuanzhuo.huiqian.util.SHAUtil;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.ModelMap;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributesModelMap;

import javax.servlet.http.HttpSession;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

/**
 * Created by hanfei on 16/4/19.
 */
@Controller
@RequestMapping("/member")
public class MemberController {

    private Logger logger = LoggerFactory.getLogger(MemberController.class);

    private static final int PAGE_SIZE = 5;

    @Autowired
    private MemberService memberService;

    @Autowired
    private ActivityService activityService;

//    @ResponseBody
//    @RequestMapping(value = "/save", method = RequestMethod.POST)
//    public JsonResult saveMember(Member member) {
//        String password = member.getPassword();
//        try {
//            password = SHAUtil.shaEncode(password);
//            member.setPassword(password);
//            member.setCreateTime(new Date());
//            memberService.saveMember(member);
//        } catch (BusinessException be) {
//            logger.error("发生业务异常,异常信息:{}", be.getMessage());
//        } catch (Exception e) {
//            logger.error("发生系统异常,异常信息:{}", e.getMessage());
//        }
//        return new JsonResult<Object>(null, "插入成功", true);
//    }

    @RequestMapping(value = "/save", method = RequestMethod.POST)
    public String saveMember(RedirectAttributesModelMap modelMap, Member member) {
        String password = member.getPassword();
        try {
            password = SHAUtil.shaEncode(password);
            member.setPassword(password);
            member.setCreateTime(new Date());
            memberService.saveMember(member);
        } catch (BusinessException be) {
            modelMap.addAttribute("msg", EncodeUitl.encode("注册用户失败"));
            logger.error("发生业务异常,异常信息:{}", be.getMessage());
        } catch (Exception e) {
            modelMap.addAttribute("msg", EncodeUitl.encode("注册用户失败"));
            logger.error("发生系统异常,异常信息:{}", e.getMessage());
        }
        modelMap.addAttribute("result", "success");
        modelMap.addAttribute("msg", EncodeUitl.encode("注册成功,等待会签工作人员审核通过后进行后台登录."));
        return "redirect:/result.jsp";
    }

//    @RequestMapping(value = "/login", method = RequestMethod.POST)
//    public String login(@ModelAttribute("model") RedirectAttributesModelMap modelMap, Member member) {
//        String password = member.getPassword();
//        try {
//            password = SHAUtil.shaEncode(password);
//            Member user = memberService.getMemberByNameAndPassword(member.getUserName(), password);
//            if (null == user) {
//                modelMap.addFlashAttribute("result", "error");
//                modelMap.addFlashAttribute("msg", "用户信息不存在");
//                return "redirect:/member/result";
//            }
//        } catch (BusinessException be) {
//            logger.error("发生业务异常,异常信息:{}", be.getMessage());
//        } catch (Exception e) {
//            logger.error("发生系统异常,异常信息:{}", e.getMessage());
//        }
//        List<Activity> activities = activityService.getAllActivity();
//        modelMap.addFlashAttribute("activities", activities);
//        logger.info("活动信息列表:{}", activities);
//        return "redirect:/activity/all";
//    }

    @RequestMapping(value = "/login", method = RequestMethod.POST)
    public String login(@ModelAttribute("model") ModelMap modelMap, RedirectAttributesModelMap redirectModelMap, Member member, HttpSession httpSession) {
        String password = member.getPassword();
        try {
            password = SHAUtil.shaEncode(password);
            Member user = memberService.getMemberByNameAndPassword(member.getUserName(), password);
            if (null == user) {
                redirectModelMap.addAttribute("result", "error");
                redirectModelMap.addAttribute("msg", EncodeUitl.encode("用户信息不存在"));
                return "redirect:/result.jsp";
            }
            httpSession.setAttribute("user", user);
            if (memberService.isAdministrator(user)) {
                int total = activityService.getTotal();
                modelMap.addAttribute("total", total);
                return "/activity/manageActivity";
            }
            int total = activityService.getTotalByMemberId(user.getId());
            modelMap.addAttribute("memberId", user.getId());
            modelMap.addAttribute("total", total);
        } catch (BusinessException be) {
            logger.error("发生业务异常,异常信息:{}", be.getMessage());
        } catch (Exception e) {
            logger.error("发生系统异常,异常信息:{}", e.getMessage());
        }
        return "/activity/showActivity";
    }


    @RequestMapping(value = "/logout", method = RequestMethod.GET)
    public String logout(HttpSession httpSession) {
        httpSession.invalidate();
        return "redirect:/login.jsp";
    }

    @ResponseBody
    @RequestMapping(value = "/query", method = RequestMethod.GET)
    public JsonResult queryActivitys(int memberId, @RequestParam(defaultValue = "0") int pageIndex) {
        List<Activity> activities = new ArrayList<Activity>();
        try {
            activities = activityService.getActivityByMemberId(memberId, pageIndex, PAGE_SIZE);
            logger.info("活动信息列表:{}", activities);
        } catch (BusinessException be) {
            logger.error("发生业务异常,异常信息:{}", be.getMessage());
        } catch (Exception e) {
            logger.error("发生系统异常,异常信息:{}", e.getMessage());
        }
        return new JsonResult<Object>(activities, "查询活动成功.", true);
    }


}
