module.exports = function(grunt){
  require('load-grunt-tasks')(grunt); // npm install --save-dev load-grunt-tasks
  //require('time-grunt')(grunt); //if you want to add time-grunt
  grunt.initConfig({
    php: {
      dist: {
        options: {
		  port: 9000,
          hostname: 'localhost', //set IP，localhost or other domain name
          open: true, //auto open website http://
          keepalive: true,  // Any task specified after this will not run        
          base: [
            '.'  //set root directory
          ],
        }
      }
    },
  });
  grunt.loadNpmTasks('grunt-php');
  grunt.registerTask('server', [
    'php:dist',
  ]);
};
