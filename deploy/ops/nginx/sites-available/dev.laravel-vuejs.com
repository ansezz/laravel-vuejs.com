map $sent_http_content_type $expires {
    "text/html"                 epoch;
    "text/html; charset=utf-8"  epoch;
    default                     off;
}


server {
    server_name .dev.laravel-vuejs.com;
    root "/var/www/laravel-vuejs/domains/dev.laravel-vuejs.com/public_html/current/htdocs";

    index index.html index.htm index.php;

    charset utf-8;
    gzip            on;
    gzip_types      text/plain application/xml text/css application/javascript;
    gzip_min_length 1000;

    #catch cms admin
        location /cms {
            try_files $uri $uri/ /index.php?$query_string;
        }

        location /content {
            try_files $uri $uri/ /index.php?$query_string;
        }

    #catch nuxt application
    location / {
        auth_basic "Restricted";
        auth_basic_user_file /etc/nginx/.htpasswd;
        expires $expires;

        proxy_redirect                      off;
        proxy_set_header Host               $host;
        proxy_set_header X-Real-IP          $remote_addr;
        proxy_set_header X-Forwarded-For    $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto  $scheme;
        proxy_read_timeout          1m;
        proxy_connect_timeout       1m;
        proxy_pass                          http://127.0.0.1:3000; # set the adress of the Node.js instance here
    }


    location /api {
        auth_basic Off;
        client_max_body_size    2000m;
        client_body_buffer_size 512k;
        try_files $uri $uri/ /index.php?$args;
    }


    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    access_log off;
    error_log  /var/log/nginx/dev.laravel-vuejs.com-error.log error;

    sendfile off;

    client_max_body_size 100m;
    location ~ \.php$ {
            fastcgi_split_path_info ^(.+\.php)(/.+)$;
            fastcgi_pass unix:/var/run/php/php7.0-fpm.sock;
            fastcgi_index index.php;
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;


            fastcgi_intercept_errors off;
            fastcgi_buffer_size 16k;
            fastcgi_buffers 4 16k;
            fastcgi_connect_timeout 300;
            fastcgi_send_timeout 300;
            fastcgi_read_timeout 300;
        }

        location ~ /\.ht {
            deny all;
        }


        listen 443 ssl http2; # managed by Certbot
        ssl_certificate /etc/letsencrypt/live/dev.laravel-vuejs.com/fullchain.pem; # managed by Certbot
        ssl_certificate_key /etc/letsencrypt/live/dev.laravel-vuejs.com/privkey.pem; # managed by Certbot
        include /etc/letsencrypt/options-ssl-nginx.conf; # managed by Certbot
        ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem; # managed by Certbot

    }



server {
    if ($host = dev.laravel-vuejs.com) {
        return 301 https://$host$request_uri;
    } # managed by Certbot


    listen 80;
    server_name .dev.laravel-vuejs.com;
    return 404; # managed by Certbot

}



