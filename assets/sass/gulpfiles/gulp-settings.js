const server = 'localhost';
const port = '80';

const assetFolder = './assets' + '/';
const sass = assetFolder + 'sass' + '/';
const css = assetFolder + 'css' + '/';
const js = assetFolder + 'js' + '/';
const images = assetFolder + 'images' + '/';
const font = assetFolder + 'webfonts' + '/';

module.exports = {
    root       : '../../../',
    server     : server,
    port       : port,
    assetFolder: assetFolder,
    cssPath    : css,
    jsPath     : js,
    imagesPath : images,
    fontPath   : font,
    sassPath   : sass,
    clearFolder: assetFolder + 'temp/',
    sass       : {
        importPath: {
            common: [
                sass + 'include/**/*'
            ],
            allCss: [
                sass + '*.scss'
            ],
        },
        exportPath: {
            common: [
                css
            ],
            allCss: [
                css
            ],
        },
    },
    js         : {
        importPath: {
            common: [
                sass + 'js/common/**/*'
            ],
            foot: [
                sass + 'js/*.js'
            ],
        },
        exportPath: {
            common: [
                js
            ],
            foot: [
                js
            ],
        }
    },
    images      : {
        importPath: {
            common: [
                // sass + 'js/common/**/*'
            ],
        },
        exportPath: {
            common: [
                images
            ]
        }
    }
};

