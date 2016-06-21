package com.yuanzhuo.huiqian.controller;

import com.yuanzhuo.huiqian.core.BusinessException;
import com.yuanzhuo.huiqian.core.HuiqianRole;
import com.yuanzhuo.huiqian.core.JsonResult;
import com.yuanzhuo.huiqian.model.*;
import com.yuanzhuo.huiqian.service.*;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.ModelMap;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

/**
 * Created by hanfei on 16/4/19.
 */
@Controller
@RequestMapping("/admin")
public class AdministratorController {

    private static Logger logger = LoggerFactory.getLogger(AdministratorController.class);

    @Autowired
    private ActivityService activityService;

    @Autowired
    private MemberService memberService;


    @RequestMapping(value = "/activity/total", method = RequestMethod.GET)
    public String getTotalActivity(@ModelAttribute("model") ModelMap modelMap, int memberId) {
        try {
            int total = activityService.getTotal();
            modelMap.addAttribute("memberId", memberId);
            modelMap.addAttribute("total", total);
        } catch (Exception e) {
            e.printStackTrace();
        }
        return "/activity/manageActivity";
    }

    @ResponseBody
    @RequestMapping(value = "/activity/all", method = RequestMethod.GET)
    public JsonResult queryAllActivitys(@RequestParam(defaultValue = "0") int pageIndex, @RequestParam(defaultValue = "5") int pageSize) {
        List<Activity> activities = new ArrayList<Activity>();
        try {
            activities = activityService.getAllActivity(pageIndex, pageSize);
            logger.info("活动信息列表:{}", activities);
        } catch (BusinessException be) {
            logger.error("发生业务异常,异常信息:{}", be.getMessage());
        } catch (Exception e) {
            logger.error("发生系统异常,异常信息:{}", e.getMessage());
        }
        return new JsonResult<Object>(activities, "查询活动成功.", true);
    }

    @RequestMapping(value = "/member/total", method = RequestMethod.GET)
    public String getTotalMember(@ModelAttribute("model") ModelMap modelMap, int memberId) {
        try {
            int total = memberService.getTotal(new Member());
            modelMap.addAttribute("memberId", memberId);
            modelMap.addAttribute("total", total);
        } catch (Exception e) {
            e.printStackTrace();
        }
        return "/activity/manageMember";
    }

    @ResponseBody
    @RequestMapping(value = "/member/all", method = RequestMethod.GET)
    public JsonResult queryAllMembers(@RequestParam(defaultValue = "0") int pageIndex, @RequestParam(defaultValue = "5") int pageSize) {
        List<Member> members = new ArrayList<Member>();
        try {
            members = memberService.getAllMembers(pageIndex, pageSize);
            logger.info("会员信息列表:{}", members);
        } catch (BusinessException be) {
            logger.error("发生业务异常,异常信息:{}", be.getMessage());
        } catch (Exception e) {
            logger.error("发生系统异常,异常信息:{}", e.getMessage());
        }
        return new JsonResult<Object>(members, "查询会员成功.", true);
    }


    @RequestMapping(value = "/member/verify/{memberId}", method = RequestMethod.GET)
    public String verifyMember(@ModelAttribute("model") ModelMap modelMap, @PathVariable int memberId) {
        try {
            memberService.updateMemmberStatus(memberId, HuiqianRole.HUIQIAN_USERCENTER_ROLE_VALID_USER.ordinal());
            int total = memberService.getTotal(new Member());
            modelMap.addAttribute("memberId", memberId);
            modelMap.addAttribute("total", total);
        } catch (BusinessException be) {
            logger.error("发生业务异常,异常信息:{}", be.getMessage());
        } catch (Exception e) {
            logger.error("发生系统异常,异常信息:{}", e.getMessage());
        }
        return "redirect:/admin/member/total.htmls?memberId=" + memberId;
    }
}
