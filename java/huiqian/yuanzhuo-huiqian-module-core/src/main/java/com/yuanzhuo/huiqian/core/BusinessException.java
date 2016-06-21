package com.yuanzhuo.huiqian.core;

/**
 * 会签业务异常
 * Created by hanfei on 16/5/10.
 */
public class BusinessException extends RuntimeException {
    public BusinessException(Object Obj) {
        super(Obj.toString());
    }
}
