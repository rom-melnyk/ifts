const gulp = require('gulp');

const sass = require('gulp-sass');

const browserify = require('browserify');
const babelify = require('babelify');
const source = require('vinyl-source-stream');
const buffer = require('vinyl-buffer');
const babel = require('gulp-babel');

const sourcemaps = require('gulp-sourcemaps');
const gutil = require('gulp-util');
const uglifyJs = require('gulp-uglify');
const cleanCss = require('gulp-clean-css');
const rename = require('gulp-rename');
const del = require('del');

const DIRS = {
    Develop: './develop',
    Deploy: './deploy'
};

let isProduction = false;

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
gulp.task('js:cleanup', () => {
    del([ `${DIRS.Deploy}/*.js*` ]);
});

gulp.task('js', [ 'js:cleanup' ], () => {
    let flow = browserify({
            entries: [ `${DIRS.Develop}/js/index.js` ],
            debug: true
        })
        .transform('babelify', {
            presets: BABEL_PRESETS
        })
        .bundle()
        .on('error', logJsError)
        .pipe(source(`${DIRS.Develop}/js/index.js`, `${DIRS.Develop}/js/`))
        .pipe(buffer())
        .pipe(rename(`script.js`));

    if (isProduction) {
        flow = flow
            .pipe(uglifyJs())
            .on('error', gutil.log);
    } else {
        flow = flow
            .pipe(sourcemaps.init({ loadMaps: true }))
            .pipe(sourcemaps.write(`./`));
    }

    flow.pipe(gulp.dest(`${DIRS.Deploy}/`));
});

gulp.task('js:watch', () => {
    gulp.watch([ `${DIRS.Develop}/js/**` ], [ 'js' ]);
});


// -------------------- CSS --------------------
gulp.task('css:cleanup', () => {
    del([ `${DIRS.Deploy}/*.css*` ]);
});

gulp.task('css', [ 'css:cleanup' ], () => {
    let flow = gulp
        .src(`${DIRS.Develop}/css/index.scss`, { base: `${DIRS.Develop}/css/` })
        .pipe(rename(`style.css`));

    if (!isProduction) {
        flow = flow.pipe(sourcemaps.init());
    }

    flow = flow.pipe(sass().on('error', sass.logError));

    if (!isProduction) {
        flow = flow.pipe(sourcemaps.write('./'));
    } else {
        flow = flow
            .pipe(cleanCss())
            .on('error', gutil.log);
    }

    flow.pipe(gulp.dest(`${DIRS.Deploy}/`));
});

gulp.task('css:watch', () => {
    gulp.watch(`${DIRS.Develop}/css/**`, [ 'css' ]);
});


// -------------------- SERVICE --------------------
gulp.task('mark-as-prod', () => {
    isProduction = true;
});

gulp.task('cleanup', () => {
    del.sync([
        `${DIRS.Deploy}/**`,
        // ignore following
        `!${DIRS.Deploy}`,
        `!${DIRS.Deploy}/.gitignore`,
        `!${DIRS.Deploy}/.htaccess`,
        `!${DIRS.Deploy}/fb-cache`,
        `!${DIRS.Deploy}/fb-cache/**/*`
    ]);
});

gulp.task('static:copy', () => {
    gulp
        .src(
            [
                // `${__dirname}/.htaccess`, // Why the fuck this does not work?
                `${DIRS.Develop}/*.php`,
                `${DIRS.Develop}/php/**/*`,
                `${DIRS.Develop}/fb-cache/.gitignore`, // otherwise folder is not copied
                `${DIRS.Develop}/content/**/*`,
                `${DIRS.Develop}/gfx/**/*`,
            ],
            { base: `${DIRS.Develop}` }
        ).pipe(gulp.dest(`${DIRS.Deploy}`))
});

gulp.task('static:copy-prod', () => {
    gulp
        .src(
            [
                `${DIRS.Develop}/sitemap.xml`,
                `${DIRS.Develop}/robots.txt`
            ],
            { base: `${DIRS.Develop}` }
        ).pipe(gulp.dest(`${DIRS.Deploy}`))
});

gulp.task('static:watch', () => {
    gulp
        .watch(
            [
                `${DIRS.Develop}/**`,
                // ignore following
                `!${DIRS.Develop}/js/**`,
                `!${DIRS.Develop}/css/**`
            ],
            [ 'static:copy' ]
        );
});


// -------------------- helpers --------------------
function logJsError(err) {
    if (err.fileName) {
        // regular error
        gutil.log(
            gutil.colors.red(err.name),
            gutil.colors.yellow(err.fileName),
            `at ${err.lineNumber}:${(err.columnNumber || err.column)}`,
            err.description
        );
    } else {
        // browserify error
        gutil.log(`${err.name}: ${err.message}`);
    }

    this.emit('end'); // `this` is browserify instance
}


// -------------------- DEFAULT --------------------
gulp.task('dev', [ 'cleanup', 'static:copy', 'js', 'css', 'js:watch', 'css:watch', 'static:watch' ]);
gulp.task('prod', [ 'mark-as-prod', 'cleanup', 'static:copy', 'static:copy-prod', 'js', 'css' ]);
