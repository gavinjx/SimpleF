## SimpleF
=======
简易的PHP框架，小巧灵活，拥有ZendFramework的基础功能：支持MVC，路由功能，告别臃肿~

[Nginx配置说明](Rewrite.md)

[路由说明](www/doc/Router.md)

```/tmp``` 默认为```Smarty```模板的tmp文件输出目录，需要加入 php可写入权限

目录结构为：

| application    &nbsp;&nbsp;//MVC主体文件

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;| controller    &nbsp;&nbsp;//Controller类存放目录

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;| model    &nbsp;&nbsp;//Model类存放目录

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;| views    &nbsp;&nbsp;//View模板存放目录

| config    &nbsp;&nbsp;//配置文件目录

| library    &nbsp;&nbsp;//引用库存储目录

| tmp

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;| compile_dir    &nbsp;&nbsp;//smarty编译文件存储目录

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;| config_dir     &nbsp;&nbsp;//smarty加载外部配置文件存储目录

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;| cache_dir     &nbsp;&nbsp;//smarty cache文件存储目录

| www    &nbsp;&nbsp;//根目录

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;| css     &nbsp;&nbsp;//css文件目录

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;| js     &nbsp;&nbsp;//js文件目录

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;| images     &nbsp;&nbsp;//images文件目录

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;| index.php     &nbsp;&nbsp;//index文件