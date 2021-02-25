<?php

namespace Papaedu\Extension\Enums;

final class BadRequestCode
{
    /*
     * 用户
     */
    public const SOCIALITE_UNBIND = 10001;// 授权未绑定账户,需跳转绑定页面

    public const SOCIALITE_UNBOUND_DONT_JUMP = 10002;// 授权未绑定,无需跳转绑定页面

    public const INCOMPLETE_INFORMATION = 10003;// 未完善信息

    public const SOCIALITE_AUTHORIZED_FAILED = 10004;// 社会化登录授权失败

    public const SOCIALITE_MISS_SESSION_KEY = 10005;// 缺少必要参数，重新获取授权信息

    public const AUTH_CLOSED = 11001;// 账户已注销

    /*
     * 通用
     */
    public const REDIRECT_TO_HOME = 90001;// 返回首页

    public const REDIRECT_BACK = 90002;// 返回上一个页面
}
