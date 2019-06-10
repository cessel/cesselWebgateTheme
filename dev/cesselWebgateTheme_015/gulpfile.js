var gulp        = require("gulp"),
    sass        = require("gulp-sass"),
    compass     = require('gulp-compass'),
    concat      = require('gulp-concat'),
    uglify      = require('gulp-uglifyjs'),
    cssnano     = require('gulp-cssnano'),
    rename      = require('gulp-rename'),
    imgmin      = require('gulp-imagemin'),
    pngq        = require('imagemin-pngquant'),
    autopref    = require('gulp-autoprefixer'),
    plumber     = require('gulp-plumber'),
    fontello    = require('gulp-fontello'),
    cache       = require('gulp-cache'),
    gcmq        = require('group-css-media-queries');


gulp.task("sass",function(done)
{
    return gulp.src('sass/**/*.+(sass|scss)')
    /*.pipe(compass({
        config_file: __dirname + '/config/compass.rb',
        sass: 'sass',
        css:'css'
    })).on('error', function(error) {
        // у нас ошибка
        done("ОШИБКА1" + error);
    })*/
        .pipe(sass({outputStyle: 'compact', precision: 10})
            .on('error', sass.logError)
        )
        .pipe(autopref(['last 15 versions','> 1%', 'ie 8', 'ie 7'],{'cascade':true})).on('error', function(error) {
            // у нас ошибка
            done("ОШИБКА2" + error);
        })
        .pipe(gulp.dest('css'));
});
gulp.task('icons-prepare', function () {
    return gulp.src('assets/fontello/config.json')
        .pipe(fontello())
        .pipe(gulp.dest('assets/fontello'))
        .pipe(gulp.dest('css/'));

});

gulp.task('icons',gulp.series('icons-prepare',function(done)
{
    return gulp.src(
        [
            'assets/fontello/css/animation.css',
            'assets/fontello/css/fontello.css',
        ])
        .pipe(concat('fontello_animated.css'))
        .pipe(gulp.dest('assets/fontello/'));
}));

gulp.task('css-libs',gulp.series('icons',function(done)
{
    done();
    return gulp.src(
        [
            'lib/owl.carousel/dist/assets/owl.carousel.min.css',
            'lib/animate.css/animate.min.css',
            'lib/hover/css/hover-min.css',
            'lib/font-awesome/css/font-awesome.min.css',
            'assets/fontello/fontello_animated.css',
        ])
        .pipe(cssnano())
        .pipe(concat('libs.min.css'))
        .pipe(gulp.dest('css/libs/'));
}));

gulp.task('css-main-dist',gulp.series('sass', function (done) {
    gulp.src('css/*.css')
        .pipe(gcmq())
        .pipe(cssnano())
        .pipe(concat('style.min.css'))
        .pipe(gulp.dest('css'));
    done();
}));

gulp.task('scripts',function()
{
    return gulp.src(
        [
            'lib/jquery/dist/jquery.js',
            'lib/jquery-migrate/jquery-migrate.min.js',
            "lib/popper.js/dist/umd/popper.min.js",
            'lib/bootstrap/dist/js/bootstrap.min.js',
            'lib/owl.carousel/dist/owl.carousel.min.js',
            'lib/jquery.scrollTo/jquery.scrollTo.min.js'
        ])
        .pipe(concat('libs.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('js/libs/'));
});

gulp.task('img',function()
{
    return gulp.src
    (
        'img/**/*.*'
    )
        .pipe(cache(imgmin(
            {
                interlaces:true
                ,progressive:true
                ,svgoPlugins:[{removeViewBox:false}]
                ,use:[pngq()]
            }
        )))
        .pipe(gulp.dest('img'));
});

gulp.task('prepare-scripts',gulp.series('scripts','css-libs'));

gulp.task('default',gulp.series('icons','prepare-scripts','sass',function(done)
{
    done();
    gulp.watch('sass/**/*.+(sass|scss)',gulp.series('sass'));
}));
