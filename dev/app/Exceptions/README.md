异常定义

该目录下的文件都是用来定义系统可能会扔出的异常，建议使用异常来表示系统执行出错，请按照分类建立文件夹归类异常。

Web App中Exceptions定义了业务异常类，为了规范使用自定义Error Code使用，定义如下：

InternalServerError : 服务端异常 { Error Code 区间: [50500,59999], Status Code: 500 }

ServicesException : WePro服务异常 { Error Code 区间: [70000,79999], Status Code: 200 }

BadRequest : Bad request 异常 { Error Code 区间: [40000,40099], Status Code: 200 }

Conflict : 数据锁冲突  { Error Code 区间: [40900,40999], Status Code: 200 }

Forbidden : 用户无权操作 { Error Code 区间: [40300,40399], Status Code: 200 }

MethodNotAllowed : 请求方法不支持 { Error Code 区间: [40500,40599], Status Code: 200 }

NotFound : 请求资源未找到 { Error Code 区间: [40400,40499], Status Code: 200 }

ServiceUnavailable : 服务暂不可用 { Error Code 区间: [50300,50399], Status Code: 200 }

TooManyRequests : 请求次数过多 { Error Code 区间: [42900,42999], Status Code: 200 }

Unauthorized : 无法验证用户身份 { Error Code 区间: [40100,40199], Status Code: 200 }

UnsupportedMediaType : 请求的媒体格式不支持 { Error Code 区间: [41500,41599], Status Code: 200 }

ValidationFailed : 数据验证失败 { Error Code 区间: [42200,42299], Status Code: 200 }

使用异常的好处，请参考[此链接](https://docs.oracle.com/javase/tutorial/essential/exceptions/advantages.html)