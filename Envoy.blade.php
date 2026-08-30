@servers(['production' => ['cem@pluto.tail9b22d0.ts.net']])

@setup
    $repository = 'git@github.com:raicem/ancient-cities-turkey.git';
    $appDirectory = '/var/www/ancientcitiesturkey.com/public';
    $branch = 'master';
@endsetup

@story('deploy', ['on' => 'production'])
    pull_code
    install_php_dependencies
    clear_application_cache
    install_node_dependencies
    build_frontend_assets
    run_migrations
    generate_sitemap
    cache_application
@endstory

@task('pull_code')
    if [ -d "{{ $appDirectory }}/.git" ]; then
        cd "{{ $appDirectory }}"
        git fetch origin
        git checkout "{{ $branch }}"
        git pull --ff-only origin "{{ $branch }}"
    else
        git clone --branch="{{ $branch }}" "{{ $repository }}" "{{ $appDirectory }}"
    fi
@endtask

@task('install_php_dependencies')
    cd "{{ $appDirectory }}"

    if [ -f "$HOME/bin/composer.phar" ]; then
        composer="php $HOME/bin/composer.phar"
    else
        composer=composer
    fi

    $composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader
@endtask

@task('clear_application_cache')
    cd "{{ $appDirectory }}"
    php artisan optimize:clear
@endtask

@task('install_node_dependencies')
    cd "{{ $appDirectory }}"

    if ! command -v npm >/dev/null 2>&1; then
        export NVM_DIR="$HOME/.nvm"

        if [ -s "$NVM_DIR/nvm.sh" ]; then
            . "$NVM_DIR/nvm.sh"
            nvm use --silent default >/dev/null 2>&1 || true
        fi
    fi

    if ! command -v npm >/dev/null 2>&1; then
        echo "npm is not available in PATH. Install Node system-wide or configure nvm for non-interactive shells."
        exit 1
    fi

    if [ -f "package-lock.json" ]; then
        npm ci --no-audit --no-fund
    else
        npm install --no-audit --no-fund
    fi
@endtask

@task('build_frontend_assets')
    cd "{{ $appDirectory }}"

    if ! command -v npm >/dev/null 2>&1; then
        export NVM_DIR="$HOME/.nvm"

        if [ -s "$NVM_DIR/nvm.sh" ]; then
            . "$NVM_DIR/nvm.sh"
            nvm use --silent default >/dev/null 2>&1 || true
        fi
    fi

    if ! command -v npm >/dev/null 2>&1; then
        echo "npm is not available in PATH. Install Node system-wide or configure nvm for non-interactive shells."
        exit 1
    fi

    npm run build
@endtask

@task('run_migrations')
    cd "{{ $appDirectory }}"
    php artisan migrate --force
@endtask

@task('generate_sitemap')
    cd "{{ $appDirectory }}"
    php artisan sitemap:generate
@endtask

@task('cache_application')
    cd "{{ $appDirectory }}"
    php artisan optimize
@endtask
