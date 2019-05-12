lock '3.11.0'

set :application, 'LaravelVueJs' 
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


# Which roles to consider as laravel roles
set :laravel_roles, :all

# The artisan flags to include on artisan commands by default
set :laravel_artisan_flags, "--env=#{fetch(:stage)}"

# Which roles to use for running migrations
set :laravel_migration_roles, :all

# The artisan flags to include on artisan commands by default when running migrations
set :laravel_migration_artisan_flags, "--force --env=#{fetch(:stage)}"

# The version of laravel being deployed
set :laravel_version, 5.7

# Whether to upload the dotenv file on deploy
set :laravel_upload_dotenv_file_on_deploy, true

# Which dotenv file to transfer to the server
set :laravel_dotenv_file, './../config/dev/.env'

# The user that the server is running under (used for ACLs)
set :laravel_server_user, "#{fetch(:user)}"

# Ensure the dirs in :linked_dirs exist?
set :laravel_ensure_linked_dirs_exist, true

# Link the directores in laravel_linked_dirs?
set :laravel_set_linked_dirs, true

# Linked directories for a standard Laravel 5 application
set :laravel_5_linked_dirs, [ 'storage' ]


# Paths that should have ACLs set for a standard Laravel 5 application
set :laravel_5_acl_paths, [
  'bootstrap/cache',
  'storage',
  'storage/app',
  'storage/app/public',
  'storage/framework',
  'storage/framework/cache',
  'storage/framework/sessions',
  'storage/framework/views',
  'storage/logs' ]

# Ensure the paths in :file_permissions_paths exist?
set :laravel_ensure_acl_paths_exist, true

# Set ACLs for the paths in laravel_acl_paths?
set :laravel_set_acl_paths, true

# Run the database migrations. invoke 'laravel:migrate'


namespace :conf do
  task :update do
    on roles(:server) do
        upload! "../config/dev/.env" , "#{fetch(:deploy_to)}/shared/.env"
        upload! "../config/dev/front/.env" , "#{fetch(:deploy_to)}/shared/front/.env"
    end
  end end

namespace :nginx do
 task :htpasswd do
   on roles(:server) do
     upload! "../ops/nginx/.htpasswd", "#{fetch(:deploy_to)}/.htpasswd"
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
       upload! "../ops/nginx/sites-available/#{fetch(:env)}.laravel-vuejs.com.conf", "/etc/nginx/sites-available/#{fetch(:env)}.laravel-vuejs.com.conf"
   end
 end end

namespace :php do
  task :restart do
    on roles(:server) do
      print "Restaring php fpm..."
      execute "sudo service php7.2-fpm restart"
    end
  end end

namespace :app do
  task :build do
    on roles(:server) do
      within release_path do
        execute "cd #{release_path}/back && composer install --prefer-dist --no-interaction --optimize-autoloader"
        #execute "chmod 777 -R #{release_path}/storage" execute "cd #{release_path}/back && php artisan migrate:fresh --seed"
        execute "cd #{release_path}/back && php artisan migrate"
        execute "cd #{release_path}/back && php artisan storage:link"
      end
    end
  end
  task :symlink do
      on roles(:server) do
        within release_path do
          #execute "ln -nfs #{fetch(:deploy_to)}/static/storage #{release_path}" execute "chmod 777 -R #{fetch(:deploy_to)}/static/storage" execute "chmod 777 -R #{release_path}/storage"
        end
      end
  end
  task :done do
      on roles(:server) do
        print "Done by username #{fetch(:user)} :D"
      end
  end end

namespace :npm do
  task :install do
    on roles(:server) do
        execute "cd #{release_path}/back && npm install"
        execute "cd #{release_path}/front && npm install"
    end
  end
  task :build do
    on roles(:server) do
        execute "cd #{release_path}/back && npm run dev"
        execute "cd #{release_path}/front && npm run build"
    end
  end end



namespace :pm2 do
  task :conf do
    on roles(:server) do
        upload! "../ops/pm2/#{fetch(:env)}-ecosystem.json" , "#{release_path}/front/#{fetch(:env)}-ecosystem.json"
    end
  end
  task :list do
    on roles(:server) do
      execute "pm2 list"
    end
  end
  task :reload do
    on roles(:server) do
      execute "pm2 reload laravel-vuejs-#{fetch(:env)}"
    end
  end
  task :start do
    on roles(:server) do
      execute "cd #{release_path}/front && pm2 start npm #{fetch(:env)}-ecosystem.json --name laravel-vuejs-#{fetch(:env)} -- start"
    end
  end
  task :delete do
    on roles(:server) do
      execute "pm2 delete laravel-vuejs-#{fetch(:env)}"
    end
  end end


#set :slackistrano, {
#  klass: Slackistrano::CustomMessaging, channel: '#deploy', webhook: 'https://hooks.slack.com/services/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'
#}

#after "composer:run", "app:build"

after "composer:run", "app:symlink"

after "composer:run", "npm:install" 

after "npm:install", "npm:build"

#after "composer:run", "nginx:restart" 

#after "composer:run", "php:restart"

after "deploy:finished", "pm2:conf" 
after "pm2:conf", "pm2:delete" 
after "pm2:delete", "pm2:start"

after "deploy:finished", "app:done"
