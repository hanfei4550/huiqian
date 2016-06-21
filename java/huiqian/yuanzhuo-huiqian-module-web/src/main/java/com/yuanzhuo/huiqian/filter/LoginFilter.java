package com.yuanzhuo.huiqian.filter;

import com.yuanzhuo.huiqian.model.Member;

import javax.servlet.*;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import java.io.IOException;

/**
 * Created by hanfei on 16/5/16.
 */
public class LoginFilter implements Filter {
    @Override
    public void init(FilterConfig filterConfig) throws ServletException {

    }

    @Override
    public void doFilter(ServletRequest servletRequest, ServletResponse servletResponse, FilterChain filterChain) throws IOException, ServletException {
        // 判断是否是http请求
        if (!(servletRequest instanceof HttpServletRequest)
                || !(servletResponse instanceof HttpServletResponse)) {
            throw new ServletException(
                    "当前只支持http请求.");
        }
        // 获得在下面代码中要用的request,response,session对象
        HttpServletRequest httpRequest = (HttpServletRequest) servletRequest;
        HttpServletResponse httpResponse = (HttpServletResponse) servletResponse;
        HttpSession session = httpRequest.getSession(true);

        String[] strs = {"login", "register", "logout", "static", "member/save", "result", "activity/queryActivityByActivityNo", "activity/queryWhiteListByActivityId", "activity/clearActivityByActivityNo", "activity/saveActivityWinningList"}; // 路径中包含这些字符串的,可以不用登录直接访问
        StringBuffer url = httpRequest.getRequestURL();

        /**
         * 过滤掉根目录
         */
        String path = httpRequest.getContextPath();
        String protAndPath = httpRequest.getServerPort() == 80 ? "" : ":"
                + httpRequest.getServerPort();
        String basePath = httpRequest.getScheme() + "://"
                + httpRequest.getServerName() + protAndPath + path + "/";
        if (basePath.equalsIgnoreCase(url.toString())) {
            filterChain.doFilter(servletRequest, servletResponse);
            return;
        }

        // 特殊用途的路径可以直接访问
        if (strs != null && strs.length > 0) {
            for (String str : strs) {
                if (url.indexOf(str) >= 0) {
                    filterChain.doFilter(servletRequest, servletResponse);
                    return;
                }
            }
        }

        Member user = (Member) session.getAttribute("user");
        if (null != user) {
            // 用户存在,可以访问此地址
            filterChain.doFilter(servletRequest, servletResponse);
        } else {
            // 用户不存在,踢回登录页面
            String returnUrl = httpRequest.getContextPath() + "/login.jsp";
            httpRequest.setCharacterEncoding("UTF-8");
            httpResponse.setContentType("text/html; charset=UTF-8"); // 转码
            httpResponse
                    .getWriter()
                    .println(
                            "<script language=\"javascript\">alert(\"您还没有登录，请先登录!\");if(window.opener==null){window.top.location.href=\""
                                    + returnUrl
                                    + "\";}else{window.opener.top.location.href=\""
                                    + returnUrl
                                    + "\";window.close();}</script>");
            return;
        }

    }

    @Override
    public void destroy() {

    }


}
