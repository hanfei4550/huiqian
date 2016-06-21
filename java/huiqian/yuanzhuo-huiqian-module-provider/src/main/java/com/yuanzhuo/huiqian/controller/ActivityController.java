package com.yuanzhuo.huiqian.controller;

import com.alibaba.fastjson.JSON;
import com.alibaba.fastjson.JSONObject;
import com.yuanzhuo.huiqian.core.BusinessException;
import com.yuanzhuo.huiqian.core.HuiqianErrorCode;
import com.yuanzhuo.huiqian.core.JsonResult;
import com.yuanzhuo.huiqian.model.*;
import com.yuanzhuo.huiqian.service.*;
import com.yuanzhuo.huiqian.util.DateUtil;
import com.yuanzhuo.huiqian.util.HttpRequestUtil;
import com.yuanzhuo.huiqian.util.PropertiesUtil;
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
import java.net.URLEncoder;
import java.util.*;

/**
 * Created by hanfei on 16/4/19.
 */
@Controller
@RequestMapping("/activity")
public class ActivityController {

    private static Logger logger = LoggerFactory.getLogger(ActivityController.class);

    @Autowired
    private ActivityService activityService;

    @Autowired
    private ActivityFansService activityFansService;

    @Autowired
    private UserActivityService userActivityService;

    @Autowired
    private FansService fansService;

    @Autowired
    private WhiteListService whiteListService;

    @Autowired
    private ActivityWinningListService activityWinningListService;

    @Autowired
    private PrizeService prizeService;

    @RequestMapping(value = "/all", method = RequestMethod.GET)
    public String getAllActivity(@ModelAttribute("model") ModelMap modelMap, int memberId) {
        try {
            int total = activityService.getTotalByMemberId(memberId);
            modelMap.addAttribute("memberId", memberId);
            modelMap.addAttribute("total", total);
        } catch (Exception e) {
            e.printStackTrace();
        }
        return "/activity/showActivity";
    }

    @RequestMapping(value = "/save", method = RequestMethod.POST)
    public String saveActivity(@ModelAttribute("model") ModelMap modelMap, ActivityVO activity, int memberId) {
        try {
            int activityId = activityService.saveActivity(activity);
            UserActivity userActivity = new UserActivity();
            userActivity.setUserId(memberId);
            userActivity.setActivityId(activityId);
            userActivityService.saveUserActivity(userActivity);
            int total = activityService.getTotalByMemberId(memberId);
            modelMap.addAttribute("memberId", memberId);
            modelMap.addAttribute("total", total);
        } catch (BusinessException be) {
            logger.error("发生业务异常,异常信息:{}", be.getMessage());
        } catch (Exception e) {
            logger.error("发生系统异常,异常信息:{}", e.getMessage());
        }
        return "/activity/showActivity";
    }

    @RequestMapping("/showUpload/{activityId}")
    public String showUpload(ModelMap modelMap, @PathVariable int activityId) {
        modelMap.addAttribute("activityId", activityId);
        return "/activity/showUpload";
    }

    @RequestMapping("/showFans/{activityId}")
    public String showFans(@ModelAttribute("model") ModelMap modelMap, @PathVariable int activityId, @RequestParam(defaultValue = "0") int pageIndex, @RequestParam(defaultValue = "5") int pageSize) {
        try {
            int total = fansService.getTotalByActivityId(activityId);
//            List<WhiteList> whiteList = whiteListService.getWhiteListByActivityId(activityId);
//            modelMap.addAttribute("whiteList", whiteList);
            modelMap.addAttribute("total", total);
        } catch (Exception e) {
            e.printStackTrace();
        }
        modelMap.addAttribute("activityId", activityId);
        return "/activity/showFans";
    }

    @RequestMapping("/setPrize/{activityId}/{fansId}")
    public String setPrize(@ModelAttribute("model") ModelMap modelMap, @PathVariable int activityId, @PathVariable int fansId) {
        try {
            Fans fans = fansService.getFansById(fansId);
            WhiteList whiteList = whiteListService.getWhiteListByActivityAndFans(activityId, fansId);
            List<Prize> prizes = prizeService.getPrizeByActivityId(activityId);
            modelMap.addAttribute("fans", fans);
            modelMap.addAttribute("whiteList", JSON.toJSONString(whiteList));
            modelMap.addAttribute("prizes", prizes);
        } catch (Exception e) {
            e.printStackTrace();
        }
        modelMap.addAttribute("activityId", activityId);
        return "/activity/setPrize";
    }

    @RequestMapping("/savePrize")
    public String savePrize(@ModelAttribute("model") ModelMap modelMap, WhiteList whiteList) {
        try {
            if (whiteList.getId() == null) {
                whiteListService.saveWhiteList(whiteList);
            } else {
                whiteListService.updateWhiteList(whiteList);
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
        return "redirect:/activity/showFans/" + whiteList.getActivityId() + ".htmls";
    }

    @RequestMapping("/showDetail/{activityId}")
    public String showDetail(@ModelAttribute("model") ModelMap modelMap, @PathVariable int activityId) {
        try {
            Activity activity = activityService.getActivityById(activityId);
            modelMap.addAttribute("activity", activity);
        } catch (Exception e) {
            e.printStackTrace();
        }
        modelMap.addAttribute("activityId", activityId);
        return "/activity/showDetail";
    }

    @RequestMapping("/showWinningList/{activityId}")
    public String showWinningList(@ModelAttribute("model") ModelMap modelMap, @PathVariable int activityId) {
        modelMap.addAttribute("activityId", activityId);
        return "/activity/showWinningList";
    }

    @RequestMapping("/generateQrcode/{activityNo}")
    public String generateQrcode(@ModelAttribute("model") ModelMap modelMap, @PathVariable String activityNo) {
        try {
            String env = PropertiesUtil.getStringPropValue("env");
            logger.info("环境:{}", env);
            String domainName = PropertiesUtil.getStringPropValue(env + ".domainName");
            String appId = PropertiesUtil.getStringPropValue(env + ".appId");
            String resultUrl = URLEncoder.encode("https://open.weixin.qq.com/connect/oauth2/authorize?appid=" + appId + "&redirect_uri=" + domainName + "/huiqian/HuiqianService.php?activityno=" + activityNo + "&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect", "UTF-8");
            String destUrl = domainName + "/huiqian/baidu_shorturl_test.php?url=" + resultUrl;
            logger.info("完整的url:{}", destUrl);
            JSONObject result = HttpRequestUtil.httpGet(destUrl);
            if (result.getIntValue("status") != 0) {
                throw new BusinessException(HuiqianErrorCode.HUIQIAN_ACTIVITYCENTER_QRCODE_ERROR);
            }
            String shortUrl = result.getString("tinyurl");
            modelMap.addAttribute("url", shortUrl);
        } catch (Exception e) {
            e.printStackTrace();
        }
        return "/activity/generateQrcode";
    }

    @ResponseBody
    @RequestMapping(value = "/queryActivityByActivityNo/{activityNo}", method = RequestMethod.GET)
    public JsonResult getActivityByActivityNo(@PathVariable String activityNo) {
        Map<String, String> result = new HashMap<String, String>();
        try {
            Activity activity = activityService.getActivityByActivityNo(activityNo);
            if (null == activity) {
                return new JsonResult(null, "活动不存在.", true);
            }
            result.put("currentTime", DateUtil.dateToString(new Date()));
            result.put("beginTime", DateUtil.dateToString(activity.getBeginTime()));
        } catch (BusinessException be) {
            logger.error("发生业务异常,异常信息:{}", be.getMessage());
        } catch (Exception e) {
            logger.error("发生系统异常,异常信息:{}", e.getMessage());
        }
        return new JsonResult<Object>(result, "查询活动成功.", true);
    }

    @ResponseBody
    @RequestMapping(value = "/queryWhiteListByActivityId/{activityId}", method = RequestMethod.GET)
    public JsonResult getWhiteListByActivityId(@PathVariable int activityId) {
        List<WhiteList> whiteLists = new ArrayList<WhiteList>();
        try {
            whiteLists = whiteListService.getWhiteListByActivityId(activityId);
        } catch (BusinessException be) {
            logger.error("发生业务异常,异常信息:{}", be.getMessage());
        } catch (Exception e) {
            logger.error("发生系统异常,异常信息:{}", e.getMessage());
        }
        return new JsonResult<Object>(whiteLists, "查询活动白名单成功.", true);
    }

    @ResponseBody
    @RequestMapping(value = "/clearWhiteList", method = RequestMethod.POST)
    public JsonResult clearWhiteList(@RequestParam int activityId, @RequestParam int fansId) {
        try {
            whiteListService.deleteByActivityAndFans(activityId, fansId);
        } catch (BusinessException be) {
            logger.error("发生业务异常,异常信息:{}", be.getMessage());
        } catch (Exception e) {
            logger.error("发生系统异常,异常信息:{}", e.getMessage());
        }
        return new JsonResult<Object>(null, "删除活动白名单成功.", true);
    }

    @ResponseBody
    @RequestMapping(value = "/clearActivityByActivityNo/{activityNo}", method = RequestMethod.GET)
    public JsonResult clearActivityByActivityNo(@PathVariable String activityNo) {
        try {
            activityService.deleteActivityDataByActivityNo(activityNo);
        } catch (BusinessException be) {
            logger.error("发生业务异常,异常信息:{}", be.getMessage());
        } catch (Exception e) {
            logger.error("发生系统异常,异常信息:{}", e.getMessage());
        }
        return new JsonResult<Object>(null, "清理活动数据成功.", true);
    }

    @ResponseBody
    @RequestMapping(value = "/saveActivityWinningList", method = RequestMethod.POST)
    public JsonResult saveActivityWinningList(String activityWinningList) {
        try {
            activityWinningListService.saveActivityWinningList(activityWinningList);
        } catch (BusinessException be) {
            logger.error("发生业务异常,异常信息:{}", be.getMessage());
        } catch (Exception e) {
            logger.error("发生系统异常,异常信息:{}", e.getMessage());
        }
        return new JsonResult<Object>(null, "活动中奖人员数据保存成功.", true);
    }

    @ResponseBody
    @RequestMapping(value = "/getActivityWinningList/{activityId}", method = RequestMethod.GET)
    public JsonResult getActivityWinningList(@PathVariable int activityId) {
        List<ActivityWinningList> awl = new ArrayList<ActivityWinningList>();
        try {
            awl = activityWinningListService.getWinningListByActivityId(activityId);
        } catch (Exception e) {
            logger.error("发生系统异常,异常信息:{}", e.getMessage());
        }
        return new JsonResult<Object>(awl, "查询活动中奖人员名单成功.", true);
    }

    @ResponseBody
    @RequestMapping("/member/upload")
    public Map<String, Object> memberUpload(@RequestParam MultipartFile fansFile, @RequestParam int activityId) {
        Map<String, Object> dataMap = new HashMap<String, Object>();
        String fileName = fansFile.getOriginalFilename();
        logger.info("文件名称:{},活动ID:{}", fileName, activityId);
        InputStream fileInputStream = null;
        BufferedReader br = null;
        try {
            fileInputStream = fansFile.getInputStream();
            br = new BufferedReader(new InputStreamReader(fileInputStream));
            String line = null;
            while ((line = br.readLine()) != null) {
                String[] userInfo = line.split(" ");
                String name = userInfo[0];
                String phone = userInfo[1];
                ActivityFans activityFans = new ActivityFans();
                activityFans.setName(name);
                activityFans.setPhone(phone);
                activityFans.setActivityId(String.valueOf(activityId));
                activityFansService.insert(activityFans);
            }
        } catch (Exception e) {
            dataMap.put("result", "上传流程时发生错误");
            logger.error("上传错误!异常:{}", e.getMessage());
        } finally {
            try {
                fileInputStream.close();
            } catch (IOException e) {
                logger.error("上传错误!异常:{}", e.getMessage());
            }
            try {
                br.close();
            } catch (IOException e) {
                logger.error("上传错误!异常:{}", e.getMessage());
            }
        }
        dataMap.put("result", "success");
        return dataMap;
    }

}
