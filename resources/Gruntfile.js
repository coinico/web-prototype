// Sample project configuration.
module.exports = function(grunt) {

    grunt.initConfig({
        concat: {
            dist: {
                src: [
                    /* Components */
                    'assets/js/components/jquery.validate.min.js',
                    'assets/js/components/header-scroll.js',
                    'assets/js/components/preloading.js',
                    'assets/js/components/location.js',
                    'assets/js/components/scroll.js',
                    'assets/js/components/scrollTo.js',
                    'assets/js/plugins/owl.carousel.min.js',
                    'assets/js/plugins/segment.min.js',
                    'assets/js/plugins/ease.min.js',

                    /*Sections*/
                    'assets/js/sections/*.js'
                ],
                dest: 'assets/js/app.min.js'
            }
        },

        
        uglify: {
            options: {
              //mangle: false
            },
            my_target: {
              files: {
                'assets/js/app.min.js': ['assets/js/app.min.js']
              }
            }
        },       
       
        compass: {
            dev: {
                dist: {
                    options: {
                        sassDir: 'assets/css/scss',
                        cssDir: 'assets/css',
                        outputStyle: 'nested'
                    }
                }
            },
            prod: {
                dist: {
                    options: {
                        sassDir: 'assets/css/scss',
                        cssDir: 'assets/css',
                        outputStyle: 'nested'
                    }
                }
            },
        },
        
        watch: {
            watch_js_files: {
                files : ['assets/js/**/*.js','!assets/js/app.min.js'],
                tasks : ['concat','uglify']
            },
            watch_css_files: {
                files : ['assets/css/scss/**/*.scss'],
                tasks : ['compass:dev']
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-jshint');

    // Default, to be used on development environments
    grunt.registerTask('default', ['watch']);

    // Post Commit, to be executed after commit
    grunt.registerTask('deploy', ['watch','concat', 'uglify', 'compass:prod']);

}
