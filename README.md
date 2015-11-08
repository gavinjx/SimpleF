## SimpleF
=======
简易PHP框架，小巧灵活，拥有ZendFramework的基础功能，简约至上！

#### 配置说明

* 配置Nginx rewrite规则如下：

```nginx 
location / {
    root /Users/gavin/www/local/SimpleF/www;
    index index.html index.htm index.php;
    if (!-e $request_filename) {
       rewrite ^(.*)$ /index.php last;
    }
}
```

示例：

```nginx
server {
     listen 80;
     server_name localhost;
     location / {
         root /Users/gavin/www/local/SimpleF/www;
         index index.html index.htm index.php;
         if (!-e $request_filename) {
             rewrite ^(.*)$ /index.php last;
         }
     }
     location ~ \.php$ {
             root /Users/gavin/www/local/SimpleF/www;
             fastcgi_pass 127.0.0.1:9000;
             fastcgi_index index.php;
             fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
             include fastcgi_params;
     }
 }
```