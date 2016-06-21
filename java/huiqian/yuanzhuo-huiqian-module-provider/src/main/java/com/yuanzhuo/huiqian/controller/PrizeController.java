package com.yuanzhuo.huiqian.controller;

import com.yuanzhuo.huiqian.core.BusinessException;
import com.yuanzhuo.huiqian.core.JsonResult;
import com.yuanzhuo.huiqian.model.Fans;
import com.yuanzhuo.huiqian.model.Prize;
import com.yuanzhuo.huiqian.model.WhiteList;
import com.yuanzhuo.huiqian.service.FansService;
import com.yuanzhuo.huiqian.service.PrizeService;
import com.yuanzhuo.huiqian.service.WhiteListService;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.ModelMap;
import org.springframework.web.bind.annotation.*;

import java.net.URLDecoder;
import java.util.ArrayList;
import java.util.List;

/**
 * Created by hanfei on 16/4/19.
 */
@Controller
@RequestMapping("/prize")
public class PrizeController {

    private static Logger logger = LoggerFactory.getLogger(PrizeController.class);

    @Autowired
    private PrizeService prizeService;


    @RequestMapping(value = "/showPrize/{activityId}", method = RequestMethod.GET)
    public String showPrize(@ModelAttribute("model") ModelMap modelMap, @PathVariable int activityId) {
        modelMap.addAttribute("activityId", activityId);
        return "/activity/showPrize";
    }

    @ResponseBody
    @RequestMapping(value = "/list/{activityId}", method = RequestMethod.GET)
    public JsonResult list(@PathVariable int activityId) {
        List<Prize> prizes = new ArrayList<Prize>();
        try {
            prizes = prizeService.getPrizeByActivityId(activityId);
        } catch (BusinessException be) {
            logger.error("发生业务异常,异常信息:{}", be.getMessage());
        } catch (Exception e) {
            logger.error("发生系统异常,异常信息:{}", e.getMessage());
        }
        return new JsonResult<Object>(prizes, "查询奖项成功.", true);
    }

    @RequestMapping(value = "/save", method = RequestMethod.POST)
    public String saveFans(@ModelAttribute("model") ModelMap modelMap, Prize prize) {
        int activityId = prize.getActivityId();
        try {
            prizeService.savePrize(prize);
        } catch (BusinessException be) {
            logger.error("发生业务异常,异常信息:{}", be.getMessage());
        } catch (Exception e) {
            logger.error("发生系统异常,异常信息:{}", e.getMessage());
        }
        return "redirect:/prize/showPrize/" + activityId + ".htmls";
    }


    @RequestMapping(value = "/delete/{activityId}/{id}", method = RequestMethod.GET)
    public String deleteFans(@PathVariable int activityId, @PathVariable int id) {
        try {
            prizeService.deleteById(id);
        } catch (BusinessException be) {
            logger.error("发生业务异常,异常信息:{}", be.getMessage());
        } catch (Exception e) {
            logger.error("发生系统异常,异常信息:{}", e.getMessage());
        }
        return "redirect:/prize/showPrize/" + activityId + ".htmls";
    }

}
