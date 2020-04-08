# 用户接口

## 登录

| Method | URL    | Description                          |
| ------ | ------ | ------------------------------------ |
| POST   | /login | 用户登录接口，返回操作凭证和账户信息 |

### payload data

| 字段        | 必须 | 类型    | 描述     |
| ----------- | ---- | ------- | -------- |
| card_number | y    | integer | 用户卡号 |
| password    | y    | integer  | 六位数字密码     |

### request example
```jsonc
{
    "card_number": "4008823823",
    "password": "123456",
}
```

### response example
#### error example
```jsonc
{
    "errcode": 1002,
    "message": "密码错误，还可以尝试 4 次",
    "attempt": 1,
}
```

#### success example
```jsonc
{
    "errcode": 0,
    "message": "操作成功"
}
```