import gulp from 'gulp';
import sass from 'gulp-sass';
import dartSass from 'sass';
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';
import cleanCSS from 'gulp-clean-css';
import sourcemaps from 'gulp-sourcemaps';
import plumber from 'gulp-plumber';

import { rollup } from 'rollup';
import { nodeResolve } from '@rollup/plugin-node-resolve';
import commonjs from '@rollup/plugin-commonjs';
import { terser } from 'rollup-plugin-terser';

import sharp from 'sharp';
import { promises as fs } from 'fs';
import path from 'path';

const { src, dest, watch, parallel, series } = gulp;
const scssCompiler = sass(dartSass);

// -------------------- PATHS --------------------
const paths = {
  scss: './srcs/scss/**/*.scss',
  js: './srcs/js/**/*.js',
  imgs: ['./srcs/imgs/**/*.{jpg,png}', '!./srcs/imgs/icons/**/*.png'],
  // icons: './srcs/imgs/icons/*',
  fonts: './srcs/fonts/**/*.ttf',
  dest: {
    base: './public/build/',
    imgs: './public/build/imgs',
    icons: './public/build/imgs/icons',
    webp: './public/build/imgs/webp',
    avif: './public/build/imgs/avif',
    css: './public/build/css',
    js: './public/build/js',
    fonts: './public/build/fonts'
  }
};

// -------------------- SCSS --------------------
function styles() {
  return src(paths.scss)
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(scssCompiler().on('error', scssCompiler.logError))
    .pipe(postcss([autoprefixer()]))
    .pipe(cleanCSS())
    .pipe(sourcemaps.write('.'))
    .pipe(dest(paths.dest.css));
}

// -------------------- JS MODULAR --------------------
async function scripts() {
  const bundle = await rollup({
    input: './srcs/js/main.js',
    plugins: [nodeResolve(), commonjs(), terser()]
  });

  await bundle.write({
    file: paths.dest.js + '/bundle.js',
    format: 'iife',
    sourcemap: true
  });
}

// -------------------- FUENTES --------------------
// function fonts() {
//   return src(paths.fonts, { nodir: true }).pipe(dest(paths.dest.fonts));
// }

// -------------------- IMÁGENES --------------------
async function procesarImagen(file) {
  const inputPath = file.path;
  const ext = path.extname(inputPath).toLowerCase();
  const baseName = path.basename(inputPath, ext);

  await fs.mkdir(paths.dest.imgs, { recursive: true });
  await fs.mkdir(paths.dest.webp, { recursive: true });
  await fs.mkdir(paths.dest.avif, { recursive: true });

  // Copia original
  await sharp(inputPath).toFile(path.join(paths.dest.imgs, baseName + ext));
  // WebP
  await sharp(inputPath)
    .webp({ quality: 80 })
    .toFile(path.join(paths.dest.webp, baseName + '.webp'));
  // AVIF
  await sharp(inputPath)
    .avif({ quality: 50 })
    .toFile(path.join(paths.dest.avif, baseName + '.avif'));
}

async function eliminarImagen(file) {
  const ext = path.extname(file).toLowerCase();
  const baseName = path.basename(file, ext);

  const filesToDelete = [
    path.join(paths.dest.imgs, baseName + ext),
    path.join(paths.dest.webp, baseName + '.webp'),
    path.join(paths.dest.avif, baseName + '.avif')
  ];

  for (const f of filesToDelete) {
    try {
      await fs.unlink(f);
    } catch (err) {
      // ignorar si no existe
    }
  }
}

function imagenes(done) {
  src(paths.imgs, { nodir: true })
    .on('data', (file) => procesarImagen(file))
    .on('end', done);
}

// function icons() {
//   return src(paths.icons)
//     .pipe(dest(paths.dest.icons))
// }

// -------------------- WATCH --------------------
function watchFiles() {
  watch(paths.scss, styles);
  watch(paths.js, scripts);
  const watcher = watch(paths.imgs);
  watcher.on('add', (file) => procesarImagen({ path: file }));
  watcher.on('change', (file) => procesarImagen({ path: file }));
  watcher.on('unlink', (file) => eliminarImagen(file));
}

// -------------------- EXPORT --------------------
export default series(
  parallel(styles, scripts, imagenes),
  watchFiles
);