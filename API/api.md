# API 文档

## [用户接口](user.md)
| Method | URL    | Description                          |
| ------ | ------ | ------------------------------------ |
| POST   | /login | 用户登录接口，返回操作凭证和账户信息 |

## [操作接口](money.md)
| Method | URL             | Description            |
| ------ | --------------- | ---------------------- |
| GET    | /money          | 余额与最近操作记录查询 |
| POST   | /money/transfer | 汇款                   |
| POST   | /money/deposit  | 存款                   |
| POST   | /money/withdraw | 取款                   |