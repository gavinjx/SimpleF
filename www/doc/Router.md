####路由说明

约定域名为：http://gavinjx.com

URL：http://gavinjx.com/user/info/save 对应为 ```application/controller/user/Info.php``` 中的 ```saveAction```
****
备注：

1. **文件命名：**
	1. controller下的目录文件名为小写
	2. controller下的目录内的Controller类文件名首字母大写，如：Info.php
	3. Controller类名：
		1. 类名为 目录名_文件名
		2. 目录名首字母大写
		3. 文件名保持首字母大写
		如：
		
		```php
		
		class User_Info{
	
			public function saveAction()
			{
				
			}
			
		}
		```
	4. Controller类文件的Action命名：```Action```之前的字符串均为小写，如：saveAction