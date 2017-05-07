const gulp = require('gulp');

const sass = require('gulp-sass');

const browserify = require('browserify');
const babelify = require('babelify');
const source = require('vinyl-source-stream');
const buffer = require('vinyl-buffer');
const babel = require('gulp-babel');

const sourcemaps = require('gulp-sourcemaps');
const gutil = require('gulp-util');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');
const del = require('del');

const DIRS = {
    Develop: './develop',
    Deploy: './deploy'
};

const BABEL_PRESETS = [
    [ 'env', {
        'targets': {
            'browsers': [ 'last 2 versions', 'safari >= 7' ]
        }
    } ],
    'es2016',
    'es2017'
];


// -------------------- JS --------------------
gulp.task('js:cleanup', () => del([ `${DIRS.Deploy}/*.js*` ]));

gulp.task('js', [ 'js:cleanup' ], () => browserify({
        entries: [ `${DIRS.Develop}/js/index.js` ],
        debug: true
    })
        .transform('babelify', {
            presets: BABEL_PRESETS
        })
        .bundle()
        .pipe(source(`${DIRS.Develop}/js/index.js`, `${DIRS.Develop}/js/`))
        .pipe(buffer())
        .pipe(rename(`script.js`))
        .pipe(sourcemaps.init({ loadMaps: true }))
        // .pipe(uglify())
        // .on('error', gutil.log)
        .pipe(sourcemaps.write(`./`))
        .pipe(gulp.dest(`${DIRS.Deploy}/`))
);

gulp.task('js:watch', () => {
    gulp.watch([ `${DIRS.Develop}/js/**` ], [ 'js' ]);
});


// -------------------- CSS --------------------
gulp.task('css:cleanup', () => del([ `${DIRS.Deploy}/*.css*` ]));

gulp.task('css', [ 'css:cleanup' ], () => gulp
    .src(`${DIRS.Develop}/css/index.scss`, { base: `${DIRS.Develop}/css/` })
    .pipe(rename(`style.css`))
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(`${DIRS.Deploy}/`))
);

gulp.task('css:watch', () => {
    gulp.watch(`${DIRS.Develop}/css/**`, [ 'css' ]);
});


// -------------------- SERVICE --------------------
gulp.task('cleanup', () => {
    del.sync([
        `${DIRS.Deploy}/**`,
        // ignore following
        `!${DIRS.Deploy}`,
        `!${DIRS.Deploy}/.gitignore`,
        `!${DIRS.Deploy}/.htaccess`,
        `!${DIRS.Deploy}/php`,
        `!${DIRS.Deploy}/php/fb-token.txt`,
        `!${DIRS.Deploy}/php/fb-content.json`
    ]);
});

gulp.task('static:copy', () => gulp
    .src([
        // `${__dirname}/.htaccess`, // Why the fuck this does not work?
        `${DIRS.Develop}/*.php`,
        `${DIRS.Develop}/php/**/*`,
        `${DIRS.Develop}/content/**/*`,
        `${DIRS.Develop}/gfx/**/*`,
    ], { base: `${DIRS.Develop}` })
    .pipe(gulp.dest(`${DIRS.Deploy}`))
);

gulp.task('static:watch', () => {
    gulp.watch([
            `${DIRS.Develop}/**`,
            // ignore following
            `!${DIRS.Develop}/js/**`,
            `!${DIRS.Develop}/css/**`
        ],
        [ 'static:copy' ]
    );
});


// -------------------- DEFAULT --------------------
gulp.task('dev', [ 'cleanup', 'static:copy', 'js', 'css', 'js:watch', 'css:watch', 'static:watch' ]);
