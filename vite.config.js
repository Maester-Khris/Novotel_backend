const path = require('path');

module.exports = {
  build: {
    rollupOptions: {
      input: {
        main: path.resolve(__dirname, 'resources/views/index.html')
      }
    }
  }
};
