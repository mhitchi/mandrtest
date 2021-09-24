// Include gulp
const gulp = require('gulp');

// Include Our Plugins
const autoprefixer = require('autoprefixer');
const bourbon = require('bourbon').includePaths;
const babel = require('gulp-babel');
const jshint = require('gulp-jshint');
const sass = require('gulp-sass');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');
const minifycss = require('gulp-clean-css');
const postcss = require('gulp-postcss');
const pxtorem = require('postcss-pxtorem');

// Lint Task
function lintScripts() {
    return gulp
        .src([
            'assets/js/src/custom-scripts.js',
            'assets/js/src/custom-menu-new.js',
            'assets/js/src/custom-footer.js',
            'template-parts/modules/**/assets/js/*.js',
        ])
        .pipe(
            jshint({
                asi: true,
                expr: true,
                esnext: true,
                sub: true,
                eqnull: true,
                multistr: true,
                laxbreak: true,
            })
        )
        .pipe(jshint.reporter('default'));
}

// Compile Our CSS
sass.compiler = require('node-sass');

function compileSass() {
    return gulp
        .src(['assets/scss/*.scss', 'template-parts/modules/*.scss'], { sourcemaps: false })
        .pipe(
            sass({
                outputStyle: 'expanded',
                sourceComments: true,
                precision: 10,
                includePaths: bourbon,
            }).on('error', sass.logError)
        )
        .pipe(postcss(processors))
        .pipe(minifycss({ compatibility: 'ie8' }))
        .pipe(gulp.dest('./', { sourcemaps: false }));
}

// Post CSS options
const processors = [
    autoprefixer({
        overrideBrowserslist: ['last 2 versions', 'ie > 8'],
    }),
    pxtorem({
        root_value: 10,
        prop_white_list: [],
        replace: false,
    }),
];

// Concatenate & Minify JS
function compileScripts() {
    return (
        gulp
            .src(
                [
                    'assets/js/src/modernizr.js',
                    'assets/js/src/jquery.easing.1.3.js',
                    'assets/js/src/jquery.ba-throttle-debounce.js',
                    'assets/js/src/respimage.js',
                    'assets/js/src/firefox.picturefill.js',
                    'assets/js/src/superfish.js',
                    'assets/js/src/jquery.hoverIntent.js',
                    'assets/js/src/slick.js',
                    'assets/js/src/magnific.js',
                    'assets/js/src/focus-visible.js',
                    'assets/js/src/cookies.js',
                    'assets/js/src/custom-scripts.js',
                ],
                { sourcemaps: false }
            )
            .pipe(concat('all.js'))
            .pipe(rename('all.min.js'))
            .pipe(uglify())
            .pipe(gulp.dest('assets/js', { sourcemaps: false }))
    );
}

// Concatenate & minify JS for footer
function compileFooterScripts() {
    return (
        gulp
            .src(
                [
                    'assets/js/src/custom-footer.js', 
                    'assets/js/src/custom-menu-new.js',
                    'template-parts/modules/**/assets/js/*.js'
                ],
                { sourcemaps: false }
            )
            .pipe(babel({ presets: ['@babel/env'] }))
            .pipe(concat('ftr.js'))
            .pipe(rename('ftr.min.js'))
            .pipe(uglify())
            .pipe(gulp.dest('assets/js', { sourcemaps: false }))
    );
}

// Watch Files For Changes
function watch() {
    gulp.watch('assets/js/src/*.js', lintScripts);
    gulp.watch(
        [
            'assets/js/src/*.js',
            '!assets/js/src/custom-footer.js',
            '!assets/js/src/custom-menu-full.js',
            '!assets/js/src/custom-menu-new.js',
        ],
        compileScripts
    );
    gulp.watch(
        [
            'assets/js/src/custom-footer.js',
            'assets/js/src/custom-menu-new.js',
            'template-parts/modules/**/assets/js/*.js'
        ], 
        compileFooterScripts
    );
    gulp.watch(['assets/scss/**/**/**/*.scss', 'template-parts/modules/**/assets/scss/*.scss'], compileSass);
}

exports.watch = watch;
exports.js = compileScripts;
exports.sass = compileSass;

gulp.task('default', watch);
