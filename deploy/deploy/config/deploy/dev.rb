# "Enter you user in the server (:user@server.leventures.com)"
ask(:user, 'root')

# "Enter branch name (develop by default): "
ask(:branch, 'blog')

set :stage, "staging"

set :env, "develop"

server 'dev.laravel-vuejs.com', user: fetch(:user), roles: %w{app}

role :server, %w{dev.laravel-vuejs.com}

set :deploy_to, "/var/www/dev.laravel-vuejs.com/web"

set :linked_files, %w{.env front/.env}
