lock '3.11.0'

set :application, 'app'
set :repo_url, 'git@github.com:ansezz/laravel-vuejs.com.git'
set :branch, '#{fetch(:branch)}'

set :format, :pretty
set :log_level, :debug
set :pty, true

set :ssh_options, {
#    verify_host_key: :never,
    port: 22
}

set :keep_releases, 3

namespace :conf do
  task :update do
    on roles(:server) do
        upload! "../config/dev/.env" , "/var/www/#{fetch(:username)}/domains/#{fetch(:domain)}/public_html/shared/.env"
    end
  end
end

namespace :nginx do
 task :htpasswd do
   on roles(:server) do
     upload! "../ops/nginx/.htpasswd", "/etc/nginx/.htpasswd"
   end
 end
 task :restart do
  on roles(:server) do
    print "Restaring nginx..."
    execute "sudo service nginx restart"
  end
 end
 task :reload do
  on roles(:server) do
    print "reload nginx..."
    execute "sudo /usr/sbin/service nginx reload"
  end
 end
 task :vhosts do
   on roles(:server) do
     if fetch(:stage) == :dev
       upload! "../ops/nginx/sites-available/dev.laravel-vuejs.com", "/etc/nginx/sites-available/dev.laravel-vuejs.com"
     elsif fetch(:stage) == :prod
       #upload! "../ops/nginx/sites-enabled/static.conf", "/etc/nginx/sites-enabled/static.conf"
     end
   end
 end
end

namespace :php do
  task :restart do
    on roles(:server) do
      print "Restaring php fpm..."
      execute "sudo service php7.0-fpm restart"
    end
  end
end

namespace :app do
  task :build do
    on roles(:server) do
      within release_path do
        execute "cd #{release_path} && composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader"
      end
    end
  end
  task :symlink do
      on roles(:server) do
        within release_path do
          execute "ln -nfs /var/www/#{fetch(:username)}/domains/#{fetch(:domain)}/public_html/static/uploads #{release_path}/htdocs/content/uploads"
        end
      end
  end
  task :done do
      on roles(:server) do
        print "Done by username #{fetch(:username)} on #{fetch(:domain)} :D"
      end
  end
end

namespace :npm do
  task :install do
    on roles(:server) do
        execute "cd #{release_path}/htdocs/content/themes/laravel-vuejs/front && npm install"
    end
  end
  task :build do
    on roles(:server) do
        execute "cd #{release_path}/htdocs/content/themes/laravel-vuejs/front && npm run build"
    end
  end
end

namespace :pm2 do
  task :conf do
    on roles(:server) do
        upload! "../ops/pm2/dev-ecosystem.json" , "/var/www/#{fetch(:username)}/domains/#{fetch(:domain)}/public_html/shared/dev-ecosystem.json"
    end
  end
  task :start do
    on roles(:server) do
        execute "pm2 startOrRestart /var/www/laravel-vuejs/domains/dev.laravel-vuejs.com/public_html/shared/ecosystem.json"
    end
  end
end


after "deploy:updating", "app:build"
after "app:build", "app:symlink"

after "deploy:updating", "npm:install"
after "npm:install", "npm:build"

after "npm:build", "pm2:conf"
after "pm2:conf", "pm2:start"

after "deploy:finished", "nginx:restart"
after "deploy:finished", "php:restart"
after "deploy:finished", "app:done"
