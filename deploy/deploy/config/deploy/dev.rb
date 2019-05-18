# "Enter you user in the server (:user@server.leventures.com)"
ask(:user, 'root')

# "Enter branch name (develop by default): "
ask(:branch, 'blog')

set :stage, "staging"

set :env, "dev"

server '167.86.113.173', user: fetch(:user), roles: %w{app}

role :server, %w{167.86.113.173}

set :deploy_to, "/var/www/dev.laravel-vuejs.com/web"

set :linked_files, %w{.env front/.env}
