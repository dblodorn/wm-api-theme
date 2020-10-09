const { watch, src } = require('gulp');
const sftp = require('gulp-sftp-up4');
const config = require('./deploy.json');

const watchFolder = './wm-api/**/*';

function api(cb) {
  src(watchFolder)
    .pipe(sftp({
      host: config.sftp_host,
      user: config.sftp_user,
      remotePath: config.sftp_directory,
      passphrase: config.passphrase
    }));
  cb();
}

exports.default = function () {
  watch(watchFolder, api);
}
