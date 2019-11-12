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
  target: 'node', // https://webpack.js.org/concepts/targets/

  entry: {
    // 'app': path.resolve(__dirname, dir.js.src, 'app.js'),
    // 'polyfill': path.resolve(__dirname, dir.js.src, 'polyfill.js'),
    'home': path.resolve(__dirname, dir.js.src, 'home.js'),
    // 'start': path.resolve(__dirname, dir.js.src, 'start.js'),
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
    new webpack.DefinePlugin({
      'process.env': {
        'NODE_ENV': JSON.stringify('production'),
      },
    }),
  ],
};

moduleProd.entry = options.entry;
moduleProd.output = options.output;
moduleProd.watch = options.watch;
moduleProd.resolve = options.resolve;
moduleProd.module = options.module;
moduleProd.performance = options.performance;

module.exports = moduleProd;
