<?php

namespace Papaedu\Extension\Enums;

enum BadRequestCode: int
{
    /*
     * 用户
     */
    // 登录相关
    case SOCIALITE_UNBIND = 10001;// 授权未绑定账户,需跳转绑定页面

    case SOCIALITE_UNBOUND_DONT_JUMP = 10002;// 授权未绑定,无需跳转绑定页面

    case INCOMPLETE_INFORMATION = 10003;// 未完善信息

    case SOCIALITE_AUTHORIZED_FAILED = 10004;// 社会化登录授权失败

    case SOCIALITE_MISS_SESSION_KEY = 10005;// 缺少必要参数，重新获取授权信息

    case IS_GUEST = 10006;// 当前处于游客模式，请先登录

    case ACCOUNT_BANED = 10098;// 账户已封号

    case ACCOUNT_CLOSED = 10099;// 账户已注销

    // 访问相关
    case VISIT_ACCOUNT_INCOMPLETE_INFORMATION = 11003;// 访问的账户未完善信息

    case VISIT_ACCOUNT_BANED = 11098;// 访问的账户已封号

    case VISIT_ACCOUNT_CLOSED = 11099;// 访问的账户已注销

    /*
     * 通用
     */
    case REDIRECT_TO_HOME = 90001;// 返回首页

    case REDIRECT_BACK = 90002;// 返回上一个页面

    case ALERT = 90003;// 提示框, 确认按钮无交互

    case CONFIRM = 90004;// 确认框, 取消按钮无交互

    case ALERT_BACK = 90005;// 提示框, 确认按钮为返回上一个页面

    case CONFIRM_BACK = 90006;// 确认框, 取消按钮为返回上一个页面
}
