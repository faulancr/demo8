const gulp = require('gulp');
const uglify = require('gulp-uglify');
const pump = require('pump');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const sassdoc = require('sassdoc');

// constiables
const input__scss = './Assets/Sass/**/*.scss';
const project = {
    base: __dirname + '/../Web/typo3conf/ext/ddboilerplate/Resources/Public',
    css: __dirname + '/../Web/typo3conf/ext/ddboilerplate/Resources/Public/Css',
    js: __dirname + '/../Web/typo3conf/ext/ddboilerplate/Resources/Public/JavaScripts'
};

const sassOptions = {
    errLogToConsole: true,
    outputStyle: 'expanded'
};

const autoprefixerOptions = {
    browsers: ['last 2 versions', '> 5%', 'Firefox ESR']
};

const sassdocOptions = {
    dest: 'Documentation/Sass'
};

gulp.task('sass', function () {
    return gulp
        .src(input__scss)
        .pipe(sass(sassOptions).on('error', sass.logError))
        .pipe(autoprefixer(autoprefixerOptions))
        .pipe(gulp.dest(project.css))
        .pipe(sassdoc(sassdocOptions))
        // Release the pressure back and trigger flowing mode (drain)
        // See: http://sassdoc.com/gulp/#drain-event
        .resume();
});

gulp.task('sassdoc', function () {
    return gulp
        .src(input__scss)
        .pipe(sassdoc(sassdocOptions))
        .resume();
});

gulp.task('js', function () {
    pump([
        gulp.src(__dirname + '/Assets/JavaScripts/**/*.js'),
        uglify({
            preserveComments: 'license'
        }),
        gulp.dest(project.js)
    ]);
});

gulp.task('watch', function () {
    return gulp.watch([__dirname + '/Assets/JavaScripts/*.js', input__scss], function () {
        gulp.start(['js', 'sass']);
    }).on('change', function (event) {
        console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
    });
});

gulp.task('default', ['sass', 'js', 'watch' /*, possible other tasks... */]);

gulp.task('prod', ['sassdoc'], function () {
    return gulp
        .src(input__scss)
        .pipe(sass({outputStyle: 'compressed'}))
        .pipe(autoprefixer(autoprefixerOptions))
        .pipe(gulp.dest(project.css));
});
