#Starter theme for wordpress
Custom fields are made with Carbon Fields. 
Code samples from ```samples/``` can be removed.

## Front-end
general config - ```config/config.js```,

styles - ```src/scss```,

js for webpack - ```src/js```, 

js for gulp - ```assets/js/app.js```

Bootstrap and swiper are already included. 

### Webpack setup
```npm start``` - development with livereload, scss and js

```npm run build``` - build script

### Gulp setup
To use gulp install dependencies: 
```
npm install gulp gulp-cli gulp-if gulp-postcss gulp-sass gulp-sourcemaps yargs node-sass-package-importer beeper@2 gulp-rename --save-dev
```
And optionally delete webpack packages:
```
npm uninstall --save-dev babel-loader @babel/core @babel/preset-env browser-sync-webpack-plugin clean-webpack-plugin css-loader mini-css-extract-plugin postcss-loader sass-loader webpack webpack-cli webpack-fix-style-only-entries webpack-merge postcss fibers
```

```npm run gulp:start``` - development with livereload and scss

```npm run gulp:build``` - build script
