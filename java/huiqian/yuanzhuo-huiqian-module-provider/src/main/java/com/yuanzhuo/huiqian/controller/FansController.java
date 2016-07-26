package com.yuanzhuo.huiqian.controller;

import com.yuanzhuo.huiqian.core.BusinessException;
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
import java.net.URLDecoder;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

/**
 * Created by hanfei on 16/4/19.
 */
@Controller
@RequestMapping("/fans")
public class FansController {

    private static Logger logger = LoggerFactory.getLogger(FansController.class);

    @Autowired
    private FansService fansService;

    @Autowired
    private WhiteListService whiteListService;

    @Autowired
    private PrizeService prizeService;

    @ResponseBody
    @RequestMapping(value = "/page", method = RequestMethod.GET)
    public JsonResult queryFans(int activityId, String nick, @RequestParam(defaultValue = "0") int pageIndex, @RequestParam(defaultValue = "5") int pageSize) {
        Map<String, Object> resultMap = new HashMap<String, Object>();
        try {
            nick = URLDecoder.decode(nick, "UTF-8");
            List<Fans> fansList = fansService.getFansByParams(activityId, nick, pageIndex, pageSize);
            int total = fansService.getTotalByParams(activityId, nick);
            List<WhiteList> whiteLists = whiteListService.getWhiteListByActivityId(activityId);
            List<Prize> prizes = prizeService.getPrizeByActivityId(activityId);
            for (Fans fans : fansList) {
                int fansId = fans.getId();
                String prizeName = whiteListService.getPrize(prizes, whiteLists, activityId, fansId);
                fans.setPrize(prizeName);
            }
            resultMap.put("data", fansList);
            resultMap.put("total", total);
            logger.info("粉丝信息列表:{}", fansList);
        } catch (BusinessException be) {
            logger.error("发生业务异常,异常信息:{}", be.getMessage());
        } catch (Exception e) {
            logger.error("发生系统异常,异常信息:{}", e.getMessage());
        }
        return new JsonResult<Object>(resultMap, "查询粉丝成功.", true);
    }

    @RequestMapping(value = "/save", method = RequestMethod.POST)
    public String saveFans(@ModelAttribute("model") ModelMap modelMap, int userId, int activityId, String nick) {
        try {
            fansService.saveFans(userId, activityId, nick);
        } catch (BusinessException be) {
            logger.error("发生业务异常,异常信息:{}", be.getMessage());
        } catch (Exception e) {
            logger.error("发生系统异常,异常信息:{}", e.getMessage());
        }
        return "redirect:/activity/showFans/" + activityId + ".htmls";
    }


    @RequestMapping(value = "/delete/{activityId}/{fansId}", method = RequestMethod.GET)
    public String deleteFans(@PathVariable int activityId, @PathVariable int fansId) {
        try {
            fansService.deleteFans(activityId, fansId);
        } catch (BusinessException be) {
            logger.error("发生业务异常,异常信息:{}", be.getMessage());
        } catch (Exception e) {
            logger.error("发生系统异常,异常信息:{}", e.getMessage());
        }
        return "redirect:/activity/showFans/" + activityId + ".htmls";
    }

}
