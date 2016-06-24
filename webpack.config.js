var path = require('path');
var webpack = require('webpack');
var CleanWebpackPlugin = require('clean-webpack-plugin');
var CopyWebpackPlugin = require('copy-webpack-plugin');
var deployDir = require('./package.json').config.deployTo;

deployDir = path.resolve(__dirname, deployDir);
compileDir = path.resolve(__dirname, 'compiled');

// parse arguments
var argv = {};
process.argv.slice(2).forEach(function (arg) {
    arg = arg.replace(/^-?-?\/?/ ,'').toLowerCase().split('=');
    argv[arg[0]] = arg[1] || true;
});

// main config
var config = {
    entry: {
        app: ['./src/app.es']
    },
    output: {
        path: compileDir,
        filename: 'script.js',
        publicPath: '/'
    },
    module: {
        loaders: [
            { test: /\.scss$/, loaders: ['style', 'css', 'sass?sourceMap'] },
            { test: /\.es(6)?$/, exclude: /node_modules/, loader: 'babel-loader' },
            { test: /\.woff(.*)?$/, loader: 'url?limit=65536' },
            { test: /\.(png|jpg|gif)$/, loader: 'url-loader?limit=8192' },
            { test: /\.json(5)?$/, loader: 'json5' },
            { test: /\.html$/, loader: 'html' }
        ]
    },
    plugins: []
};

if (!argv['p']) {
    // development
    config.cache = true;
    config.devtool = 'source-map';
    config.devServer = {
        contentBase: 'src/'
    };

} else {
    // production
    console.log('Preparing PRODUCTION build in "' + deployDir + '" folder\n');

    config.cache = false;
    config.devtool = 'cheap-source-map';

    config.plugins.push(
        new webpack.DefinePlugin({
            'process.env': {
                'NODE_ENV': JSON.stringify('production')
            }
        }),
        new webpack.optimize.DedupePlugin(),
        new webpack.optimize.OccurenceOrderPlugin(true),
        new webpack.optimize.UglifyJsPlugin({
            // sourceMap: false,
            compress: {
                sequences: true,
                dead_code: true,
                unused: true,
                cascade: true,
                warnings: false
            },
            'screw-ie8': true, // not sere which is correct
            screw_ie8: true
        }),
        new CleanWebpackPlugin([deployDir], {
            verbose: true
        }),
        new CopyWebpackPlugin([
            { from: 'src/index.html',                               to: deployDir },
            { from: path.resolve(compileDir, 'script.js'),          to: deployDir },
            { from: 'src/gfx',                                      to: path.resolve(deployDir, 'gfx') },
            { from: 'src/res',                                      to: path.resolve(deployDir, 'res') }
        ])
    );
}

module.exports = config;
