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

namespace :httpd do
  task :htaccess do
    on roles(:server) do
        upload! "../config/#{fetch(:stage)}/.htaccess" , "/home/#{fetch(:user)}/domains/#{fetch(:domain)}/public_html/shared/.htaccess"
    end
  end
  task :htpasswd do
     on roles(:server) do
       upload! "../config/#{fetch(:stage)}/.htpasswd", "/home/#{fetch(:user)}/domains/#{fetch(:domain)}/public_html/shared/.htpasswd"
     end
  end
  task :restart do
    on roles(:server) do
      print "Restaring httpd..."
      execute "sudo service httpd restart"
    end
  end
end

namespace :conf do
  task :update do
    on roles(:server) do
        upload! "../config/dev/.env" , "/home/#{fetch(:user)}/domains/#{fetch(:domain)}/public_html/shared/.env"
    end
  end
end

namespace :app do
  task :build do
    on roles(:server) do
      within release_path do
        execute "cd #{release_path} && composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader"
        #execute "cd #{release_path}/htdocs/content/themes/laravel-vuejs && npm i && npm run dev"
      end
    end
  end
  task :symlink do
      on roles(:server) do
        within release_path do
          execute "ln -nfs /home/#{fetch(:user)}/domains/#{fetch(:domain)}/public_html/static/uploads #{release_path}/htdocs/content/uploads"
        end
      end
  end
  task :done do
      on roles(:server) do
        print "Done by user #{fetch(:user)} on #{fetch(:domain)} :D"
      end
  end
end

before 'deploy:started', 'httpd:htaccess'
before 'deploy:started', 'httpd:htpasswd'
after "deploy:updating", "app:build"
after "app:build", "app:symlink"
#after "app:build", "httpd:restart"
after "deploy:finished", "app:done"
