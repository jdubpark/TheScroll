const
  path = require('path'),
  dir = {
    js: {
      src: 'public/lib/script/src/',
      dist: 'public/lib/script/dist/',
    },
  },
  webpack = require('webpack'),
  BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

const options = {
  mode: 'production',
  target: 'web', // https://webpack.js.org/concepts/targets/
  node: {
    fs: 'empty', // prevent 'Module not found: Error: Can't resolve 'fs''
  },

  entry: {
    // 'app': path.resolve(__dirname, dir.js.src, 'app.js'),
    // 'polyfill': path.resolve(__dirname, dir.js.src, 'polyfill.js'),
    'home': path.resolve(__dirname, dir.js.src, 'home.js'),
    'article': path.resolve(__dirname, dir.js.src, 'article.js'),
    'section': path.resolve(__dirname, dir.js.src, 'section.js'),
    // 'auth': path.resolve(__dirname, dir.js.src, 'auth.js'),
    // 'dashboard': path.resolve(__dirname, dir.js.src, 'dashboard.js'),
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

const moduleProd = {
  devtool: 'source-map',
  plugins: [
    new BundleAnalyzerPlugin(),
    new webpack.optimize.OccurrenceOrderPlugin(),
    // ensure that we get a production build of any dependencies
    // by adding process.env
    new webpack.DefinePlugin({
      'process.env': {
        'NODE_ENV': JSON.stringify('production'),
      },
    }),
  ],
};


options.devtool = moduleProd.devtool;
options.plugins = moduleProd.plugins;

module.exports = options;
