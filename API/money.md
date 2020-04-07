# 操作接口

## 查询
| Method | URL    | Description            |
| ------ | ------ | ---------------------- |
| GET    | /money | 余额与最近操作记录查询 |

### response example
```json
{
    "errcode": 0,
    "message": "操作成功",
    "data": {
        "balance": 123.34, // 余额
        "records": [ // 最近5次存取款操作记录，即数组长度最大为5
            {
                "date": "2020-04-01 12:00:00", // 操作日期
                /**
                 * 0: 存款
                 * 1: 取款
                 * 2: 转帐入账
                 * 3: 转帐出账
                 */
                "operation": 1,
                "amount": 100.00 // 金额
            },
            ...
        ]
    }
}
```

## 汇款
| Method | URL             | Description |
| ------ | --------------- | ----------- |
| POST   | /money/transfer | 汇款        |

### payload data

| 字段           | 必须 | 类型    | 描述     |
| -------------- | ---- | ------- | -------- |
| amount         | y    | integer | 金额     |
| transfer_perty | y    | integer | 转帐账户 |

### request example
```json
{
    "errcode": 0,
    "message": "操作成功",
    "data": {
        "date": "2020-04-01 12:00:00",
        "amount": 100.00,
        "operation": 3,
    }
}
```

### response example

## 存款
| Method | URL            | Description |
| ------ | -------------- | ----------- |
| POST   | /money/deposit | 存款        |

### payload data

| 字段   | 必须 | 类型    | 描述     |
| ------ | ---- | ------- | -------- |
| amount | y    | integer | 存款金额 |

### response example
```json
{
    "errcode": 0,
    "message": "操作成功",
    "data": {
        "date": "2020-04-01 12:00:00",
        "amount": 100.00,
        "operation": 0,
    }
}
```

## 取款
| Method | URL             | Description |
| ------ | --------------- | ----------- |
| POST   | /money/withdraw | 取款        |

### payload data

| 字段   | 必须 | 类型    | 描述     |
| ------ | ---- | ------- | -------- |
| amount | y    | integer | 取款金额 |

### response example
```json
{
    "errcode": 0,
    "message": "操作成功",
    "data": {
        "date": "2020-04-01 12:00:00",
        "amount": 100.00,
        "operation": 1,
    }
}
```