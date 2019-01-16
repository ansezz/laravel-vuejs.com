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

set :keep_releases, 2

namespace :conf do
  task :update do
    on roles(:server) do
        upload! "../config/dev/back/.env" , "/home/#{fetch(:username)}/domains/#{fetch(:domain)}/public_html/shared/back/.env"
        upload! "../config/dev/front/.env" , "/home/#{fetch(:username)}/domains/#{fetch(:domain)}/public_html/shared/front/.env"
    end
  end
end

namespace :nginx do
 task :htpasswd do
   on roles(:server) do
     upload! "../ops/nginx/.htpasswd", "/home/#{fetch(:username)}/domains/#{fetch(:domain)}/public_html/.htpasswd"
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
       #upload! "../ops/nginx/sites-available/dev.laravel-vuejs.com", "/etc/nginx/sites-available/dev.laravel-vuejs.com"
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
        execute "cd #{release_path}/back && composer install --prefer-dist --no-interaction --optimize-autoloader && npm install && npm run dev"
        execute "cd #{release_path}/back/nova-components/nova-categories-field && composer install --prefer-dist --no-interaction --optimize-autoloader && npm install && npm run dev"
        execute "cd #{release_path}/back/nova-components/WpImporter && composer install --prefer-dist --no-interaction --optimize-autoloader && npm install && npm run dev"
        execute "chmod 777 -R #{release_path}/back/storage"
        execute "cd #{release_path}/back && php artisan migrate:fresh --seed"
        execute "cd #{release_path}/back && php artisan storage:link"
      end
    end
  end
  task :symlink do
      on roles(:server) do
        within release_path do
          #execute "ln -nfs /home/#{fetch(:username)}/domains/#{fetch(:domain)}/public_html/static/storage #{release_path}/back"
          execute "chmod 777 -R /home/#{fetch(:username)}/domains/#{fetch(:domain)}/public_html/static/storage"
          execute "chmod 777 -R #{release_path}/back/storage"
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
        #execute "cd #{release_path}/front && npm install"
    end
  end
  task :build do
    on roles(:server) do
        #execute "cd #{release_path}/front && npm run generate"
    end
  end
end

namespace :pm2 do
  task :conf do
    on roles(:server) do
        upload! "../ops/pm2/dev-ecosystem.json" , "#{release_path}/htdocs/content/themes/laravel-vuejs/front/dev-ecosystem.json"
    end
  end
  task :list do
    on roles(:server) do
      execute "pm2 list"
    end
  end
  task :reload do
    on roles(:server) do
      execute "pm2 reload laravel-vuejs-dev"
    end
  end
  task :start do
    on roles(:server) do
      execute "cd #{release_path}/htdocs/content/themes/laravel-vuejs/front && pm2 start npm dev-ecosystem.json --name laravel-vuejs-dev -- start"
    end
  end
  task :delete do
    on roles(:server) do
      execute "pm2 delete laravel-vuejs-dev"
    end
  end
end


after "deploy:updating", "app:build"
after "app:build", "app:symlink"

after "deploy:updating", "npm:install"
after "npm:install", "npm:build"

#after "npm:build", "pm2:conf"

#after "deploy:finished", "nginx:restart"
#after "deploy:finished", "php:restart"

#after "deploy:finished", "pm2:reload"
#after "deploy:finished", "pm2:delete"
#after "deploy:finished", "pm2:start"

after "deploy:finished", "app:done"
