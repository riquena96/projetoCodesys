var elixir = require('laravel-elixir'),
        liveReload = require('gulp-livereload'),
        clean = require('rimraf'),
        gulp = require('gulp');

/*configurando ambiente de desenvolvimento e Produção */
var config = {
    assets_path: './resources/assets',
    build_path: './public/build'
};

config.bower_path = config.assets_path + '/../bower_components';

/*definindo o caminho do js da pasta PUBLIC */
config.build_path_js = config.build_path + '/js';
/*definindo o caminho do js da pasta vendor */
config.build_vendor_path_js = config.build_path_js + '/vendor';
/*definindo biblioteca JS de terceiros */
config.vendor_path_js = [
    config.bower_path + '/jquery/dist/jquery.min.js',
    config.bower_path + '/bootstrap/dist/js/bootstrap.min.js',
    config.bower_path + '/angular/angular.min.js',
    config.bower_path + '/angular-route/angular-route.min.js',
    config.bower_path + '/angular-resource/angular-resource.min.js',
    config.bower_path + '/angular-animate/angular-animate.min.js',
    config.bower_path + '/angular-messages/angular-messages.min.js',
    config.bower_path + '/angular-bootstrap/ui-bootstrap-tpls.min.js',
    config.bower_path + '/angular-strap/dist/modules/navbar.min.js',
    config.bower_path + '/angular-cookies/angular-cookies.min.js',
    config.bower_path + '/query-string/query-string.js',
    config.bower_path + '/angular-oauth2/dist/angular-oauth2.min.js',
    config.bower_path + '/ng-file-upload/ng-file-upload.min.js',
    config.bower_path + '/angular-http-auth/src/http-auth-interceptor.js',
    config.bower_path + '/angularUtils-pagination/dirPagination.js',
    config.bower_path + '/pusher/dist/pusher.min.js',
    config.bower_path + '/pusher-angular/lib/pusher-angular.min.js',
    config.bower_path + '/angular-ui-notification/dist/angular-ui-notification.min.js',
];

config.bower_path = config.assets_path + '/../bower_components';

/*definindo o caminho do css da pasta PUBLIC */
config.build_path_css = config.build_path + '/css';
/*definindo o caminho do css da pasta vendor */
config.build_vendor_path_css = config.build_path_css + '/vendor';
/*definindo biblioteca CSS de terceiros */
config.vendor_path_css = [
    config.bower_path + '/bootstrap/dist/css/bootstrap.min.css',
    config.bower_path + '/bootstrap/dist/css/bootstrap-theme.min.css',
    config.bower_path + '/jquery/dist/jquery.min.css',
    config.bower_path + '/angular-ui-notification/dist/angular-ui-notification.min.css',
];

/*definindo o caminho do html da pasta PUBLIC */
config.build_path_html = config.build_path + '/views';

/*definindo o caminho das fonts da pasta PUBLIC */
config.build_path_font = config.build_path + '/fonts';

/*definindo o caminho das imagens da pasta PUBLIC */
config.build_path_image = config.build_path + '/images';

/* definir a tarefa para copiar as fonts */
gulp.task('copy-font', function(){
    // indicando as fonts que quero copiar
    gulp.src([
        config.assets_path + '/fonts/**/*'
    ])
    //copiar para build_path_html
        .pipe(gulp.dest(config.build_path_font))
        .pipe(liveReload());
});

/* definir a tarefa para copiar as imagens */
gulp.task('copy-image', function(){
    // indicando as imagens que quero copiar
    gulp.src([
        config.assets_path + '/images/**/*'
    ])
    //copiar para build_path_html
        .pipe(gulp.dest(config.build_path_image))
        .pipe(liveReload());
});

/* definir a tarefa para copiar os htmls */
gulp.task('copy-html', function(){
    // indicando os htmls que quero copiar
    gulp.src([
        config.assets_path + '/js/views/**/*.html'
    ])
            //copiar para build_path_html
            .pipe(gulp.dest(config.build_path_html))
            .pipe(liveReload());
});

/* definir a tarefa para copiar os estilos */
gulp.task('copy-styles', function () {

    // indicando os css que quero copiar
    gulp.src([
        config.assets_path + '/css/**/*.css'
    ])
            //copiar para build_path_css
            .pipe(gulp.dest(config.build_path_css))
            .pipe(liveReload());

    // indicando os css de terceiros que quero copiar
    gulp.src(config.vendor_path_css)
            //copiar para build_vendor_path_css
            .pipe(gulp.dest(config.build_vendor_path_css))
            .pipe(liveReload());
});

/* definir a tarefa para copiar os scripts */
gulp.task('copy-scripts', function () {
    // indicando os js que quero copiar
    gulp.src([
        config.assets_path + '/js/**/*.js'
    ])
            //copiar para build_path_js
            .pipe(gulp.dest(config.build_path_js))
            .pipe(liveReload());

    // indicando os css de terceiros que quero copiar
    gulp.src(config.vendor_path_js)
            //copiar para vendor_path_js
            .pipe(gulp.dest(config.build_vendor_path_js))
            .pipe(liveReload());
});

//criar a rotina para limpar os arquivos alterados para que possa ser copiados novamente
gulp.task('clear-build-folder', function () {
    clean.sync(config.build_path);
});

// criando o comando default do gulp
gulp.task('default', ['clear-build-folder'], function () {
    gulp.start('copy-html', 'copy-font', 'copy-image');
    elixir(function (mix) {
        mix.styles(config.vendor_path_css.concat([config.assets_path + '/css/**/*.css']),
        'public/css/all.css', config.assets_path);
        mix.scripts(config.vendor_path_js.concat([config.assets_path + '/js/**/*.js']),
        'public/js/all.js', config.assets_path);
        mix.version(['js/all.js', 'css/all.css']);
    });
});

//criando a rotina para assistir as alterações e copiar os arquivos alterados
gulp.task('watch-dev', ['clear-build-folder'], function () {
    liveReload.listen();
    gulp.start('copy-styles', 'copy-scripts', 'copy-html', 'copy-font', 'copy-image');
    gulp.watch(config.assets_path + '/**', [
        'copy-styles', 'copy-scripts', 'copy-html'
    ]);
});