var path = require('path');

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
        path: path.resolve(__dirname, 'src'),
        filename: 'script.js'
    },
    module: {
        loaders: [
            {test: /\.scss$/, loaders: ['style', 'css', 'sass?sourceMap']},
            {test: /\.es/, exclude: /node_modules/, loader: 'babel-loader'},
            {test: /\.woff(.*)?$/, loader: 'url?limit=60000'}
        ]
    }
};

if (!argv['prod']) {
    // development

    config.devServer = {
        contentBase: 'src/'
    };

    config.devtool = 'source-map';
} else {
    // production
    console.log('PRODUCTION!');
}

module.exports = config;
