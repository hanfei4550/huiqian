package com.yuanzhuo.huiqian.controller;

import com.yuanzhuo.huiqian.core.BusinessException;
import com.yuanzhuo.huiqian.core.JsonResult;
import com.yuanzhuo.huiqian.model.Activity;
import com.yuanzhuo.huiqian.model.ActivityFans;
import com.yuanzhuo.huiqian.model.User;
import com.yuanzhuo.huiqian.service.ActivityFansService;
import com.yuanzhuo.huiqian.service.UserService;
import com.yuanzhuo.huiqian.util.DateUtil;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.ModelMap;
import org.springframework.web.bind.annotation.*;

import java.util.Date;
import java.util.HashMap;
import java.util.Map;

/**
 * Created by hanfei on 16/4/19.
 */
@Controller
@RequestMapping("/activity")
public class ActivityFansController {
    private static Logger logger = LoggerFactory.getLogger(ActivityFansController.class);

    @Autowired
    private ActivityFansService activityFansService;

    @ResponseBody
    @RequestMapping(value = "/fans/validate", method = RequestMethod.GET)
    public JsonResult validate(@RequestParam String activityId, @RequestParam String name, @RequestParam String phone) {
        Map<String, String> result = new HashMap<String, String>();
        try {
            ActivityFans activityFans = activityFansService.getActivityFansByUserInfo(activityId, name, phone);
            if (null != activityFans) {
                result.put("isValid", "true");
            }
        } catch (BusinessException be) {
            logger.error("发生业务异常,异常信息:{}", be.getMessage());
            result.put("isValid", "false");
        } catch (Exception e) {
            logger.error("发生系统异常,异常信息:{}", e.getMessage());
            result.put("isValid", "false");
        }
        return new JsonResult<Object>(result, "验证用户成功.", true);
    }

}
