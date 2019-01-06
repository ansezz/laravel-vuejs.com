
#set :user, "#{`whoami`.strip}"

set :user, "laravel-vuejs"

set :username, "laravel-vuejs"

set :branch, "master"

set :domain, "newdev.laravel-vuejs.com"

server '207.180.198.220', user: fetch(:user), roles: %w{app}

role :server, %w{207.180.198.220}

set :deploy_to, "/home/#{fetch(:username)}/domains/#{fetch(:domain)}/public_html"

set :tmp_dir, "/home/#{fetch(:username)}/tmp"

set :linked_files, %w{back/.env front/.env }
