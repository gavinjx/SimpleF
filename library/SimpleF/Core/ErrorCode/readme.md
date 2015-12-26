#### ErrorCode说明
ErrorCode 长度为6位数字，其中前3位为Error分类，后3位为Error详情
对于Error分类：
* 100： Uri Error
	* 100001： 路由Uri存在，但是服务器无法找到该路径
	* 100002： Action不存在
	* 100003： 默认首页不存在