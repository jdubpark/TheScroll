const
  path = require('path'),
  dir = {
    js: {
      src: 'public/lib/script/src/',
      dist: 'public/lib/script/dist/',
    },
  };

module.exports = {
  mode: 'production',
  target: 'node', // https://webpack.js.org/concepts/targets/

  entry: {
    'app': path.resolve(__dirname, dir.js.src, 'app.js'),
    'polyfill': path.resolve(__dirname, dir.js.src, 'polyfill.js'),
    'home': path.resolve(__dirname, dir.js.src, 'home.js'),
    // 'start': path.resolve(__dirname, dir.js.src, 'start.js'),
    'auth': path.resolve(__dirname, dir.js.src, 'auth.js'),
    'dashboard': path.resolve(__dirname, dir.js.src, 'dashboard.js'),
  },

  output: {
    filename: '[name].bundle.js',
    path: path.resolve(__dirname, dir.js.dist),
  },

  devtool: 'inline-source-map',
  watch: true,

  module: {
    rules: [
      {
        test: /\.m?js$/,
        exclude: /(node_modules|bower_components)/,
        use: {
          // https://github.com/babel/babel-loader
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env'],
            cacheDirectory: true,
          },
        },
      },
    ],
  },

  stats: {
    assets: true,
    colors: true,
    version: false,
    hash: true,
    timings: true,
    chunks: true,
    chunkModules: true,
  },

  performance: {
    hints: false,
  },

};
