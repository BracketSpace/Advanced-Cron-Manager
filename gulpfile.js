///////////////
// Variables //
///////////////
import gulp from 'gulp';
import gulpSass from 'gulp-sass';
import dartSass from 'sass';
import sourcemaps from 'gulp-sourcemaps';
import autoprefixer from 'gulp-autoprefixer';
import uglify from 'gulp-uglify';
import concat from 'gulp-concat';
import imagemin from 'gulp-imagemin';
import order from 'gulp-order';

const sass = gulpSass( dartSass );

const style_sources = 'assets/src/sass/**/*.scss';
const style_target  = 'assets/dist/css';

const script_sources = 'assets/src/js/**/*.js';
const script_target = 'assets/dist/js';

///////////
// Tasks //
///////////
gulp.task( 'css', async function() {
	gulp.src( style_sources )
		.pipe( sourcemaps.init() )
		.pipe( sass( { outputStyle: 'compressed' } ).on( 'error', sass.logError ) )
		.pipe( autoprefixer() )
		.pipe( sourcemaps.write() )
		.pipe( gulp.dest( style_target ) );
} );

gulp.task( 'js', async function() {
	gulp.src( script_sources )
		.pipe( sourcemaps.init() )
		.pipe( concat( 'scripts.min.js' ) )
		.pipe( uglify() )
		.pipe( sourcemaps.write() )
		.pipe( gulp.dest( script_target ) );
} );

//////////////////////
// Default - Build //
/////////////////////
gulp.task( 'default', gulp.series('css', 'js'));

///////////
// Watch //
///////////
gulp.task( 'watch', function() {

	gulp.watch( style_sources, ['css'] );
	gulp.watch( script_sources, ['js'] );

} );
