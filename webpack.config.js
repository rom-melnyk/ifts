var path = require('path');

module.exports = {
    entry: './src/app.es',
    output: {
        path: path.resolve(__dirname, 'src'),
        filename: 'bundle.js'
    },
    module: {
        loaders: [
            { test: /\.scss$/, loaders: ['style', 'css', 'sass?sourceMap'] },
            { test: /\.es/, exclude: /node_modules/, loader: 'babel-loader' },
            { test: /\.woff(.*)?$/, loader: 'url?limit=60000' },
        ]
    },
    devServer: {
        hot: true
    },
    devtool: 'source-map'
};
