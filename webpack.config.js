const path = require('path');

module.exports = {
    entry: './resources/js/app.js',  // 例: './resources/js/app.js'
    output: {
        filename: 'bundle.js',
        path: path.resolve(__dirname, 'public/js'),  // 出力先ディレクトリ
    },
    // その他の設定
};
