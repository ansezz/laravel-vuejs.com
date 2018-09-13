
#set :user, "#{`whoami`.strip}"

set :user, "root"

set :username, "laravel-vuejs"

set :branch, "master"

set :domain, "dev.laravel-vuejs.com"

server '209.97.189.26', user: fetch(:user), roles: %w{app}

role :server, %w{209.97.189.26}

set :deploy_to, "/var/www/#{fetch(:username)}/domains/#{fetch(:domain)}/public_html"

set :tmp_dir, "/var/www/#{fetch(:username)}/tmp"

set :linked_files, %w{.env htdocs/content/themes/laravel-vuejs/front/.env}
