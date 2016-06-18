var path = require('path');

module.exports = {
    entry: './src/app.es',
    output: {
        path: path.resolve(__dirname, 'src'),
        filename: 'bundle.js'
    },
    module: {
        loaders: [
            { test: /\.css$/, loader: 'style!css' },
            { test: /\.scss$/, loaders: ['style', 'css', 'sass'] },
            { test: /\.es/, loader: 'babel-loader' }
        ]
    },
    devServer: {
        hot: true
    },
    devtool: 'source-map'
};
