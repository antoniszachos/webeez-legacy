const gulp = require('gulp');
const browserSync = require('browser-sync').create();
const wpPot = require('gulp-wp-pot');
const gettext = require('gulp-gettext');
const sass = require('gulp-sass')(require('sass'));
const maps = require('gulp-sourcemaps');
const prefix = require('gulp-autoprefixer');
const rename = require('gulp-rename');
const plumber = require('gulp-plumber');
const notify = require('gulp-notify');
const cssnano = require('gulp-cssnano');
const concat = require('gulp-concat');
const terser = require('gulp-terser');
const tinypng = require('gulp-tinypng-compress');
const phpcs = require('gulp-phpcs');
const filter = require('gulp-filter');
const { exec } = require('child_process');
const themePath = './wp-content/themes/webeez/';
const paths = {
    styles: {
        src: themePath + 'assets/src/scss/**/*.scss',
        dest: themePath + 'assets/dist/css/'
    },
	scripts: {
        src: themePath + 'assets/src/js/**/*.js',
        dest: themePath + 'assets/dist/js/'
    },
	images: {
        src: themePath + 'assets/src/img/**/*.{jpg,jpeg,png,gif,svg}',
        dest: themePath + 'assets/dist/img/'
    },
    php: themePath + '**/*.php',
    languages: {
        src: themePath + 'languages/*.po',
        dest: themePath + 'languages/',
        pot: themePath + 'languages/webeez.pot',
		greek: themePath + 'languages/el.po'
    }
};

function serve() {
    browserSync.init({
        proxy: "http://localhost:80",
        host: "0.0.0.0",
        port: 3000,
        open: "external",
        socket: {
            domain: 'bs-legacy.webeez.gr'
        },
        ui: false,
        notify: false,
		cors: true,
        snippetOptions: {
            ignorePaths: ["wp-admin/**", "wp-login.php"]
        },
		proxy: {
            target: "http://localhost:80",
            reqHeaders: function (config) {
                return {
                    "host":            "legacy.webeez.gr",
                    "accept-encoding": "identity",
                    "agent":           false
                }
            }
        }
    });

    gulp.watch(paths.php, gulp.series(phpLint, function(done) {
		browserSync.reload();
		done();
	}));

    gulp.watch(paths.languages.src, gulp.series(compileMo, function(done) {
        setTimeout(() => { browserSync.reload(); done(); }, 500);
    }));

    gulp.watch(paths.styles.src, styles);

	gulp.watch(paths.scripts.src, scripts);

	gulp.watch(paths.images.src, images);

}

function styles() {
    return gulp.src(paths.styles.src)
        .pipe(plumber({ errorHandler: notify.onError("Error: <%= error.message %>") }))
        .pipe(maps.init())
        .pipe(sass({ outputStyle: 'expanded' }).on('error', sass.logError))
        .pipe(prefix())
        .pipe(cssnano())
        .pipe(rename({ suffix: '.min' }))
        .pipe(maps.write('.'))
        .pipe(gulp.dest(paths.styles.dest))
        .pipe(filter('**/*.css'))
        .pipe(browserSync.stream());
}

function lint(cb) {
    console.log('⏳ Checking code quality...');

    const configFile = './.stylelintrc.json';

    const command = `npx stylelint "${paths.styles.src}" --config "${configFile}" --formatter verbose`;

    exec(command, (err, stdout, stderr) => {
        console.log(stdout);
        if (stderr) console.error(stderr);
        cb();
    });
}

function scripts() {
    return gulp.src(paths.scripts.src)
       .pipe(plumber({ errorHandler: notify.onError("Error: <%= error.message %>") }))
        .pipe(maps.init())
        .pipe(concat('bundle.js'))
        .pipe(terser())
        .pipe(rename({ suffix: '.min' }))
        .pipe(maps.write('.'))
        .pipe(gulp.dest(paths.scripts.dest))
		.pipe(filter('**/*.js'))
        .pipe(browserSync.stream());
}

function makePot() {
    return gulp.src(paths.php)
        .pipe(wpPot({ domain: 'webeez', package: 'Webeez Theme' }))
        .pipe(gulp.dest(paths.languages.pot));
}

function updatePo(cb) {
    exec(`wp i18n update-po ${paths.languages.pot} ${paths.languages.greek}`, (err, stdout, stderr) => {
        console.log(stdout || stderr);
        cb(err);
    });
}

function compileMo() {
    return gulp.src(paths.languages.src)
        .pipe(gettext())
        .pipe(gulp.dest(paths.languages.dest));
}

function images() {
    console.log('🐼 Starting TinyPNG compression...');

    return gulp.src(paths.images.src, { encoding: false }) // Σημαντικό για Node 20
        .pipe(plumber({ errorHandler: notify.onError("Error: <%= error.message %>") }))
        .pipe(tinypng({
            key: 'J8LUl2syy5Pv0vuNv7E0XbOwcPoFcmUV',
            sigFile: '.tinypng-sigs',
            log: true
        }))

        .pipe(gulp.dest(paths.images.dest));
}

function phpLint() {
    return gulp.src([paths.php, '!./**/*.min.php'])
        .pipe(plumber({
            errorHandler: function (err) {
                console.error('❌ PHP Lint Error:', err.message);
                this.emit('end');
            }
        }))
        .pipe(phpcs({
            bin: '/root/.composer/vendor/bin/phpcs',
            standard: 'WordPress',
            warningSeverity: 0,
            showSniffCode: true
        }))
        .pipe(phpcs.reporter('log'));
}

exports.styles = styles;
exports.lint = lint;
exports.sync = gulp.series(makePot, updatePo);
exports.scripts = scripts;
exports.default = serve;
exports.images = images;
exports.phpLint = phpLint;
