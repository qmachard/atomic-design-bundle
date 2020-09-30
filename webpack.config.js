var Encore = require('@symfony/webpack-encore');

Encore
  .setOutputPath('./src/Resources/public/')
  .setPublicPath('/')
  .setManifestKeyPrefix('bundles/atomic-design')

  .cleanupOutputBeforeBuild()
  .enableSassLoader()
  .enableSourceMaps(false)
  .enableVersioning(false)
  .disableSingleRuntimeChunk()
  .autoProvidejQuery()

  .addEntry('app', './assets/js/app.js')

module.exports = Encore.getWebpackConfig();
