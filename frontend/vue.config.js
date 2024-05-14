module.exports = {
    devServer: {
      proxy: {
        '/api': {
          target: 'http://127.0.0.1:8000',  // Specify the backend server URL
          changeOrigin: true,
          pathRewrite: {'^/api': ''}  // Remove '/api' from the request path
        }
      }
    }
  };
  